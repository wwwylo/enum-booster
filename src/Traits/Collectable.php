<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Traits;

use Hyperf\Collection\Collection;
use RuntimeException;
use Wiilon\EnumBooster\Support\EnumReflectionManager;

trait Collectable
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
}