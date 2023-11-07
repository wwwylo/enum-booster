<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Traits;

use Wiilon\EnumBooster\Support\AnnotationParser;

trait PropertyParser
{

    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function property(?string $key = null, mixed $default = null): mixed
    {
        return AnnotationParser::property($this, $key, $default);
    }
}