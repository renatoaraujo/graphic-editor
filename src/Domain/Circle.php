<?php

namespace GraphicEditor\Domain;

use GraphicEditor\Domain\Circle\BorderColor;
use GraphicEditor\Domain\Circle\Color;
use GraphicEditor\Domain\Circle\Radius;

final class Circle implements Shape
{
    /** @var Radius */
    private $radius;

    /** @var BorderColor */
    private $borderColor;

    /** @var Color */
    private $color;

    private function __construct()
    {}

    public function getType()
    {
        return 'circle';
    }

    public static function fromArray(array $parameters)
    {
        $instance = new self();
        $instance->radius = new Radius($parameters['radius'] ?: '');
        $instance->borderColor = new BorderColor($parameters['border_color'] ?: '');
        $instance->color = new Color($parameters['color'] ?: '');

        return $instance;
    }

    public function jsonSerialize()
    {
        return [
            'type' => $this->getType(),
            'params' => [
                'radius' => $this->radius->toFloat(),
                'border_color' => $this->borderColor->toString(),
                'color' => $this->color->toString(),
            ],
        ];
    }

    public function draw($filename = null)
    {
        // TODO: Implement draw() method.
    }
}
