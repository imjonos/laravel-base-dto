<?php

namespace Nos\BaseDto;

use Nos\BaseDto\Interfaces\DtoCollectionInterface;
use Nos\BaseDto\Interfaces\DtoInterface;

/**
 * @template T of DtoInterface
 *
 * @implements \Iterator<int, T>
 * @implements \ArrayAccess<int, T>
 *
 * @property array $data
 */
abstract class DTOCollection implements DtoCollectionInterface
{
    private int $position = 0;

    private function __construct(
        private array $data
    ) {
        $this->data = $this->prepare($data);
    }

    protected function prepare(array $data): array
    {
        return $data;
    }

    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->data[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @return DtoInterface
     */
    public function current(): DtoInterface
    {
        return static::createDTO($this->data[$this->position]);
    }

    /**
     * @return DtoInterface
     */
    abstract protected static function createDTO(array $array): DtoInterface;

    public function map(callable $callback): array
    {
        return array_map(fn (array $data) => $callback(static::createDTO($data)), $this->toArray());
    }

    public function each(callable $callback): void
    {
        foreach ($this->data as $key => $item) {
            $callback(static::createDTO($item), $key);
        }
    }

    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @return DtoInterface|null
     */
    public function findByKey(int $key): ?DtoInterface
    {
        return isset($this->data[$key]) ? static::createDTO($this->data[$key]) : null;
    }

    /**
     * @return DtoInterface|null
     */
    public function findByKeyAndValue(string $key, string $value): ?DtoInterface
    {
        $index = array_column($this->data, $key);
        $map = array_flip($index);
        $result = $this->data[$map[$value] ?? null] ?? null;

        return $result ? static::createDTO($result) : null;
    }

    public function filter(callable $callback): static
    {
        $result = array_filter($this->data, fn (array $data): bool => $callback(static::createDTO($data)));
        $result = array_values($result);

        return static::fromArray($result);
    }

    /**
     * @return DtoInterface|null
     */
    public function findBy(callable $callback): ?DtoInterface
    {
        $result = null;
        foreach ($this->data as $data) {
            if ($callback(static::createDTO($data))) {
                $result = static::createDTO($data);
                break;
            }
        }

        return $result;
    }
}
