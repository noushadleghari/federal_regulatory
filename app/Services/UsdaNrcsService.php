<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsdaNrcsService
{
    public function fetchData(): array
    {
        $endpoint = 'https://SDMDataAccess.sc.egov.usda.gov/Tabular/post.rest';

        try {
            $query = "
                SELECT TOP 10
                    mukey,
                    cokey,
                    compname,
                    comppct_r,
                    taxclname
                FROM component
                WHERE comppct_r >= 50
            ";

            $response = Http::timeout(60)
                ->asForm()
                ->post($endpoint, [
                    'SERVICE' => 'query',
                    'REQUEST' => 'query',
                    'QUERY' => $query,
                    'FORMAT' => 'JSON+COLUMNNAME',
                ]);

            $body = $response->body();

            $decoded = json_decode($body, true);

            return [
                'status' => $response->status(),
                'name' => 'USDA NRCS Soil Data Access',
                'endpoint' => $endpoint,
                'response' => $decoded ?? $body,
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USDA NRCS Soil Data Access',
                'endpoint' => $endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}