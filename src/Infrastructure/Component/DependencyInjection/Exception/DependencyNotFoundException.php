<?php

namespace GraphicEditor\Infrastructure\Component\DependencyInjection\Exception;

final class DependencyNotFoundException extends \Exception
{
    protected $code = 500;
}
