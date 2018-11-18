<?php

namespace GraphicEditor\Application\Http;

use GraphicEditor\Application\Http\Exception\InvalidBodyRequestException;
use GraphicEditor\Domain\GraphicEditor;
use GraphicEditor\Infrastructure\Component\Routing\JsonResponse;
use GraphicEditor\Infrastructure\Component\Routing\Request;

final class CreateShapeController
{
    /** @var GraphicEditor */
    private $graphicEditor;

    public function __construct(GraphicEditor $graphicEditor)
    {
        $this->graphicEditor = $graphicEditor;
    }

    public function __invoke(Request $request)
    {
        $shapes = $request->getContent(true);

        if (empty($shapes)) {
            throw new InvalidBodyRequestException(
                'Empty body on request is not allowed.'
            );
        }

        foreach ($shapes as $shape) {
            $this->graphicEditor->drawShapeFromArray($shape);
        }

        return new JsonResponse($this->graphicEditor->getShapes());
    }
}
