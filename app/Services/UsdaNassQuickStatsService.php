<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsdaNassQuickStatsService
{
    public function fetchData(): array
    {
        $endpoint = 'https://quickstats.nass.usda.gov/api/api_GET/';

        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->get($endpoint, [
                    'key' => env('NASS_API_KEY'),

                    'source_desc' => 'SURVEY',
                    'commodity_desc' => 'CORN',
                    'statisticcat_desc' => 'YIELD',
                    'agg_level_desc' => 'STATE',
                    'state_alpha' => 'VA',
                    'year' => '2024',
                    'format' => 'JSON',
                ]);

            return [
                'status' => $response->status(),
                'name' => 'USDA NASS Quick Stats',
                'endpoint' => $endpoint,
                'response' => $response->json() ?? $response->body(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USDA NASS Quick Stats',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}