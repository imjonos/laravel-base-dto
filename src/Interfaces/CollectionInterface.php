<?php

namespace Nos\BaseDto\Interfaces;

use Iterator;

interface CollectionInterface extends Iterator, \Countable
{
    public function map(callable $callback): array;
    public function each(callable $callback): void;

    public function findByKey(int $key): mixed;
}
