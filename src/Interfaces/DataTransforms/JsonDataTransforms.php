<?php

namespace Nos\BaseDto\Interfaces\DataTransforms;

interface JsonDataTransforms extends ArrayDataTransforms
{
    public static function fromJson(string $json): static;

    public function toJson(): string;
}
