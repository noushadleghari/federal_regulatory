<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsGssNwisService
{
    //   Fetch site information.
    public function fetchData(): array
    {
        $endpoint = 'https://waterservices.usgs.gov/nwis/site/';

        try {
            $response = Http::timeout(30)->get($endpoint, [
                'site' => '01646500',
                'format' => 'rdb',
            ]);

            return [
                'status' => $response->status(),
                'name' => 'USGS NWIS Site Information',
                'endpoint' => $endpoint,
                'response' => $response->body(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USGS NWIS Site Information',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }


    //  Fetch instantaneous values
    public function fetchInstantaneousValues(): array
    {
        $endpoint = 'https://waterservices.usgs.gov/nwis/iv/';

        try {
            $response = Http::timeout(30)->get($endpoint, [
                'sites' => '01646500',
                'parameterCd' => '00060,00065',
                'format' => 'json',
            ]);

            return [
                'status' => $response->status(),
                'name' => 'USGS NWIS Instantaneous Values',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USGS NWIS Instantaneous Values',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}