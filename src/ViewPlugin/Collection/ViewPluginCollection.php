<?php

namespace Merophp\ViewEngine\ViewPlugin\Collection;

use ArrayIterator;
use IteratorAggregate;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;

class ViewPluginCollection implements IteratorAggregate{

    /**
     * @var array
     */
    public array $viewPlugins = [];

    /**
     * @param ViewPlugin $viewPlugin
     */
    public function add(ViewPlugin $viewPlugin)
    {
        $this->viewPlugins[] = $viewPlugin;
    }

    /**
     * @param iterable $viewPlugins
     */
    public function addMultiple(iterable $viewPlugins)
    {
        foreach($viewPlugins as $viewPlugin){
            $this->add($viewPlugin);
        }
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !(bool)count($this->viewPlugins);
    }

    /**
     * @return iterable
     */
    public function getViewPlugins(): iterable
    {
        yield from $this->viewPlugins;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->viewPlugins);
    }

}
