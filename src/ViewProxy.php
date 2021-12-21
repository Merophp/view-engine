<?php
namespace Merophp\ViewEngine;

use BadMethodCallException;
use Exception;
use Merophp\ViewEngine\ViewInfo\Factory\ViewInfoFactory;
use Merophp\ViewEngine\ViewInfo\ViewInfo;
use Merophp\ViewEngine\ViewPlugin\Provider\ViewPluginProvider;
use Merophp\ViewEngine\ViewInterface;

/**
 * The view facade
 */
class ViewProxy implements ViewInterface{

	/**
	 * @var ?ViewInterface
	 */
	protected ?ViewInterface $view = null;

	/**
	 * @var ?ViewInfo
	 */
	protected ?ViewInfo $viewInfo = null;

	/**
	 * @var ViewPluginProvider
	 */
	private ViewPluginProvider $viewPluginProvider;

	/**
     * @param ViewPluginProvider $viewPluginProvider
     */
    public function __construct(ViewPluginProvider $viewPluginProvider){
        $this->viewPluginProvider = $viewPluginProvider;
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function render(): string
	{
		if(!$this->hasConcreteView())
			throw new Exception('View is still inconcrete!');

		return $this->view->render();
	}

	/**
	 * @throws Exception
	 */
	public function getContentType(): string
	{
		if(!$this->hasConcreteView())
			throw new Exception('View is still inconcrete!');

		return $this->view->getContentType();
	}

	/**
	 * @param $methodName
	 * @param $arguments
	 * @return $this
	 * @throws Exception
	 */
	public function __call($methodName, $arguments){

		if(!$this->hasConcreteView())
			$this->determineViewByInterfaceMethod($methodName);

		if(
			!$this->hasConcreteView()
			|| !in_array($methodName, $this->viewInfo->getInterfaceMethods())
		)
			throw new BadMethodCallException(
				sprintf('Method "%s" does not belong to an interface of a known view class!', $methodName)
			);

		call_user_func_array([$this->view, $methodName], $arguments);

		return $this;
	}

	/**
	 * @param $methodName
	 * @throws Exception
	 */
	private function determineViewByInterfaceMethod($methodName)
	{
		$viewInfoFactory = new ViewInfoFactory;
		foreach($this->viewPluginProvider->getViewPlugins() as $viewPlugin){
			$className = $viewPlugin->getViewClassName();

			$viewInfo = $viewInfoFactory->buildViewInfoFromViewPlugin($viewPlugin);
			if(in_array($methodName, $viewInfo->getInterfaceMethods())){
				$this->viewInfo = $viewInfo;

				$this->view = new $className(
					$viewPlugin->getPluginConfiguration()
				);
				return;
			}
		}
	}

	/**
	 * @return bool
	 */
	public function hasConcreteView(): bool
	{
		return !is_null($this->viewInfo) || !is_null($this->view);
	}

	/**
	 * @return ViewInterface
	 * @throws Exception
	 */
	public function getConcreteView(): ViewInterface
	{
		if(!$this->hasConcreteView())
			throw new Exception('View is still inconcrete!');

		return $this->view;
	}

	public function getViewType(): string
	{
		if(!$this->hasConcreteView())
			return 'undefined';

		return $this->viewInfo->getViewType();
	}
}
?>
