<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsgsEarthquakeService
{
    public function fetchData(): array
    {
        $endpoint = 'https://earthquake.usgs.gov/fdsnws/event/1/query';

        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->get($endpoint, [
                    'format' => 'geojson',
                    'starttime' => '2026-08-16T00:00:00',
                    'endtime' => '2026-08-17T23:59:59',
                    'minmagnitude' => 2.5,
                    'latitude' => 38.8,
                    'longitude' => -77.01,
                    'maxradiuskm' => 500,
                    'limit' => 10,
                    'orderby' => 'time',
                ]);

            return [
                'status' => $response->status(),
                'name' => 'USGS Earthquake Event API',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USGS Earthquake Event API',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}