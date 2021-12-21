<?php

namespace Merophp\ViewEngine\ViewInfo\Factory;

use Exception;
use Merophp\ViewEngine\ViewInfo\ViewInfo;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;
use ReflectionClass;
use ReflectionMethod;

class ViewInfoFactory
{
    /**
     * Factory method that builds a ViewInfo Object for the given classname - using reflection
     *
     * @param ViewPlugin $viewPlugin The view plugin instance to build the view info for
     * @return ViewInfo the view info
     * @throws Exception
     */
    public function buildViewInfoFromViewPlugin(ViewPlugin $viewPlugin): ViewInfo
    {
        try {
            $reflectedClass = new ReflectionClass($viewPlugin->getViewClassName());
        } catch (Exception $e) {
            throw new Exception('Could not analyse class: "' . $viewPlugin->getViewClassName() . '" maybe not loaded or no autoloader? ' . $e->getMessage());
        }
        $viewInterfaceMethods = iterator_to_array($this->getViewInterfaceMethods($reflectedClass), false);
        return new ViewInfo($viewPlugin->getViewClassName(), $viewInterfaceMethods, $viewPlugin->getViewType());
    }

    /**
     * @param ReflectionClass $reflectedClass
     * @return iterable
     */
    private function getViewInterfaceMethods(ReflectionClass $reflectedClass): iterable
    {
        $reflectedPublicMethods = $reflectedClass->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach($reflectedPublicMethods as $reflectedPublicMethod){
            if($reflectedPublicMethod->isStatic())
                continue;

            if($this->isMagic($reflectedPublicMethod->getName()))
                continue;

            if(strpos($reflectedPublicMethod->getDocComment(), '@api') !== FALSE)
                yield $reflectedPublicMethod->getName();
        }
    }

    /**
     * @param string $methodName
     * @return bool
     */
    private function isMagic(string $methodName): bool
    {
        return substr($methodName, 0, 2) == '__';
    }
}
