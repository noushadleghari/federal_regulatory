<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FemaNriService
{
    public function fetchData(): array
    {
        $endpoint = 'https://services.arcgis.com/PcBYuZP9vTIZ3FcN/ArcGIS/rest/services/FEMA_National_Risk_Index/FeatureServer/0/query';

        try {
            $response = Http::timeout(30)->get($endpoint, [
                'where' => '1=1',
                'outFields' => '*',
                'returnGeometry' => 'false',
                'resultRecordCount' => 1,
                'f' => 'json',
            ]);

            return [
                'status' => $response->status(),
                'name' => 'FEMA National Risk Index',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'FEMA National Risk Index',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}