<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Annotation;


use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Property
{
    public function __construct(
        public int|string|array $value
    ) {
    }
}