<?php

require_once __DIR__ . '/../vendor/autoload.php';

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

function generateQrCode($text, $outputFile)
{
    $renderer = new ImageRenderer(
        new RendererStyle(400),
        new SvgImageBackEnd()
    );

    $writer = new Writer($renderer);

    if (filter_var($outputFile, FILTER_VALIDATE_URL)) {
        throw new InvalidArgumentException('Output file path must be a local path, not a URL.');
    }

    $directory = dirname($outputFile);
    if (!is_dir($directory)) {
        if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }
    }

    $writer->writeFile($text, $outputFile);
}
