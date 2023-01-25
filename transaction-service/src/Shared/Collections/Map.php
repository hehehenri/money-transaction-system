<?php

namespace Src\Shared\Collections;

use Src\Shared\Exceptions\InvalidItemException;

/**
 * @template V of object
 */
abstract class Map
{
    /** @var array<string, array<V>> */
    private array $map = [];

    abstract public function valueType(): string;

    /**
     * @param  array<string, array<V>>  $items
     *
     * @throws InvalidItemException
     */
    public function __construct(array $items)
    {
        foreach ($items as $key => $values) {
            $this->insert($key, $values);
        }
    }

    /**
     * @param  string  $key
     * @param  array<V>  $values
     *
     * @throws InvalidItemException
     */
    public function insert(string $key, array $values): void
    {
        $valueType = $this->valueType();

        foreach ($values as $value) {
            if (! $value instanceof $valueType) {
                throw InvalidItemException::invalidType($this->valueType(), get_class($value));
            }
        }

        $this->map[$key] = [
            ...$this->map[$key] ?? [],
            ...$values,
        ];
    }

    /**
     * @return array<V>
     */
    public function get(string $key): array
    {
        if (! array_key_exists($key, $this->map)) {
            return [];
        }

        return $this->map[$key];
    }

    /** @return array<string, array<V>> */
    public function toArray(): array
    {
        return $this->map;
    }
}
