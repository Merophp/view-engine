<?php

use Merophp\ViewEngine\ViewPlugin\Collection\ViewPluginCollection;
use Merophp\ViewEngine\ViewPlugin\Provider\ViewPluginProvider;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;
use PHPUnit\Framework\TestCase;

use Merophp\ViewEngine\ViewProxy;

/**
 * @covers ViewProxy
 */
class ViewProxyTest extends TestCase
{
    /**
     * @var ViewProxy
     */
    private static ViewProxy $inconcreteViewInstance;

    public static function setUpBeforeClass(): void
    {
        $collection = new ViewPluginCollection();
        $collection->add(
            new ViewPlugin(DummyView::class),
        );

        $provider = new ViewPluginProvider($collection);

        self::$inconcreteViewInstance = new ViewProxy($provider);
    }

    public function testRenderWithMissingConcreteView()
    {
        $this->expectException(Exception::class);
        self::$inconcreteViewInstance->render();
    }

    public function testGetContentTypeWithMissingConcreteView()
    {
        $this->expectException(Exception::class);
        self::$inconcreteViewInstance->getContentType();
    }

    public function testCall()
    {
        $this->assertInstanceOf(ViewProxy::class, self::$inconcreteViewInstance->dummy('test'));
    }

    public function testCallWithInvalidMethod()
    {
        $this->expectException(BadMethodCallException::class);
        self::$inconcreteViewInstance->dummy2('test');
    }

    public function testRender()
    {
        $this->assertEquals('test', self::$inconcreteViewInstance->render());
    }

    public function testGetContentType()
    {
        $this->assertEquals('text/plain;charset=utf-8', self::$inconcreteViewInstance->getContentType());
    }

    public function testGetViewType()
    {
        $this->assertEquals('Dummy', self::$inconcreteViewInstance->getViewType());
    }
}
