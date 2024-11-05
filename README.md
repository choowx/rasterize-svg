# A PHP library for converting SVG to JPEG, PNG, and WEBP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/choowx/rasterize-svg.svg?style=flat-square)](https://packagist.org/packages/choowx/rasterize-svg)
[![Tests](https://img.shields.io/github/actions/workflow/status/choowx/rasterize-svg/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/choowx/rasterize-svg/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/choowx/rasterize-svg.svg?style=flat-square)](https://packagist.org/packages/choowx/rasterize-svg)

## Installation

### Prerequisites

Install Node.js (npm will be included automatically):
   - Download and install from [nodejs.org](https://nodejs.org/)
   - Choose the "LTS" (Long Term Support) version for stability
   - After installation, verify everything is working by opening a terminal/command prompt and running:
     ```bash
     node --version
     npm --version
     ```
Both commands should display version numbers if the installation was successful.

### Package Installation

1. Install the PHP package via composer:
```bash
composer require choowx/rasterize-svg
```

2. Install the required Node.js dependency:
```bash
npm install sharp
```

## Usage

```php
use Choowx\RasterizeSvg\Svg;

$svgString = '<svg width="100" height="100" viewBox="0 0 100 100"...';

$jpegBinaryString = Svg::make($svgString)->toJpeg();
$jpegBinaryString = Svg::make($svgString)->toJpg(); // Alias of toJpeg()
$pngBinaryString = Svg::make($svgString)->toPng();
$webpBinaryString = Svg::make($svgString)->toWebp();

// Resize the image to 100px wide and 100px high
$pngBinaryString = Svg::make($svgString, ['resize' => ['width' => 100, 'height' => 100]])->toPng();
```

If you want to straight away save the rasterized image on disk:

```php
use Choowx\RasterizeSvg\Svg;

$svgString = '<svg width="100" height="100" viewBox="0 0 100 100"...';

Svg::make($svgString)->saveAsJpeg('path/to/rasterized.jpeg');
Svg::make($svgString)->saveAsJpg('path/to/rasterized.jpg'); // Alias of saveAsJpeg()
Svg::make($svgString)->saveAsPng('path/to/rasterized.png');
Svg::make($svgString)->saveAsWebp('path/to/rasterized.webp');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/choowx/rasterize-svg/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Choo Wen Xuan](https://github.com/choowx)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
