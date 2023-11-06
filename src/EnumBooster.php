<?php

namespace Wiilon\EnumBooster;

use Hyperf\Collection\Collection;
use Hyperf\Context\ApplicationContext;
use Hyperf\Di\ReflectionManager;
use InvalidArgumentException;
use RuntimeException;
use Wiilon\EnumBooster\Annotation\EnumAnnotationReader;
use Wiilon\EnumBooster\Annotation\DI;
use Wiilon\EnumBooster\Annotation\Invoke;
use Wiilon\EnumBooster\Annotation\Label;
use Wiilon\EnumBooster\Annotation\Property;
use Wiilon\EnumBooster\Exception\NoEntryException;

use function Hyperf\Collection\data_get;

trait EnumBooster
{
    /**
     * @return \Hyperf\Collection\Collection<int,static>
     */
    public static function collect(): Collection
    {
        $reflection = EnumReflectionManager::reflectionEnum(static::class);
        if (!$reflection->isBacked()) {
            throw new RuntimeException('This trait must in BackedEnum');
        }
        return Collection::make(static::cases());
    }

    /**
     * @param callable $callback
     * @return mixed
     */
    public static function map(callable $callback): mixed
    {
        return array_map($callback, static::cases());
    }

    /**
     * @param callable $callback
     * @return void
     */
    public static function each(callable $callback): void
    {
        foreach (static::cases() as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }
    }


    /**
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function inject(): mixed
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($this, DI::class);
        if (empty($attributes)) {
            throw new NoEntryException('No entry');
        }
        return ApplicationContext::getContainer()->get($attributes[0]->newInstance()->value);
    }


    /**
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters = []): mixed
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($this, DI::class);
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


    public function label(): ?string
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($this, Label::class);
        return $attributes[0]->newInstance()->value ?? null;
    }


    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function property(?string $key = null, mixed $default = null): mixed
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($this, Property::class);
        $value      = $attributes[0]->newInstance()->value ?? null;
        if ($key === null) {
            return $value;
        }
        return data_get($value, $key, $default);
    }


    /**
     * @param ...$args
     * @return mixed
     */
    public function invoke(...$args): mixed
    {
        $attributes = EnumAnnotationReader::getEnumUnitCaseAttributes($this, Invoke::class);
        $callable   = $attributes[0]->newInstance()->callable ?? null;
        if ($callable === null) {
            return null;
        }

        [$className, $methodName] = $callable;
        $reflection = ReflectionManager::reflectMethod($className, $methodName);
        if ($reflection->isStatic()) {
            return call_user_func([$className, $methodName], $this, ...$args);
        }

        return ApplicationContext::getContainer()->get($className)->{$methodName}($this, ...$args);
    }




}
