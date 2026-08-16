<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EpaSemsService
{
    public function fetchData(): array
    {
        $endpoint = 'https://geopub.epa.gov/ArcGIS/rest/services/EMEF/efpoints/MapServer/0/query';

        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->get($endpoint, [
                    'where' => "state_code = 'VA'",
                    'outFields' => 'registry_id,site_id,primary_name,location_address,city_name,county_name,state_code,epa_region,postal_code,latitude,longitude,pgm_sys_acrnm,pgm_sys_id,facility_url,profile_url',
                    'returnGeometry' => 'true',
                    'outSR' => 4326,
                    'resultRecordCount' => 10,
                    'f' => 'json',
                ]);

            return [
                'status' => $response->status(),
                'name' => 'EPA SEMS / Superfund',
                'endpoint' => $endpoint,
                'response' => $response->json(),
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'EPA SEMS / Superfund',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}