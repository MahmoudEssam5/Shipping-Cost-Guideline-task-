<?php

namespace App\Services;

use App\Models\RemoteArea;
use App\Models\ShippingCostRule;
use http\Env\Request;

class ShippingCostCalculator
{
    public function calculate(array $data): array
    {
        $city = $data['city'];
        $area = $data['area'];
        $shipmentCount = $data['shipment_count'];
        $weight = $data['weight'];
        $dimensions = $data['dimensions'];

        $isRemote = RemoteArea::where('city', $city)->where('area', $area)->exists();
        $zoneType = $isRemote ? 'remote' : 'normal';

        $rule = ShippingCostRule::where('zone_type', $zoneType)
            ->where('shipment_tier_min', '<=', $shipmentCount)
            ->where(function ($q) use ($shipmentCount) {
                $q->where('shipment_tier_max', '>=', $shipmentCount)
                    ->orWhereNull('shipment_tier_max');
            })->firstOrFail();

        $volumetricWeight = ($dimensions['length'] * $dimensions['width'] * $dimensions['height']) / 5000;
        $usedWeight = max($weight, $volumetricWeight);

        if ($usedWeight > $rule->max_weight_kg) {
            throw new \Exception("Weight exceeds max allowed weight ({$rule->max_weight_kg}kg).");
        }else {
            $extraWeightCharge = 0;
            $extraWeight = 0;
        }


        $baseCost = $rule->base_cost;

        if ($usedWeight > $rule->extra_weight_threshold_kg) {
            $extraWeight = $usedWeight - $rule->extra_weight_threshold_kg;
            $extraWeightCharge = $extraWeight * $rule->extra_weight_charge_per_kg;
        }


        $subtotal1 = $baseCost + $extraWeightCharge;
        $fuel = $subtotal1 * ($rule->fuel_surcharge_percent / 100);
        $subtotal2 = $subtotal1 + $fuel;

        $packaging = $rule->packaging_fee;
        $subtotal3 = $subtotal2 + $packaging;

        $epg = max($subtotal3 * ($rule->epg_fee_percent / 100), $rule->epg_fee_minimum);
        $subtotal4 = $subtotal3 + $epg;

        $vat = $subtotal4 * ($rule->vat_percent / 100);
        $final = $subtotal4 + $vat;

        return [
            'base_cost' => $baseCost,
            'uesd_weight' => $extraWeight,
            'extra_weight_charge' => $extraWeightCharge,
            'subtotal_1' => $subtotal1,
            'fuel_surcharge' => $fuel,
            'subtotal_2' => $subtotal2,
            'packaging_cost' => $packaging,
            'subtotal_3' => $subtotal3,
            'epg_charge' => $epg,
            'subtotal_4' => $subtotal4,
            'vat' => $vat,
            'final_price' => round($final, 2),
        ];
    }

}
