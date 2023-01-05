<?php

use Choowx\RasterizeSvg\Svg;
use function Spatie\Snapshots\assertMatchesFileHashSnapshot;

beforeEach(function () {
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /> </svg>';
    $this->svg = Svg::make($svg);
});

it('can rasterize to image', function () {
    file_put_contents($jpeg = __DIR__.'/test.jpeg', $this->svg->toJpeg());
    file_put_contents($jpg = __DIR__.'/test.jpg', $this->svg->toJpg());
    file_put_contents($png = __DIR__.'/test.png', $this->svg->toPng());
    file_put_contents($webp = __DIR__.'/test.webp', $this->svg->toWebp());

    assertMatchesFileHashSnapshot($jpeg);
    assertMatchesFileHashSnapshot($jpg);
    assertMatchesFileHashSnapshot($png);
    assertMatchesFileHashSnapshot($webp);

    unlink($jpeg);
    unlink($jpg);
    unlink($png);
    unlink($webp);
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
