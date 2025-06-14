<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipping_cost_rules', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('shipment_tier_min');
            $table->unsignedInteger('shipment_tier_max')->nullable();
            $table->enum('zone_type', ['normal', 'remote']);
            $table->decimal('base_cost', 10, 2);
            $table->unsignedInteger('extra_weight_threshold_kg')->default(5);
            $table->decimal('extra_weight_charge_per_kg', 10, 2)->default(2.00);
            $table->decimal('fuel_surcharge_percent', 5, 2)->default(2.00);
            $table->decimal('packaging_fee', 10, 2)->default(5.25);
            $table->decimal('epg_fee_percent', 5, 2)->default(10.00);
            $table->decimal('epg_fee_minimum', 10, 2)->default(2.00);
            $table->decimal('vat_percent', 5, 2)->default(5.00);
            $table->unsignedInteger('max_weight_kg')->default(20);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_cost_rules');
    }
};
