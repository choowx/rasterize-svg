<?php

namespace Choowx\RasterizeSvg\Tests;

use Choowx\RasterizeSvg\Svg;
use PHPUnit\Framework\TestCase;

class ImageOperationsTest extends TestCase
{
    private string $tempDirectory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tempDirectory = sys_get_temp_dir();
    }

    protected function tearDown(): void
    {
        // Cleanup any remaining test files
        foreach (['test-resize.png', 'test-resize-aspect.png'] as $file) {
            $path = $this->tempDirectory . '/' . $file;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        parent::tearDown();
    }

    private function getTestSvg(): string
    {
        return '<svg width="200" height="200" viewBox="0 0 200 200">
            <rect width="200" height="200" fill="blue"/>
        </svg>';
    }

    public function testCanResizeImageToSpecificDimensions(): void
    {
        $resizeOptions = [
            'resize' => [
                'width' => 100,
                'height' => 100,
                'options' => [
                    'fit' => 'contain'
                ]
            ]
        ];

        $pngData = Svg::make($this->getTestSvg(), $resizeOptions)->toPng();

        $tempFile = $this->tempDirectory . '/test-resize.png';
        file_put_contents($tempFile, $pngData);

        $imageInfo = getimagesize($tempFile);

        $this->assertEquals(100, $imageInfo[0]); // Width
        $this->assertEquals(100, $imageInfo[1]); // Height
    }

    public function testCanResizeImageMaintainingAspectRatio(): void
    {
        $resizeOptions = [
            'resize' => [
                'width' => 100,
                'height' => null,
                'options' => [
                    'fit' => 'contain'
                ]
            ]
        ];

        $pngData = Svg::make($this->getTestSvg(), $resizeOptions)->toPng();

        $tempFile = $this->tempDirectory . '/test-resize-aspect.png';
        file_put_contents($tempFile, $pngData);

        $imageInfo = getimagesize($tempFile);

        $this->assertEquals(100, $imageInfo[0]); // Width
        $this->assertEquals(100, $imageInfo[1]); // Height maintains aspect ratio
    }

    public function testCanResizeImageWithFitCover(): void
    {
        $resizeOptions = [
            'resize' => [
                'width' => 100,
                'height' => 50,
                'options' => [
                    'fit' => 'cover'
                ]
            ]
        ];

        $pngData = Svg::make($this->getTestSvg(), $resizeOptions)->toPng();
        $tempFile = $this->tempDirectory . '/test-resize-cover.png';
        file_put_contents($tempFile, $pngData);

        $imageInfo = getimagesize($tempFile);

        $this->assertEquals(100, $imageInfo[0]); // Width
        $this->assertEquals(50, $imageInfo[1]); // Height
    }
}