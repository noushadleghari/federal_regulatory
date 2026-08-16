<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EpaEnvirofactsService
{
    public function fetchData(): array
    {
        $state = "FL";
        $endpoint = "https://enviro.epa.gov/enviro/efservice/tri_facility/state_abbr/$state/rows/0:4/JSON";

        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->get($endpoint);

            return [
                'status' => $response->status(),
                'name' => 'EPA Envirofacts TRI Facilities',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'EPA Envirofacts TRI Facilities',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}