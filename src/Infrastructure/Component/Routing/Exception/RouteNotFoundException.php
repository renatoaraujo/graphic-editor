<?php

namespace GraphicEditor\Infrastructure\Component\Routing\Exception;

final class RouteNotFoundException extends \Exception
{
    protected $code = 404;
}
