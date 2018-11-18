<?php

namespace GraphicEditor\Infrastructure\Component\Routing;

final class JsonResponse
{
    public function __construct(array $data, $statusCode = 200)
    {
        $responseData = [];

        \array_walk_recursive($data, function ($value) use (&$responseData) {
            if (\is_object($value) && $value instanceof \JsonSerializable) {
                $responseData[] = $value->jsonSerialize();
            }
        });

        if (\array_key_exists('error', $data)) {
            $responseData[] = $data;
        }

        \header('Content-type: application/json');
        \http_response_code($statusCode);
        exit(\json_encode($responseData));
    }
}
