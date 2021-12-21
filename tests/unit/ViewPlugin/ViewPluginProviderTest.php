<?php

use Merophp\ViewEngine\ViewPlugin\Collection\ViewPluginCollection;
use Merophp\ViewEngine\ViewPlugin\Provider\ViewPluginProvider;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;
use PHPUnit\Framework\TestCase;

/**
 * @covers ViewPluginProvider
 */
class ViewPluginProviderTest extends TestCase
{
    /**
     * @var ViewPluginProvider
     */
    private static ViewPluginProvider $viewPluginProvider;

    public static function setUpBeforeClass(): void
    {
        $viewPluginCollection = new ViewPluginCollection();
        $viewPluginCollection->addMultiple([new ViewPlugin(DummyView::class)]);

        self::$viewPluginProvider = new ViewPluginProvider($viewPluginCollection);
    }

    public function testGetViewPlugins()
    {
        $this->assertIsIterable(self::$viewPluginProvider->getViewPlugins());
        $this->assertEquals(1, iterator_count(self::$viewPluginProvider->getViewPlugins()));
    }
}
