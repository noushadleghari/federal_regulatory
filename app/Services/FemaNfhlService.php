<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FemaNfhlService
{
    public function fetchData(): array
    {
        $endpoint = 'https://hazards.fema.gov/gis/nfhl/rest/services/public/NFHL/MapServer/28/query';

        try {
            $response = Http::timeout(30)->get($endpoint, [
                'geometry' => '-96.6666,32.333',
                'geometryType' => 'esriGeometryPoint',
                'inSR' => 4326,
                'spatialRel' => 'esriSpatialRelWithin',
                'outFields' => 'FLD_ZONE,ZONE_SUBTY',
                'returnGeometry' => 'false',
                'f' => 'json',
            ]);

            return [
                'status' => $response->status(),
                'name' => 'FEMA NFHL',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'FEMA NFHL',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}