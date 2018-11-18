<?php

namespace GraphicEditor\Domain;

interface Shape extends \JsonSerializable
{
    public function getType();

    public static function fromArray(array $parameters);

    public function draw($filename = null);
}
