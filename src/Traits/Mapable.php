<?php

namespace Wiilon\EnumBooster\Traits;

trait Mapable
{
    /**
     * @param callable $callback
     * @return mixed
     */
    public static function map(callable $callback): mixed
    {
        return array_map($callback, static::cases());
    }
}