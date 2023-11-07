<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Support;

use Hyperf\Context\ApplicationContext;
use Hyperf\Di\ReflectionManager;
use UnitEnum;
use Wiilon\EnumBooster\Annotation\DI;
use Wiilon\EnumBooster\Annotation\Invoke;
use Wiilon\EnumBooster\Annotation\Label;
use Wiilon\EnumBooster\Annotation\Property;
use Wiilon\EnumBooster\Exception\NoEntryException;

use function Hyperf\Collection\data_get;

class AnnotationParser
{
    /**
     * inject.
     * @param \UnitEnum $enum
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function inject(UnitEnum $enum)
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($enum, DI::class);
        if (empty($attributes)) {
            throw new NoEntryException('No entry');
        }
        return ApplicationContext::getContainer()->get($attributes[0]->newInstance()->value);
    }


    /**
     * @param \UnitEnum $enum
     * @param array $parameters
     * @return mixed
     */
    public static function make(UnitEnum $enum, array $parameters): mixed
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($enum, DI::class);
        if (empty($attributes)) {
            throw new NoEntryException('No entry');
        }

        $name = $attributes[0]->newInstance()->value;
        if (ApplicationContext::hasContainer()) {
            /** @var \Hyperf\Di\Container $container */
            $container = ApplicationContext::getContainer();
            if (method_exists($container, 'make')) {
                return $container->make($name, $parameters);
            }
        }
        $parameters = array_values($parameters);
        return new $name(...$parameters);
    }


    public static function label(UnitEnum $enum): ?string
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($enum, Label::class);
        return $attributes[0]->newInstance()->value ?? null;
    }


    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public static function property(UnitEnum $enum, ?string $key = null, mixed $default = null): mixed
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($enum, Property::class);
        if (empty($attributes)) {
            return null;
        }


        $value = $attributes[0]->newInstance()->value ?? null;
        if ($key === null) {
            return $value;
        }
        return data_get($value, $key, $default);
    }


    /**
     * @param ...$args
     * @return mixed
     */
    public static function invoke(UnitEnum $enum, ...$args): mixed
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($enum, Invoke::class);
        $callable   = $attributes[0]->newInstance()->callable ?? null;
        if ($callable === null) {
            return null;
        }

        [$className, $methodName] = $callable;
        $reflection = ReflectionManager::reflectMethod($className, $methodName);
        if ($reflection->isStatic()) {
            return call_user_func([$className, $methodName], $enum, ...$args);
        }

        return ApplicationContext::getContainer()->get($className)->{$methodName}($enum, ...$args);
    }


}