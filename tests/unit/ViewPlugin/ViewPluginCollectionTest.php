<?php

use Merophp\ViewEngine\ViewPlugin\Collection\ViewPluginCollection;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;
use PHPUnit\Framework\TestCase;

/**
 * @covers ViewPluginCollection
 */
class ViewPluginCollectionTest extends TestCase
{
    /**
     * @var ViewPluginCollection
     */
    private static ViewPluginCollection $viewPluginCollection;

    public static function setUpBeforeClass(): void
    {
        self::$viewPluginCollection = new ViewPluginCollection;
    }

    public function test()
    {
        $this->assertTrue(self::$viewPluginCollection->isEmpty());
        self::$viewPluginCollection->addMultiple([new ViewPlugin(DummyView::class)]);
        $this->assertFalse(self::$viewPluginCollection->isEmpty());
        $this->assertIsIterable(self::$viewPluginCollection->getViewPlugins());

    }
}
