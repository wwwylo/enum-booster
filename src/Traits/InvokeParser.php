<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Traits;

use Wiilon\EnumBooster\Support\AnnotationParser;

trait InvokeParser
{

    /**
     * @param ...$args
     * @return mixed
     */
    public function invoke(...$args): mixed
    {
        return AnnotationParser::invoke($this, ...$args);
    }
}