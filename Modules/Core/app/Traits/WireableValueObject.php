<?php

namespace Modules\Core\Traits;

trait WireableValueObject
{
    /**
     * turn to livewire wireable
     */
    public function toLivewire(): array
    {
        return static::toArray();
    }

    /**
     * get from livewire wireable
     */
    public static function fromLivewire($value): static
    {
        return static::fromArray($value);
    }
}
