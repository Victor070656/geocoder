<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Geocoding\Geocoder;

$geocoder = new Geocoder('MyApp/1.0');

// Batch geocoding
$addresses = [
    'Empire State Building, NY',
    'Golden Gate Bridge, SF'
];

$results = $geocoder->batchGeocode($addresses);
print_r($results);

// Reverse geocoding
$address = $geocoder->reverseGeocode(37.4224764, -122.0842499);
print_r($address);
