<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsgsNhdService
{
    public function fetchData(): array
    {
        $endpoint = 'https://hydro.nationalmap.gov/arcgis/rest/services/nhd/MapServer/0/query';

        try {
            $response = Http::timeout(30)->get($endpoint, [
                'where' => '1=1',
                'outFields' => 'GNIS_NAME,REACHCODE',
                'returnGeometry' => 'false',
                'resultRecordCount' => 1,
                'f' => 'json',
            ]);

            return [
                'status' => $response->status(),
                'name' => 'USGS NHD',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USGS NHD',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}