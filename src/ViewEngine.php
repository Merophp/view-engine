<?php
namespace Merophp\ViewEngine;

use Exception;
use Merophp\ViewEngine\ViewPlugin\Provider\ViewPluginProvider;

class ViewEngine{

    /**
     * @var ViewPluginProvider
     */
    protected ViewPluginProvider $viewPluginProvider;

    /**
     * @param ViewPluginProvider $viewPluginProvider
     */
    public function __construct(ViewPluginProvider $viewPluginProvider)
    {
        $this->viewPluginProvider = $viewPluginProvider;
    }

    /**
     * Returns a concrete view class for a requested valid view type otherwise
     * it returns the view proxy with automatic on-demand detection.
     *
     * @param string $viewType
     * @return ViewInterface
     * @throws Exception
     */
	public function initializeView(string $viewType = ''): ViewInterface
    {
        if($viewType){
            $viewPlugin = $this->viewPluginProvider->getViewPluginByType($viewType);
            if(!$viewPlugin)
                throw new Exception(sprintf('View type "%s" is not registered.', $viewType));

            $className = $viewPlugin->getViewClassName();
            return new $className($viewPlugin->getPluginConfiguration());
        }
        else{
            return new ViewProxy($this->viewPluginProvider);
        }
	}

    /**
     * @param ViewInterface $view
     * @return string
     * @throws Exception
     */
	public function renderView(ViewInterface $view): string
    {
		return $view->render();
	}
}
