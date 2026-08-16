<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NoaaSeaLevelRiseService
{
    public function fetchData(): array
    {
        $endpoint = 'https://coast.noaa.gov/arcgis/rest/services/dc_slr/slr_5ft/MapServer';

        try {
            $response = Http::timeout(30)->get($endpoint, [
                'f' => 'json',
            ]);

            return [
                'status' => $response->status(),
                'name' => 'NOAA Sea Level Rise',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'NOAA Sea Level Rise',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}