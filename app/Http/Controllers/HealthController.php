<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $database = rescue(
            fn () => DB::connection()->getPdo() ? 'connected' : 'disconnected',
            'disconnected',
            false,
        );

        $healthy = $database === 'connected';

        return response()->json([
            'status' => $healthy ? 'healthy' : 'unhealthy',
            'timestamp' => now()->toISOString(),
            'database' => $database,
        ], $healthy ? 200 : 503);
    }
}
