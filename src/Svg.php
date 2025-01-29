<?php

namespace Choowx\RasterizeSvg;

use Choowx\RasterizeSvg\Enums\Format;

class Svg
{
    protected string $svg;
    protected array $options = [];

    public function __construct(string $svg, array $options = [])
    {
        $this->svg = $svg;
        $this->options = $options;
    }

    public static function make(string $svg, array $options = []): self
    {
        return new static($svg, $options);
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function toString(): string
    {
        return $this->svg;
    }

    public function toJpeg(): string
    {
        return $this->rasterizer()->to(Format::JPEG)->rasterize();
    }

    public function toJpg(): string
    {
        return $this->toJpeg();
    }

    public function toPng(): string
    {
        return $this->rasterizer()->to(Format::PNG)->rasterize();
    }

    public function toWebp(): string
    {
        return $this->rasterizer()->to(Format::WEBP)->rasterize();
    }

    public function saveAsJpeg(string $path): bool|int
    {
        return $this->rasterizer()->to(Format::JPEG)->save($path);
    }

    public function saveAsJpg(string $path): bool|int
    {
        return $this->saveAsJpeg($path);
    }

    public function saveAsPng(string $path): bool|int
    {
        return $this->rasterizer()->to(Format::PNG)->save($path);
    }

    public function saveAsWebp(string $path): bool|int
    {
        return $this->rasterizer()->to(Format::WEBP)->save($path);
    }

    protected function rasterizer(): SharpSvgRasterizer
    {
        return SharpSvgRasterizer::from($this);
    }
}
