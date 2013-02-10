<?php

namespace SMTC\MainBundle\Tests\Service;

use SMTC\MainBundle\Service\GitHubLocator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GitHubLocatorTest extends WebTestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $parser;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $locator;

    /**
     * @var GitHubLocator
     */
    private $githubLocator;

    /**
     * @var string
     */
    private $githubRepository;

    /**
     * @var string
     */
    private $rootdir;

    protected function setUp()
    {
        $this->parser = $this->getMock('Symfony\Component\Templating\TemplateNameParserInterface');
        $this->locator = $this->getMock('Symfony\Component\Config\FileLocatorInterface');
        $this->repository = "https://github.com/showmethecodeteam/showmethecode";
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->rootdir = static::$kernel->getContainer()->getParameter('kernel.root_dir');

        $this->githubLocator = new GitHubLocator($this->parser, $this->locator, $this->repository, $this->rootdir);
    }

    public function testGetTemplateLink()
    {
        $templateName = 'SMTCMainBundle:Default:index.html.twig';

        $this->parser
            ->expects($this->once())
            ->method('parse')
            ->with($templateName)
        ;

        $templateDir = dirname($this->rootdir)."/src/SMTC/MainBundle/Resources/views/Default/index.html.twig";

        $this->locator
            ->expects($this->once())
            ->method('locate')
            ->will($this->returnValue($templateDir));

        $templateLink = sprintf('%s/blob/master/src/SMTC/MainBundle/Resources/views/Default/index.html.twig', $this->repository);

        $this->assertEquals($templateLink, $this->githubLocator->getTemplateLink($templateName));
    }

    public function testGetMethodClassLink()
    {
        $className = "SMTC\MainBundle\Tests\Service\Fixtures\Foo";
        $methodName = "bar";
        $lineAnchor = "#L7-10";

        $classLink = sprintf('%s/blob/master/src/SMTC/MainBundle/Tests/Service/Fixtures/Foo.php%s', $this->repository, $lineAnchor);

        $this->assertEquals($classLink, $this->githubLocator->getMethodClassLink($className, $methodName));
    }
}