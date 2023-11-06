<?php

declare(strict_types=1);

namespace Wiilon\EnumBooster;

use Hyperf\Context\ApplicationContext;
use Psr\Container\ContainerInterface;

class Bootstrap
{

    /**
     * @return \Psr\Container\ContainerInterface
     */
    public static function getContainer(): ContainerInterface
    {
        return ApplicationContext::getContainer();
    }

    /**
     * @param \Psr\Container\ContainerInterface $container
     * @return \Psr\Container\ContainerInterface
     */
    public static function setContainer(ContainerInterface $container): ContainerInterface
    {
        return ApplicationContext::setContainer($container);
    }


    /**
     * @return bool
     */
    public static function hasContainer(): bool
    {
        return ApplicationContext::hasContainer();
    }
}