<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Traits;

use Wiilon\EnumBooster\Support\AnnotationParser;

trait DIParser
{

    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function inject(): mixed
    {
        return AnnotationParser::inject($this);
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters = []): mixed
    {
        return AnnotationParser::make($this, $parameters);
    }
}