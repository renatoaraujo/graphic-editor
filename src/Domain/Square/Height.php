<?php

namespace GraphicEditor\Domain\Square;

use GraphicEditor\Domain\Exception\InvalidSquareParametersException;

final class Height
{
    /** @var float */
    private $value;

    public function __construct($value)
    {
        if (!\is_numeric($value)) {
            throw new InvalidSquareParametersException(
                'Please provide a valid numeric value to create the square.'
            );
        }

        if ('' === $value || 0 === $value) {
            throw new InvalidSquareParametersException(
                'Height cannot be empty or equals 0. Please provide a valid numeric value to create the square.'
            );
        }

        $this->value = $value;
    }

    public function toFloat()
    {
        return $this->value;
    }
}
