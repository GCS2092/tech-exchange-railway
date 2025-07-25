<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\OnboardingHelper;
use Illuminate\Http\JsonResponse;

class OnboardingController extends Controller
{
    /**
     * Marquer un tour comme vu
     */
    public function markAsSeen(Request $request): JsonResponse
    {
        $request->validate([
            'tour_id' => 'required|string',
        ]);

        $tourId = $request->input('tour_id');
        $userId = auth()->id();

        OnboardingHelper::markTourAsSeen($userId, $tourId);

        return response()->json([
            'success' => true,
            'message' => 'Tour marqué comme vu'
        ]);
    }

    /**
     * Vérifier si un utilisateur a vu un tour
     */
    public function hasSeen(Request $request): JsonResponse
    {
        $request->validate([
            'tour_id' => 'required|string',
        ]);

        $tourId = $request->input('tour_id');
        $userId = auth()->id();

        $hasSeen = OnboardingHelper::hasSeenTour($userId, $tourId);

        return response()->json([
            'has_seen' => $hasSeen
        ]);
    }

    /**
     * Obtenir les étapes d'un tour
     */
    public function getSteps(Request $request): JsonResponse
    {
        $request->validate([
            'tour_id' => 'required|string',
        ]);

        $tourId = $request->input('tour_id');
        $steps = OnboardingHelper::getTourSteps($tourId);

        return response()->json([
            'steps' => $steps
        ]);
    }

    /**
     * Réinitialiser l'état d'un tour (pour les tests ou le développement)
     */
    public function reset(Request $request): JsonResponse
    {
        $request->validate([
            'tour_id' => 'required|string',
        ]);

        $tourId = $request->input('tour_id');
        
        // Supprimer du localStorage côté client
        return response()->json([
            'success' => true,
            'message' => 'Tour réinitialisé',
            'script' => "localStorage.removeItem('tour-{$tourId}-completed');"
        ]);
    }
} 