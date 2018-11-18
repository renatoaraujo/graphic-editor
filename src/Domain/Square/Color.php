<?php

namespace GraphicEditor\Domain\Square;

use GraphicEditor\Domain\Exception\InvalidSquareParametersException;

final class Color
{
    /** @var string */
    private $value;

    public function __construct($value)
    {
        if ('' === $value) {
            throw new InvalidSquareParametersException(
                'Color cannot be empty. Please provide a valid hexadecimal value to create the circle.'
            );
        }

        if (!\ctype_xdigit(\ltrim($value, '#')) || \strlen(\ltrim($value, '#')) > 6) {
            throw new InvalidSquareParametersException(
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
