<?php

namespace Devway\GenericShop;

use Devway\GenericShop\DependencyInjection\DevwayGenericShopExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class DevwayGenericShopBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DevwayGenericShopExtension();
    }
}
