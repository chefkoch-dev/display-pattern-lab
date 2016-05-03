<?php

namespace Chefkoch\DisplayPatternLab\Model;

use Symfony\Component\Finder\SplFileInfo;

class Factory
{

    /**
     * @param $path
     * @return Node
     */
    public function start($path)
    {
        return $this->createDocument(new SplFileInfo($path, '', ''));
    }

    /**
     * @param SplFileInfo $file
     * @return Node
     */
    public function createDocument(SplFileInfo $file)
    {
        $finder = new \Symfony\Component\Finder\Finder();

        switch (true) {
            case ($file->getBasename() == 'node_modules'):
                return new UnknownFile($file);
            case $file->isDir():

                $directory = new Directory($file);

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

                $children = array();
                foreach ($finder as $file) {
                    $children[] = $this->createDocument($file);
                }

                $directory->fill($children);

                return $directory;
            case preg_match('(\.twig$)', $file->getBasename()):
                return new TwigFile($file);
            case preg_match('(\.md$)', $file->getBasename()):
                return new MarkdownFile($file);
            default:
                return new UnknownFile($file);
        }
    }
}
