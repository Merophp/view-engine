<?php

use Merophp\ViewEngine\ViewPlugin\Collection\ViewPluginCollection;
use Merophp\ViewEngine\ViewPlugin\Provider\ViewPluginProvider;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;
use PHPUnit\Framework\TestCase;

use Merophp\ViewEngine\ViewEngine;

/**
 * @author Robert Becker
 * @covers ViewEngine
 */
class ViewEngineTest extends TestCase{

    /**
     * @var ViewEngine
     */
    private static ViewEngine $viewEngineInstance;

    public static function setUpBeforeClass(): void
    {
        $collection = new ViewPluginCollection();
        $collection->addMultiple([
            new ViewPlugin(DummyView::class),
            new ViewPlugin(AnotherDummyView::class),
        ]);

        $provider = new ViewPluginProvider($collection);

        self::$viewEngineInstance = new ViewEngine($provider);
    }

    /**
     *
     */
    public function testInitializeView()
    {
        $view = self::$viewEngineInstance->initializeView();
        $view->dummy('foo');
        $return = self::$viewEngineInstance->renderView($view);
        $this->assertEquals('foo', $return);
    }

    /**
     *
     */
    public function testInitializeConcreteView()
    {
        $view = self::$viewEngineInstance->initializeView('AnotherDummy');
        $this->assertInstanceOf(AnotherDummyView::class, $view);

        $view->foo('foo');
        $return = self::$viewEngineInstance->renderView($view);
        $this->assertEquals('foo', $return);
    }

}
