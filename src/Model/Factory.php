<?php

namespace Chefkoch\DisplayPatternLab\Model;

use Symfony\Component\Finder\SplFileInfo;

class Factory
{

    /**
     * @param $path
     * @return Directory
     */
    public function start($path)
    {
        return $this->createFilesystemNode(new SplFileInfo($path, '', ''));
    }

    /**
     * @param SplFileInfo $file
     * @return AbstractFilesystemNode
     */
    private function createFilesystemNode(SplFileInfo $file)
    {
        $finder = new \Symfony\Component\Finder\Finder();


        switch (true) {
            case ($file->getBasename() == 'node_modules'):
                return null;
            case $file->isDir():

                $depth = empty($file->getRelativePathname()) ? 0 : count(explode('/', $file->getRelativePathname()));

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
                    ->depth($depth)
                    ->path('(^' . preg_quote($file->getRelativePathname()) . ')');

                $directory = new Directory($file);

                foreach ($finder as $file) {
                    if ($filesystemNode = $this->createFilesystemNode($file)) {
                        $directory->addContent($filesystemNode);
                    }
                }

                return $directory;
            case preg_match('(\.twig$)', $file->getBasename()):
                return new TwigFile($file);
            case preg_match('(\.json$)', $file->getBasename()):
                return new JsonFile($file);
            case preg_match('(\.(yml|yaml)$)', $file->getBasename()):
                return new YamlFile($file);
            case preg_match('(\.md$)', $file->getBasename()):
                return new MarkdownFile($file);
            case preg_match('(\.scss$)', $file->getBasename()):
                return new ScssFile($file);
            default:
                return null;
        }
    }
}
