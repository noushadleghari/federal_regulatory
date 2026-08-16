<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsdaNrcsSsurgoService
{
    public function fetchData(): array
    {
        $endpoint = 'https://SDMDataAccess.sc.egov.usda.gov/Spatial/SDMWGS84Geographic.wfs';

        try {
            $response = Http::timeout(60)->get($endpoint, [
                'service' => 'WFS',
                'version' => '1.1.0',
                'request' => 'GetFeature',
                'typeName' => 'MapunitPoly',
                'BBOX' => '-77.1,38.8,-77.0,38.9',
                'maxFeatures' => 10,
            ]);

            return [
                'status' => $response->status(),
                'name' => 'USDA NRCS SSURGO',
                'endpoint' => $endpoint,
                'response' => $response->body(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USDA NRCS SSURGO',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}