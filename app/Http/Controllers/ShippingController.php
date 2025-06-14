<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ShippingCostCalculator;

class ShippingController extends Controller
{
    public function calculateShipping(Request $request, ShippingCostCalculator $calculator)
    {
        $data = $request->validate([
            'city' => 'required|string',
            'area' => 'required|string',
            'shipment_count' => 'required|integer',
            'weight' => 'required|numeric',
            'dimensions.length' => 'required|numeric',
            'dimensions.width' => 'required|numeric',
            'dimensions.height' => 'required|numeric',
        ]);

        $weight = $data['weight'];
        $calculator = new ShippingCostCalculator();
        $result = $calculator->calculate($data);

        return response()->json([
            'success' => true,
            'breakdown' => [
                'Base Cost' => number_format($result['base_cost'], 2) . ' AED',
                'Extra Weight (' . number_format($weight, 1) . ' KG × 2 AED)' => number_format($result['extra_weight_charge'], 2) . ' AED',
                'Subtotal 1' => number_format($result['subtotal_1'], 2) . ' AED',
                'Fuel Surcharge (2%)' => number_format($result['fuel_surcharge'], 2) . ' AED',
                'Subtotal 2' => number_format($result['subtotal_2'], 2) . ' AED',
                'Packaging Cost' => number_format($result['packaging_cost'], 2) . ' AED',
                'Subtotal 3' => number_format($result['subtotal_3'], 2) . ' AED',
                'EPG Charges (10%, min 2 AED)' => number_format($result['epg_charge'], 2) . ' AED',
                'Subtotal 4' => number_format($result['subtotal_4'], 2) . ' AED',
                'VAT (5%)' => number_format($result['vat'], 2) . ' AED',
                'Final Price' => number_format($result['final_price'], 2) . ' AED',
            ]
        ]);

    }
}
