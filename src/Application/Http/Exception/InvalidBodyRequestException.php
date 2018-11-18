<?php

namespace GraphicEditor\Application\Http\Exception;

final class InvalidBodyRequestException extends \Exception
{
    protected $code = 400;
}
