<?php

namespace Merophp\ViewEngine\ViewPlugin\Provider;

use Merophp\ViewEngine\ViewPlugin\Collection\ViewPluginCollection;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;

class ViewPluginProvider
{
    protected ViewPluginCollection $viewPluginCollection;

    /**
     * @param ViewPluginCollection $viewPluginCollection
     */
    public function __construct(ViewPluginCollection $viewPluginCollection)
    {
        $this->viewPluginCollection = $viewPluginCollection;
    }

    /**
     * @return iterable
     */
    public function getViewPlugins(): iterable
    {
        yield from $this->viewPluginCollection->getViewPlugins();
    }

    /**
     * @param string $type
     * @return ?ViewPlugin
     */
    public function getViewPluginByType(string $type): ?ViewPlugin
    {
        foreach($this->viewPluginCollection->getViewPlugins() as $viewPlugin){
            if($viewPlugin->getViewType() == $type) {
                return $viewPlugin;
            }
        }
        return null;
    }

}
