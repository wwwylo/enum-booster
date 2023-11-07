<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Traits;

use Wiilon\EnumBooster\Support\Support;

trait Property
{

    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function property(?string $key = null, mixed $default = null): mixed
    {
        return Support::property($this, $key, $default);
    }
}