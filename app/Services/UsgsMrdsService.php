<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsgsMrdsService
{
    private string $endpoint = 'https://mrdata.usgs.gov/services/wfs/mrds';

    public function fetchData(): array
    {
        try {
            // First get the available WFS feature types.
            $capabilities = Http::timeout(60)
                ->get($this->endpoint, [
                    'service' => 'WFS',
                    'version' => '1.1.0',
                    'request' => 'GetCapabilities',
                ]);

            if (!$capabilities->successful()) {
                return [
                    'status' => $capabilities->status(),
                    'name' => 'USGS MRDS WFS',
                    'endpoint' => $this->endpoint,
                    'response' => $capabilities->body(),
                    'working' => false,
                ];
            }

            // Extract the first available feature type from the WFS capabilities.
            $xml = simplexml_load_string($capabilities->body());

            if ($xml === false) {
                return [
                    'status' => 500,
                    'name' => 'USGS MRDS WFS',
                    'endpoint' => $this->endpoint,
                    'response' => 'Unable to parse WFS GetCapabilities response.',
                    'working' => false,
                ];
            }

            $namespaces = $xml->getNamespaces(true);

            if (isset($namespaces['wfs'])) {
                $xml->registerXPathNamespace('wfs', $namespaces['wfs']);
            }

            $featureTypes = $xml->xpath('//wfs:FeatureType');

            if (empty($featureTypes)) {
                return [
                    'status' => 404,
                    'name' => 'USGS MRDS WFS',
                    'endpoint' => $this->endpoint,
                    'response' => 'No WFS feature types were found.',
                    'working' => false,
                ];
            }

            $featureType = (string) $featureTypes[0]->Name;

            // Now request actual MRDS records.
            $response = Http::timeout(60)
                ->get($this->endpoint, [
                    'service' => 'WFS',
                    'version' => '1.1.0',
                    'request' => 'GetFeature',
                    'typeName' => $featureType,
                    'maxFeatures' => 10,
                    'outputFormat' => 'application/json',
                ]);

            $contentType = $response->header('Content-Type');

            $responseData = str_contains(strtolower($contentType ?? ''), 'json')
                ? $response->json()
                : $response->body();

            return [
                'status' => $response->status(),
                'name' => 'USGS MRDS WFS',
                'endpoint' => $this->endpoint,
                'response' => $responseData,
                'working' => $response->successful(),
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'name' => 'USGS MRDS WFS',
                'endpoint' => $this->endpoint,
                'response' => $e->getMessage(),
                'working' => false,
            ];
        }
    }
}