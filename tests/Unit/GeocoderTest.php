<?php

namespace Geocoding\Tests\Unit;

use Geocoding\Geocoder;
use Geocoding\GeocodingException;
use PHPUnit\Framework\TestCase;

class GeocoderTest extends TestCase
{
    private Geocoder $geocoder;

    protected function setUp(): void
    {
        $this->geocoder = new Geocoder('TestApp/1.0');
    }

    public function testGeocodeValidAddress()
    {
        $result = $this->geocoder->geocode('Empire State Building, NY');
        $this->assertIsArray($result);
        $this->assertArrayHasKey('lat', $result);
        $this->assertArrayHasKey('lng', $result);
    }
}
