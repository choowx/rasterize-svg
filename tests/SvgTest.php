<?php

use Choowx\RasterizeSvg\Svg;
use function Spatie\Snapshots\assertMatchesFileHashSnapshot;
use function Spatie\Snapshots\assertMatchesSnapshot;

beforeEach(function () {
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /> </svg>';
    $this->svg = Svg::make($svg);
});

it('can rasterize to image', function () {
    assertMatchesSnapshot($this->svg->toJpeg());
    assertMatchesSnapshot($this->svg->toJpg());
    assertMatchesSnapshot($this->svg->toPng());
    assertMatchesSnapshot($this->svg->toWebp());
});

it('can rasterize to image and save it as file', function () {
    $this->svg->saveAsJpeg($jpeg = __DIR__.'/test.jpeg');
    $this->svg->saveAsJpg($jpg = __DIR__.'/test.jpg');
    $this->svg->saveAsPng($png = __DIR__.'/test.png');
    $this->svg->saveAsWebp($webp = __DIR__.'/test.webp');

    assertMatchesFileHashSnapshot($jpeg);
    assertMatchesFileHashSnapshot($jpg);
    assertMatchesFileHashSnapshot($png);
    assertMatchesFileHashSnapshot($webp);

    unlink($jpeg);
    unlink($jpg);
    unlink($png);
    unlink($webp);
});
