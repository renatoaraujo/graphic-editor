<?php

namespace GraphicEditor\Domain;

use GraphicEditor\Domain\Exception\InvalidSquareParametersException;
use GraphicEditor\Domain\Square\BorderColor;
use GraphicEditor\Domain\Square\Color;
use GraphicEditor\Domain\Square\Height;
use GraphicEditor\Domain\Square\Width;

final class Square implements Shape
{
    /** @var BorderColor */
    private $borderColor;

    /** @var Color */
    private $color;

    /** @var Height */
    private $height;

    /** @var Width */
    private $width;

    private function __construct()
    {}

    public function getType()
    {
        return 'square';
    }

    public static function fromArray(array $parameters)
    {
        $instance = new self();
        $instance->borderColor = new BorderColor($parameters['border_color'] ?: '');
        $instance->color = new Color($parameters['color'] ?: '');
        $instance->height = new Height($parameters['height'] ?: '');
        $instance->width = new Width($parameters['width'] ?: '');

        if ($instance->height->toFloat() !== $instance->width->toFloat()) {
            throw new InvalidSquareParametersException(
                'To be a perfect square you must pass the same "height" and "width".'
            );
        }

        return $instance;
    }

    public function jsonSerialize()
    {
        return [
            'type' => $this->getType(),
            'params' => [
                'height' => $this->height->toFloat(),
                'width' => $this->width->toFloat(),
                'border_color' => $this->borderColor->toString(),
                'color' => $this->color->toString(),
            ],
        ];
    }

    public function draw($filename = null)
    {
        $rgbColor = $this->color->toRgb();
        $rgbBorderColor = $this->color->toRgb();

        $width = $this->width->toFloat();
        $height = $this->height->toFloat();

        $image = \ImageCreateTrueColor($width, $height);

        \ImageAntiAlias($image, true);

        $color = \ImageColorAllocate($image, $rgbColor[0], $rgbColor[1], $rgbColor[2]);
        $borderColor = \ImageColorAllocate($image, $rgbBorderColor[0], $rgbBorderColor[1], $rgbBorderColor[2]);
        \ImageFillToBorder($image, 0, 0, $borderColor, $color);

        \ImagePNG($image, $filename);
        \ImageDestroy($image);
    }
}
