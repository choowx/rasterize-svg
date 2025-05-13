<?php

namespace Choowx\RasterizeSvg;

use Choowx\RasterizeSvg\Enums\Format;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class SharpSvgRasterizer
{
    protected Svg $svg;

    protected TemporaryDirectory $temporarySvgDirectory;

    protected Format $format = Format::PNG;

    public function __construct(Svg $svg)
    {
        return $this->svg = $svg;
    }

    public static function from(Svg $svg): self
    {
        return new static($svg);
    }

    public function to(Format $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function rasterize(): string
    {
        $command = [
            (new ExecutableFinder)->find('node', 'node', [
                '/usr/local/bin',
                '/opt/homebrew/bin',
            ]),
            'sharp.js',
            $this->createTemporarySvgFile(),
            $this->format->value,
        ];

        $options = $this->svg->getOptions();
        if ($options) {
            $command[] = json_encode($options);
        }

        $process = new Process(
            command: $command,
            cwd: __DIR__.'/../bin',
            timeout: (60 * 1000) - 700,
        );

        $process->run();

        $this->cleanupTemporarySvgDirectory();

        if ($process->getErrorOutput()) {
            throw new \Exception($process->getErrorOutput());
        }

        return $process->getOutput();
    }

    public function save(string $path): bool|int
    {
        return file_put_contents($path, $this->rasterize());
    }

    protected function createTemporarySvgFile(): string
    {
        $this->temporarySvgDirectory = (new TemporaryDirectory)->create();

        file_put_contents(
            $temporarySvgFile = $this->temporarySvgDirectory->path('temporary.svg'),
            $this->svg->toString()
        );

        return $temporarySvgFile;
    }

    protected function cleanupTemporarySvgDirectory(): void
    {
        $this->temporarySvgDirectory->delete();
    }
}
