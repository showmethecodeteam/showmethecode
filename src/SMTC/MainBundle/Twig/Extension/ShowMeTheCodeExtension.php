<?php

namespace SMTC\MainBundle\Twig\Extension;

use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
use CG\Core\ClassUtils;
use SMTC\MainBundle\Service\GithubLocator;

class ShowMeTheCodeExtension extends \Twig_Extension
{
    protected $loader;
    protected $controller;
    protected $githubLocator;

    public function __construct(FilesystemLoader $loader, GithubLocator $githubLocator)
    {
        $this->loader = $loader;
        $this->githubLocator = $githubLocator;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'code' => new \Twig_Function_Method($this, 'getCode', array('is_safe' => array('html'))),
        );
    }

    /**
     * Gets the code from the template
     * @param  Twig_Template $template
     * @return HTML to display
     */
    public function getCode($template)
    {
        $controllerClass = get_class($this->controller[0]);
        if (class_exists('CG\Core\ClassUtils')) {
            $controllerClass = ClassUtils::getUserClass($controllerClass);
        }

        $methodName = $this->controller[1];

        $controllerLink = $this->githubLocator->getMethodClassLink($controllerClass, $methodName);
        $templateLink = $this->githubLocator->getTemplateLink($template->getTemplateName());

        $controller = $this->getControllerCode($controllerClass, $methodName);
        $template = $this->getTemplateCode($template);

        // remove the code block
        $template = str_replace('{% set code = code(_self) %}', '', $template);

        return <<<EOF
<h4><strong>Controller Code - <a href="$controllerLink">Github</a></strong></h4>
<pre class="prettyprint">$controller</pre>

<h4><strong>Template Code - <a href="$templateLink">Github</a></strong></h4>
<pre class="prettyprint">$template</pre>
EOF;
    }

    private function getControllerCode($controllerClass, $methodName)
    {

        $r = new \ReflectionClass($controllerClass);
        $m = $r->getMethod($methodName);

        $code = file($r->getFilename());

        $controllerCode = '    '.$m->getDocComment()."\n".implode('', array_slice($code, $m->getStartline() - 1, $m->getEndLine() - $m->getStartline() + 1));

        return htmlspecialchars($controllerCode, ENT_QUOTES, 'UTF-8');
    }

    private function getTemplateCode($template)
    {
        $templateCode = $this->loader->getSource($template->getTemplateName());

        return htmlspecialchars($templateCode, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'smtc';
    }
}
