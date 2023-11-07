<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster\Traits;

use Wiilon\EnumBooster\Support\EnumAnnotationReader;
use Wiilon\EnumBooster\Support\Support;

trait Label
{

    /**
     * @return string|null
     */
    public function label(): ?string
    {
        return Support::label($this);
    }
}