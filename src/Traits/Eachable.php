<?php

namespace Wiilon\EnumBooster\Traits;

trait Eachable
{
    /**
     * @param callable $callback
     * @return void
     */
    public static function each(callable $callback): void
    {
        foreach (static::cases() as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }
    }
}