<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Traits;

use Wiilon\EnumBooster\Support\Support;

trait Invoke
{

    /**
     * @param ...$args
     * @return mixed
     */
    public function invoke(...$args): mixed
    {
        return Support::invoke($this, ...$args);
    }
}