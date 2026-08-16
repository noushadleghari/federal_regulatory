<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AirNowService
{
    public function fetchData(): array
    {
        $endpoint = 'https://www.airnowapi.org/aq/observation/latLong/current/';

        try {
            $response = Http::timeout(60)->get($endpoint, [
                'latitude' => 38.8462,
                'longitude' => -77.3064,
                'distance' => 25,
                'API_KEY' => env('AIRNOW_API_KEY'),
                'format' => 'application/json',
            ]);

            return [
                'status' => $response->status(),
                'name' => 'EPA AirNow Current Observations',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'EPA AirNow Current Observations',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}