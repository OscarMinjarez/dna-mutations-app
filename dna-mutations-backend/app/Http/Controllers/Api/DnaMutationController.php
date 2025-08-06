<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DnaMutationService;
use Illuminate\Http\Request;

class DnaMutationController extends Controller
{
    public function __construct(private readonly DnaMutationService $dnaMutationService)
    {
    }

    public function checkMutation(Request $request) {
        $dna = $request->input('dna');
        if (!is_array($dna) || empty($dna)) {
            return response()->json(['error' => __('errors.dna_must_be_array')], 422);
        }
        try {
            $mutation = $this->dnaMutationService->hasMutation($dna);
            if (!$mutation->has_mutation) {
                return response()->json([
                    'message' => __('messages.no_mutation_detected'),
                    'dna' => $mutation->_id,
                    'mutation' => false
                ], 403);
            }
            return response()->json([
                'message' => __('messages.mutation_detected'),
                'dna' => $mutation->_id,
                'mutation' => true
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function stats(Request $request) {
        $perPage = (int) $request->input('per_page', 10);
        $hasMutation = $request->has('mutation') ? filter_var($request->input('mutation'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null;
        return response()->json(
            $this->dnaMutationService->getRecentSequences($hasMutation, $perPage)
        );
    }

    public function all() {
        return $this->dnaMutationService->getStatsSummary();
    }
}
