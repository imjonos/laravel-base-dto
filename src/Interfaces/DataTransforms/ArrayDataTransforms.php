<?php

namespace Nos\BaseDto\Interfaces\DataTransforms;

interface ArrayDataTransforms
{
    public static function fromArray(array $data): self;

    public function toArray(): array;
}
