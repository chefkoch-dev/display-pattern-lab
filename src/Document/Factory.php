<?php

namespace Chefkoch\DisplayPatternLab\Document;

use Symfony\Component\Finder\SplFileInfo;

class Factory
{

    /** @var \Twig_Environment */
    private $twig;

    /** @var string */
    private $cssFile;

    /**
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig, $cssFile)
    {
        $this->twig = $twig;
        $this->cssFile = $cssFile;
    }

    /**
     * @param $path
     * @return Base
     */
    public function start($path)
    {
        return $this->createDocument(new SplFileInfo($path, '', ''));
    }

    /**
     * @param SplFileInfo $file
     * @return Base
     */
    public function createDocument(SplFileInfo $file)
    {
        $finder = new \Symfony\Component\Finder\Finder();

        switch (true) {
            case $file->isDir():
                $directory = new Directory($file);

                if ($file->getBasename() != 'node_modules') {
                    $finder = $finder
                        ->in(
                            rtrim(
                                preg_replace(
                                    '(' . preg_quote($file->getRelativePathname()) . '$)',
                                    '',
                                    $file->getRealPath()
                                ),
                                '/'
                            )
                        )
                        ->depth($directory->getDepth())
                        ->path('(^' . preg_quote($file->getRelativePathname()) . ')');

                    foreach ($finder as $file) {
                        $directory->addChildDocument($this->createDocument($file));
                    }
                }
                return $directory;
            case preg_match('(.twig$)', $file->getBasename()):
                return new TwigFile($file, $this->twig, $this->cssFile);
            default:
                return new UnknownFile($file);
        }
    }
}
