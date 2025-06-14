<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingCostRulesSeeder extends Seeder
{
    public function run(): void
    {
        $commonData = [
            'extra_weight_threshold_kg' => 5,
            'extra_weight_charge_per_kg' => 2.00,
            'fuel_surcharge_percent' => 2.00,
            'packaging_fee' => 5.25,
            'epg_fee_percent' => 10.00,
            'epg_fee_minimum' => 2.00,
            'vat_percent' => 5.00,
            'max_weight_kg' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $rules = [
            [
                'shipment_tier_min' => 0,
                'shipment_tier_max' => 250,
                'zone_type' => 'normal',
                'base_cost' => 14.00,
            ],
            [
                'shipment_tier_min' => 251,
                'shipment_tier_max' => 500,
                'zone_type' => 'normal',
                'base_cost' => 12.00,
            ],
            [
                'shipment_tier_min' => 501,
                'shipment_tier_max' => null,
                'zone_type' => 'normal',
                'base_cost' => 11.00,
            ],
            [
                'shipment_tier_min' => 0,
                'shipment_tier_max' => 250,
                'zone_type' => 'remote',
                'base_cost' => 49.00,
            ],
            [
                'shipment_tier_min' => 251,
                'shipment_tier_max' => 500,
                'zone_type' => 'remote',
                'base_cost' => 47.00,
            ],
            [
                'shipment_tier_min' => 501,
                'shipment_tier_max' => null,
                'zone_type' => 'remote',
                'base_cost' => 46.00,
            ],
        ];

        foreach ($rules as $rule) {
            DB::table('shipping_cost_rules')->insert(array_merge($rule, $commonData));
        }
    }
}
