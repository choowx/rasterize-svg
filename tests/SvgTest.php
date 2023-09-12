<?php

use Choowx\RasterizeSvg\Svg;
use SapientPro\ImageComparator\ImageComparator;

beforeEach(function () {
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /> </svg>';
    $this->svg = Svg::make($svg);

    $this->imageComparator = new ImageComparator;
});

it('can rasterize to image', function (string $format) {
    file_put_contents($file = __DIR__."/test.{$format}", $this->svg->{'to'.ucfirst($format)}());

    expect(
        $this->imageComparator->compare(
            __DIR__."/snapshots/SvgTest__it_can_rasterize_to_image__{$format}.{$format}",
            $file
        )
    )->toBeFloat()->toBe(100.0);

    unlink($file);
})->with('formats');

it('can rasterize to image and save it as file', function (string $format) {
    $this->svg->{'saveAs'.ucfirst($format)}($file = __DIR__."/test.{$format}");

    expect(
        $this->imageComparator->compare(
            __DIR__."/snapshots/SvgTest__it_can_rasterize_to_image_and_save_it_as_file__{$format}.{$format}",
            $file
        )
    )->toBeFloat()->toBe(100.0);

    unlink($file);
})->with('formats');
