<?php

namespace App\Traits\DataTransforms;

use DateTimeInterface;
use ReflectionClass;

trait ArrayDataTransformable
{
    public function toArray(): array
    {
        $reflectionClass = new ReflectionClass(get_class($this));
        $result = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $value = $property->getValue($this);
            $propertyName = $property->getName();
            if ($value instanceof DateTimeInterface) {
                $result[$propertyName] = $value->format(DateTimeInterface::ATOM);
            } else {
                $result[$propertyName] = $value;
            }
        }

        return $result;
    }
}
