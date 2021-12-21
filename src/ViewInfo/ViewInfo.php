<?php

namespace Merophp\ViewEngine\ViewInfo;

class ViewInfo
{
    private array $interfaceMethods;

    private string $viewClassName;

    private string $viewType;

    /**
     * @param string $className
     * @param array $viewInterfaceMethods
     * @param string $viewType
     */
    public function __construct(string $className, array $viewInterfaceMethods, string $viewType)
    {
        $this->viewClassName = $className;
        $this->interfaceMethods = $viewInterfaceMethods;
        $this->viewType = $viewType;
    }

    /**
     * @return array
     */
    public function getInterfaceMethods(): array
    {
        return $this->interfaceMethods;
    }

    /**
     * @return string
     */
    public function getViewClassName(): string
    {
        return $this->viewClassName;
    }

    /**
     * @return string
     */
    public function getViewType(): string
    {
        return $this->viewType;
    }

}
