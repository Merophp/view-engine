# Introduction

Easy to use view engine with complexity hiding for view plugins.

## Installation

Via composer:

<code>
composer install merophp/view-engine
</code>

## Basic Usage

To use the view engine you have to create or use external view plugins. 

Example:
<pre><code>require_once 'vendor/autoload.php';

use MyPackage\HtmlPlugin\HtmlView;
use MyPackage\TextPlugin\TextView;
use MyPackage\JsonPlugin\JsonView;
use MyPackage\TemplatePlugin\TemplateView;
use MyPackage\TemplatePlugin\TemplateViewConfiguration;

use Merophp\ViewEngine\ViewEngine;
use Merophp\ViewEngine\ViewPlugin\Collection\ViewPluginCollection;
use Merophp\ViewEngine\ViewPlugin\Provider\ViewPluginProvider;
use Merophp\ViewEngine\ViewPlugin\ViewPlugin;

$templateViewConfiguration = new TemplateViewConfiguration();
$templateViewConfiguration->setViewDir('.');

$collection = new ViewPluginCollection();
$collection->addMultiple([
    new ViewPlugin(TextView::class),
    new ViewPlugin(HtmlView::class),
    new ViewPlugin(JsonView::class),
    new ViewPlugin(TemplateView::class, $templateViewConfiguration)
]);

$provider = new ViewPluginProvider($collection);

$viewEngine = new ViewEngine($provider);

$view = $viewEngine->initializeView();
$view->json(['test' => 1]);
echo $viewEngine->renderView($view);

</code></pre>

### View Proxy
The view engine uses a proxy for view classes. The specialty is that you 
get a view proxy instance without a real view by calling <i>$viewEngine->initializeView()</i>.
The view to wrap will be determined by the next called method. 

For Example: <br />
<pre><code>$view = $viewEngine->initializeView();
echo $view->getViewType(); //Will print 'undefined'
$view->json(['test' => 1]);
echo $view->getViewType(); //Will print 'Json'
echo $viewEngine->renderView($view);
</code></pre>

Once determined the view type can not be changed for that instance.

### View Plugins

A view plugin consists at minimum of a view class that implements
Merophp\ViewEngine\ViewPlugin\ViewInterface and has at least one public
non-magic & non-static method tagged with <i>@api</i>. 

<pre><code>use Merophp\ViewEngine\ViewPlugin\ViewInterface;

class DummyView implements ViewInterface{

    public function render(): string
    {
        return 'test';
    }

    /**
     * Method calls are forwarded by the view proxy
     * @param $value
     * @api
     */
    public function dummy($value)
    {
        return 'foo';
    }

    /**
     * Method calls are not forwarded by the view proxy due to their static type 
     * @param $value
     * @api
     */
    public static function dummy2($value)
    {
        echo 'foo';
    }

    public function getContentType(): string
    {
        return '';
    }
}
</code></pre>

# The Aim

The aim is to use the view engine as part of a framework to simplify the creation
of views for the framework users. So you can provide an empty view proxy instance 
inside a controller action so the user can choose between some view types by 
calling methods on the proxy instance.

## Be Aware of the Cons

Cause of the mechanic it isn't possible to use IDE functionality such as auto-fill 
or interface hints. In some cases, it also can be a little confusing cause of 
the dynamic interface of the proxy. As a framework developer using this library, 
you should document the possible view interfaces of the proxy well.
