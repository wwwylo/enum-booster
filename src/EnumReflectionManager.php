<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster;

use Hyperf\Di\MetadataCollector;
use InvalidArgumentException;
use ReflectionEnumUnitCase;
use UnitEnum;
use ReflectionEnum;

class EnumReflectionManager extends MetadataCollector
{
    protected static array $container = [];

    public static function reflectionEnum(string $className): ReflectionEnum
    {
        if (!isset(static::$container['class'][$className])) {
            if (!class_exists($className) && !trait_exists($className)) {
                throw new InvalidArgumentException("Class {$className} not exist");
            }
            static::$container['class'][$className] = new ReflectionEnum($className);
        }
        return static::$container['class'][$className];
    }

    public static function reflectionEnumUnitCase(UnitEnum $case): ReflectionEnumUnitCase
    {
        $className = $case::class;
        $key       = sprintf('%s::%s', $className, $case->name);
        if (!isset(static::$container['case'][$key])) {
            static::$container['case'][$key] = static::reflectionEnum($className)->getCase($case->name);
        }
        return static::$container['case'][$key];
    }

    public static function clear(?string $key = null): void
    {
        if ($key === null) {
            static::$container = [];
        }
    }

    public static function getContainer(): array
    {
        return self::$container;
    }

}