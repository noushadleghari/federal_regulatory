<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class NoaaCoastService
{
    private string $endpoint =
        'https://www.coast.noaa.gov/arcgis/rest/services/dc_slr/slr_7ft/MapServer/1/query';

    public function fetchData(): array
    {
        $payload = [
            'where' => '1=1',
            'outFields' => '*',
            'returnGeometry' => false,
            'resultRecordCount' => 10,
            'f' => 'json',
        ];

        try {
            $response = Http::timeout(30)
                ->get($this->endpoint, $payload);

            return [
                'status' => $response->status(),
                'working' => $response->successful(),
                'response' => $response->json(),
                'payload' => $payload,
                'name' => 'NOAA Office for Coastal Management - Sea Level Rise',
                'endpoint' => $this->endpoint,
            ];
        } catch (Throwable $e) {
            return [
                'status' => 500,
                'working' => false,
                'response' => [
                    'message' => $e->getMessage(),
                ],
                'payload' => $payload,
                'name' => 'NOAA Office for Coastal Management - Sea Level Rise',
                'endpoint' => $this->endpoint,
            ];
        }
    }
}