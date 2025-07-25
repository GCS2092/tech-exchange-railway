<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DeliveryService;
use App\Models\DeliveryOption;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    protected $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function getOptions()
    {
        try {
            $options = $this->deliveryService->getAvailableOptions();
            $zones = $this->deliveryService->getZones();
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'options' => $options,
                    'zones' => $zones
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function calculateCost(Request $request)
    {
        try {
            $request->validate([
                'zone' => 'required|string|in:zone1,zone2,zone3',
                'delivery_option_id' => 'required|exists:delivery_options,id'
            ]);

            $cost = $this->deliveryService->getDeliveryCost($request->zone);
            $option = DeliveryOption::find($request->delivery_option_id);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'zone' => $request->zone,
                    'cost' => $cost,
                    'option' => $option
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 