<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EpaEchoService
{
    public function fetchData(): array
    {
        $endpoint = 'https://echodata.epa.gov/echo/echo_rest_services.get_facilities';

        try {
            $response = Http::timeout(60)->get($endpoint, [
                'output' => 'JSON',
                'p_st' => 'AL',
                'p_act' => 'Y',
                'p_maj' => 'Y',
                'responseset' => 10,
            ]);

            return [
                'status' => $response->status(),
                'name' => 'EPA ECHO All Media Facility Search',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'EPA ECHO All Media Facility Search',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}