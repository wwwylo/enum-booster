<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Traits;

use InvalidArgumentException;
use UnitEnum;
use Wiilon\EnumBooster\Support\EnumAnnotationReader;

trait Attributes
{
    /**
     * @template T
     * @param class-string<T>|null $attributeClassName
     * @return array<int,\ReflectionAttribute<T>>
     */
    public function getAttributes(?string $attributeClassName = null): array
    {
        if (!($this instanceof UnitEnum)) {
            throw new InvalidArgumentException('This trait must in enum');
        }
        return EnumAnnotationReader::getEnumUnitCaseAttributes($this, $attributeClassName);
    }
}