<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NoaaNhcService
{
    public function fetchData(): array
    {
        $endpoint = 'https://mapservices.weather.noaa.gov/tropical/rest/services/tropical/StormSurgeRisk/MapServer';

        try {
            $response = Http::timeout(30)->get($endpoint, [
                'f' => 'json',
            ]);

            return [
                'status' => $response->status(),
                'name' => 'NOAA NHC Storm Surge Risk',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'NOAA NHC Storm Surge Risk',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}