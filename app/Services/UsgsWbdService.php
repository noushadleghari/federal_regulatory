<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsgsWbdService
{
    public function fetchData(): array
    {
        $endpoint = 'https://hydro.nationalmap.gov/arcgis/rest/services/wbd/MapServer/6/query';

        try {
            $response = Http::timeout(30)->get($endpoint, [
                'geometry' => '-77.3064,38.8462',
                'geometryType' => 'esriGeometryPoint',
                'inSR' => 4326,
                'spatialRel' => 'esriSpatialRelIntersects',
                'outFields' => 'HUC12,NAME,AREASQKM,STATES',
                'returnGeometry' => 'false',
                'f' => 'json',
            ]);

            return [
                'status' => $response->status(),
                'name' => 'USGS WBD',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USGS WBD',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}