# PHP Geocoding Package

A simple and efficient PHP package for converting addresses into latitude and longitude coordinates using OpenStreetMap's Nominatim service. No API key required!

## Features

- Convert addresses to latitude/longitude coordinates
- Batch geocoding support
- Reverse geocoding (coordinates to address)
- No API key required
- Rate limiting built-in
- Exception handling
- PSR-4 compliant
- Fully tested

## Requirements

- PHP 7.4 or higher
- Composer
- `ext-json` PHP extension
- GuzzleHttp 7.0 or higher

## Installation

Install the package via Composer:

```bash
composer require vpro/geocoding
```

## Basic Usage

```php
use Geocoding\Geocoder;

// Initialize the geocoder with your application name
$geocoder = new Geocoder('YourApp/1.0');

// Convert address to coordinates
try {
    $coordinates = $geocoder->geocode('1600 Amphitheatre Parkway, Mountain View, CA');
    if ($coordinates) {
        echo "Latitude: {$coordinates['lat']}\n";
        echo "Longitude: {$coordinates['lng']}\n";
    }
} catch (GeocodingException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Batch Geocoding

```php
$addresses = [
    'Empire State Building, NY',
    'Golden Gate Bridge, SF'
];

$results = $geocoder->batchGeocode($addresses);
foreach ($results as $address => $coordinates) {
    if ($coordinates) {
        echo "$address:\n";
        echo "Latitude: {$coordinates['lat']}\n";
        echo "Longitude: {$coordinates['lng']}\n";
    }
}
```

## Reverse Geocoding

```php
$address = $geocoder->reverseGeocode(37.4224764, -122.0842499);
if ($address) {
    echo "Address: {$address['address']}\n";
    echo "Details: " . print_r($address['details'], true);
}
```

## Important Notes

1. **Usage Policy**: This package uses OpenStreetMap's Nominatim service. Please respect their usage policy:

   - Maximum of 1 request per second
   - Set a meaningful User-Agent header
   - For heavy usage, consider hosting your own Nominatim instance

2. **Error Handling**: All methods may throw `GeocodingException` on failure. Always wrap calls in try-catch blocks.

## Testing

Run the test suite:

```bash
./vendor/bin/phpunit
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
