<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCostRule extends Model
{
    protected $fillable = [
        'shipment_tier_min',
        'shipment_tier_max',
        'zone_type',
        'base_cost',
        'extra_weight_threshold_kg',
        'extra_weight_charge_per_kg',
        'fuel_surcharge_percent',
        'packaging_fee',
        'epg_fee_percent',
        'epg_fee_minimum',
        'vat_percent',
        'max_weight_kg',
    ];
}
