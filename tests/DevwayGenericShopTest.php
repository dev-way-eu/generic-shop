<?php

namespace Devway\GenericShop\Tests;

use Kjonski\HowToBundle\DependencyInjection\KjonskiHowToExtension;
use Kjonski\HowToBundle\KjonskiHowToBundle;
use PHPUnit\Framework\TestCase;

class DevwayGenericShopTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new KjonskiHowToBundle();
        $this->assertInstanceOf(KjonskiHowToExtension::class, $bundle->getContainerExtension());
    }
}
