<?php

namespace GraphicEditor\Domain\Circle;

use GraphicEditor\Domain\Exception\InvalidCircleParametersException;

final class Radius
{
    /** @var float */
    private $value;

    public function __construct($value)
    {
        if (!\is_numeric($value)) {
            throw new InvalidCircleParametersException(
                'Please provide a valid numeric value to create the circle.'
            );
        }

        if ('' === $value || 0 === $value) {
            throw new InvalidCircleParametersException(
                'Radius cannot be empty or equals 0. Please provide a valid numeric value to create the circle.'
            );
        }

        $this->value = $value;
    }

    public function toFloat()
    {
        return $this->value;
    }
}
