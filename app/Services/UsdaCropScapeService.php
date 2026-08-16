<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsdaCropScapeService
{
    public function fetchData(): array
    {
        $endpoint =
            'https://nassgeodata.gmu.edu/axis2/services/CDLService/GetCDLStat';

        try {
            $response = Http::timeout(120)
                ->asForm()
                ->post($endpoint, [
                    'year' => 2018,
                    'fips' => '19015',
                    'format' => 'json',
                ]);

            $body = $response->body();

            return [
                'status' => $response->status(),
                'name' => 'USDA NASS CropScape CDL',
                'endpoint' => $endpoint,
                'response' => $response->json() ?? $body,
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USDA NASS CropScape CDL',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}