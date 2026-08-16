<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsgssStreamStatsService
{
    public function fetchData(): array
    {
        $region = 'VA';

        $endpoint = "https://streamstats.usgs.gov/ss-delineate/v1/delineate/sshydro/{$region}";

        try {
            $response = Http::timeout(60)->get($endpoint, [
                'lat' => 38.8462,
                'lon' => -77.3064,
            ]);

            return [
                'status' => $response->status(),
                'name' => 'USGS StreamStats SSHydro Watershed Delineation',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USGS StreamStats SSHydro Watershed Delineation',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}