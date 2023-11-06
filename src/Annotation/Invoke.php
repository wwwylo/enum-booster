<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Invoke
{
    /**
     * @param array<int,class-string,string> $callable
     */
    public function __construct(
        public array $callable
    ) {
    }
}