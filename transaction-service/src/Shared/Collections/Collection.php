<?php

namespace Src\Shared\Collections;

use Src\Shared\Exceptions\InvalidItemException;

/**
 * @template T of object
 */
abstract class Collection
{
    /** @var array<T> */
    private array $items = [];

    /**
     * @param  array<T>  $items
     *
     * @throws InvalidItemException
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->put($item);
        }
    }

    abstract public function type(): string;

    /**
     * @param  T  $item
     *
     * @throws InvalidItemException
     */
    public function put($item): void
    {
        $type = $this->type();

        if (! $item instanceof $type) {
            throw InvalidItemException::invalidType($this->type(), get_class($item));
        }

        $this->items[] = $item;
    }

    /** @return array<T> */
    public function toArray(): array
    {
        return $this->items;
    }

    public function length(): int
    {
        return count($this->items);
    }
}
