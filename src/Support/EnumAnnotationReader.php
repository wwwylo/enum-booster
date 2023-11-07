<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Support;

use UnitEnum;

class EnumAnnotationReader
{
    /**
     * @template T
     * @param \UnitEnum $case
     * @param class-string<T>|null $attribute
     * @return array<int,\ReflectionAttribute<T>>
     */
    public static function getEnumUnitCaseAttributes(UnitEnum $case, ?string $attribute = null): array
    {
        return EnumReflectionManager::reflectionEnumUnitCase($case)->getAttributes($attribute);
    }


}