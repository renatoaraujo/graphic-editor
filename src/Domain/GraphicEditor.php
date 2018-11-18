<?php

namespace GraphicEditor\Domain;

use GraphicEditor\Domain\Exception\InvalidShapeException;

final class GraphicEditor
{
    /** @var array */
    private $shapes = [];

    /** @var array */
    private $types = [
        'circle',
        'square',
    ];

    public function addShape(Shape $shape)
    {
        $this->shapes[] = $shape;

        return $this;
    }

    public function getShapes()
    {
        return [
            'shapes' => $this->shapes,
        ];
    }

    public function isTypeAvailable($type)
    {
        return \in_array($type, $this->types);
    }

    public function drawShapeFromArray(array $shape)
    {
        if (!$this->isTypeAvailable($shape['type'])) {
            throw new InvalidShapeException(
                \sprintf('Invalid shape "%s". Please inform a valid shape.', $shape['type'])
            );
        }

        $shapeClass = __NAMESPACE__ . '\\' . \ucwords($shape['type']);

        /** @var Shape $shape */
        $shape = $shapeClass::fromArray($shape['params']);
        $this->addShape($shape);
        $shape->draw(
            \sprintf('%s/img/%s_%s.png', ROOT_PATH, $shape->getType(), \uniqid())
        );
    }
}
