<?php

namespace GraphicEditor\Infrastructure\Component\Routing;

use GraphicEditor\Infrastructure\Component\Routing\Exception\InvalidJsonException;

final class Request
{
    /** @var string */
    private $content;

    public function getContent($asArray = false)
    {
        if ($asArray) {
            return \json_decode($this->content, true);
        }

        return $this->content;
    }

    public static function fromRawJson($content)
    {
        $instance = new self();

        \json_decode($content);

        if (\json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidJsonException('Invalid Json payload.');
        }

        if (!empty($content)) {
            $instance->content = $content;
        }

        return $instance;
    }
}
