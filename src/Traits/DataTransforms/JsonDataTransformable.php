<?php

namespace Nos\BaseDto\Traits\DataTransforms;

/**
 * @method static fromArray(mixed $data)
 * @method toArray()
 */
trait JsonDataTransformable
{
    public static function fromJson(string $json): static
    {
        $data = json_decode($json, true);

        return static::fromArray($data);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray()) ?: '';
    }
}
