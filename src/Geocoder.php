<?php

namespace Geocoding;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Geocoder
{
    private Client $client;
    private string $baseUrl = 'https://nominatim.openstreetmap.org/search';
    private string $userAgent;

    public function __construct(string $userAgent = 'GeocodingPackage/1.0')
    {
        $this->userAgent = $userAgent;
        $this->client = new Client([
            'headers' => [
                'User-Agent' => $this->userAgent
            ]
        ]);
    }

    /**
     * Convert an address to coordinates
     *
     * @param string $address The address to geocode
     * @return array|null Returns ['lat' => float, 'lng' => float] or null if not found
     * @throws GeocodingException
     */
    public function geocode(string $address): ?array
    {
        try {
            $response = $this->client->get($this->baseUrl, [
                'query' => [
                    'q' => $address,
                    'format' => 'json',
                    'limit' => 1
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (empty($data)) {
                return null;
            }

            return [
                'lat' => (float) $data[0]['lat'],
                'lng' => (float) $data[0]['lon']
            ];
        } catch (GuzzleException $e) {
            throw new GeocodingException("Request failed: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Batch geocode multiple addresses
     *
     * @param array $addresses Array of addresses to geocode
     * @return array Array of results with original address as key
     * @throws GeocodingException
     */
    public function batchGeocode(array $addresses): array
    {
        $results = [];
        foreach ($addresses as $address) {
            try {
                $results[$address] = $this->geocode($address);
                // Respect Nominatim's usage policy (1 request per second)
                sleep(1);
            } catch (GeocodingException $e) {
                $results[$address] = null;
            }
        }
        return $results;
    }

    /**
     * Reverse geocode coordinates to address
     *
     * @param float $lat Latitude
     * @param float $lng Longitude
     * @return array|null Returns address details or null if not found
     * @throws GeocodingException
     */
    public function reverseGeocode(float $lat, float $lng): ?array
    {
        try {
            $response = $this->client->get('https://nominatim.openstreetmap.org/reverse', [
                'query' => [
                    'lat' => $lat,
                    'lon' => $lng,
                    'format' => 'json'
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['address'])) {
                return null;
            }

            return [
                'address' => $data['display_name'],
                'details' => $data['address']
            ];
        } catch (GuzzleException $e) {
            throw new GeocodingException("Reverse geocoding failed: {$e->getMessage()}", 0, $e);
        }
    }
}
