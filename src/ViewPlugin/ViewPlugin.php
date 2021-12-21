<?php
namespace Merophp\ViewEngine\ViewPlugin;

use Exception;
use Merophp\ViewEngine\ViewInterface;

class ViewPlugin{

    /**
     * @var string
     */
    protected string $viewClassName;

    /**
     * @var string
     */
    protected string $viewType;

    /**
     * @var mixed
     */
    protected $pluginConfiguration = null;

    /**
     * @param string $viewClassName
     * @param mixed $pluginConfiguration
     * @throws Exception
     */
    public function __construct(string $viewClassName, $pluginConfiguration = null)
    {
        if(!in_array(ViewInterface::class, class_implements($viewClassName, true)))
            throw new Exception('View class has to implement \Merophp\ViewEngine\ViewInterface');

        $this->viewClassName = $viewClassName;
        $this->pluginConfiguration = $pluginConfiguration;

        $viewCassNameParts = explode('\\', $viewClassName);
        $this->viewType = str_replace('View', '', end($viewCassNameParts));
    }

    /**
     * @return string
     */
    public function getViewClassName(): string
    {
        return $this->viewClassName;
    }

    /**
     * @return mixed|null
     */
    public function getPluginConfiguration()
    {
        return $this->pluginConfiguration;
    }

    /**
     * @return string
     */
    public function getViewType(): string
    {
        return $this->viewType;
    }
}
