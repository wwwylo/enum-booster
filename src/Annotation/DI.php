<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class DI
{
    /**
     * @param string $value
     */
    public function __construct(
        public string $value
    ) {
    }
}