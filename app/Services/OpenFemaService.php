<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenFemaService
{
    public function fetchData(): array
    {
        $endpoint = 'https://www.fema.gov/api/open/v1/OpenFemaDataSets';

        try {
            $response = Http::timeout(30)->get($endpoint, [
                '$top' => 1,
            ]);

            return [
                'status' => $response->status(),
                'name' => 'FEMA OpenFEMA',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'FEMA OpenFEMA',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}