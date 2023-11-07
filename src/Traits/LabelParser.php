<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Traits;

use Wiilon\EnumBooster\Support\EnumAnnotationReader;
use Wiilon\EnumBooster\Support\AnnotationParser;

trait LabelParser
{

    /**
     * @return string|null
     */
    public function label(): ?string
    {
        return AnnotationParser::label($this);
    }
}