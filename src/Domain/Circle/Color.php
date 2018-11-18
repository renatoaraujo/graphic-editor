<?php

namespace GraphicEditor\Domain\Circle;

use GraphicEditor\Domain\Exception\InvalidCircleParametersException;

final class Color
{
    /** @var string */
    private $value;

    public function __construct($value)
    {
        if ('' === $value) {
            throw new InvalidCircleParametersException(
                'Color cannot be empty. Please provide a valid hexadecimal value to create the circle.'
            );
        }

        if (!\ctype_xdigit(\ltrim($value, '#')) || \strlen(\ltrim($value, '#')) !== 6) {
            throw new InvalidCircleParametersException(
                'Please provide a valid hexadecimal value to create the circle.'
            );
        }

        $this->value = $value;
    }

    public function toString()
    {
        return $this->value;
    }

    public function toRgb()
    {
        return \sscanf($this->value, "#%02x%02x%02x");
    }
}
