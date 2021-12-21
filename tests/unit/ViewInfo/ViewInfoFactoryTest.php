<?php

use PHPUnit\Framework\TestCase;

use Merophp\ViewEngine\ViewInfo\Factory\ViewInfoFactory;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;

class ViewInfoFactoryTest extends TestCase
{
    public function testBuildViewInfoFromViewClassName(){
        $viewInfoFactory = new ViewInfoFactory;
        $viewInfo = $viewInfoFactory->buildViewInfoFromViewPlugin(new ViewPlugin(DummyView::class));

        $this->assertContains('dummy', $viewInfo->getInterfaceMethods());
        $this->assertNotContains('dummy2', $viewInfo->getInterfaceMethods());
        $this->assertNotContains('__construct', $viewInfo->getInterfaceMethods());

        $this->assertEquals('DummyView', $viewInfo->getViewClassName());
    }
}
