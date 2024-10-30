<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Geocoding\Geocoder;

$geocoder = new Geocoder('MyApp/1.0');
$coordinates = $geocoder->geocode('1600 Amphitheatre Parkway, Mountain View, CA');
print_r($coordinates);
