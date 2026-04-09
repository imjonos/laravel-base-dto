<?php

namespace Nos\BaseDto\Interfaces;

interface DtoCollectionInterface extends DtoInterface, CollectionInterface
{
    public function findByKey(int $key): ?DtoInterface;
}
