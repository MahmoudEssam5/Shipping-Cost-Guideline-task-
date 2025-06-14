<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShippingController;

Route::post('/shipping/calculate', [ShippingController::class, 'calculateShipping']);
