<?php

use Merophp\ViewEngine\ViewPlugin\ViewPlugin;
use PHPUnit\Framework\TestCase;

/**
 * @covers ViewPlugin
 */
class ViewPluginTest extends TestCase
{
    public function testConstructWithInvalidViewClass()
    {
        $this->expectException(Exception::class);
        $test = new ViewPlugin(Exception::class);
    }
}
