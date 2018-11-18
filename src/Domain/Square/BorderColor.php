<?php

namespace GraphicEditor\Domain\Square;

use GraphicEditor\Domain\Exception\InvalidSquareParametersException;

final class BorderColor
{
    /** @var string */
    private $value;

    public function __construct($value)
    {
        if ('' === $value) {
            throw new InvalidSquareParametersException(
                'Border color cannot be empty. Please provide a valid hexadecimal value to create the square.'
            );
        }

        if (!\ctype_xdigit(\ltrim($value, '#')) || \strlen(\ltrim($value, '#')) !== 6) {
            throw new InvalidSquareParametersException(
                'Please provide a valid hexadecimal border color value to create the square.'
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
