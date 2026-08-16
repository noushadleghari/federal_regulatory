<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EpaAcresService
{
    public function fetchData(): array
    {
        $endpoint = 'https://geopub.epa.gov/ArcGIS/rest/services/EMEF/efpoints/MapServer/5/query';

        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->get($endpoint, [
                    'where' => "state_code = 'VA'",
                    'outFields' => '*',
                    'returnGeometry' => 'true',
                    'outSR' => 4326,
                    'resultRecordCount' => 10,
                    'f' => 'json',
                ]);

            return [
                'status' => $response->status(),
                'name' => 'EPA ACRES / Brownfields',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'EPA ACRES / Brownfields',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}