<?php

namespace SMTC\MainBundle\Service;

use CG\Core\ClassUtils;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Config\FileLocatorInterface;

class GitHubLocator
{
    private $repository;
    private $rootDir;
    private $parser;
    private $locator;
    private $branch;

    public function __construct(TemplateNameParserInterface $parser, FileLocatorInterface $locator, $repository, $rootDir)
    {
        $this->parser = $parser;
        $this->locator = $locator;
        $this->repository = $repository;
        $this->rootDir = $rootDir;
        $this->branch = "master";
    }

    public function setBranch($branch)
    {
        $this->branch = $branch;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function getControllerLink($controller)
    {
        $class = get_class($controller[0]);
        if (class_exists('CG\Core\ClassUtils')) {
            $class = ClassUtils::getUserClass($class);
        }

        $r = new \ReflectionClass($class);
        $m = $r->getMethod($controller[1]);

        $relativeClassDir = str_replace(dirname($this->rootDir)."/", "", $r->getFilename());

        $anchor = sprintf("#L%d-%d", $m->getStartline(), $m->getEndline());

        return $this->getBaseFileLink() . "/" . $relativeClassDir . $anchor;
    }

    public function getTemplateLink($template)
    {
        $templateDir = $this->locator->locate($this->parser->parse($template->getTemplateName()));
        $templateRelativeDir = str_replace(dirname($this->rootDir)."/", "", $templateDir);

        return $this->getBaseFileLink() . "/" . $templateRelativeDir;
    }

    public function getBaseFileLink()
    {
        return $this->repository . "/" . $this->getBlobDir() . "/" . $this->branch;
    }

    private function getBlobDir()
    {
        return "blob";
    }
}
