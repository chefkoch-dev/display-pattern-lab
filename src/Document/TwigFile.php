<?php

namespace Chefkoch\DisplayPatternLab\Document;

use Symfony\Component\Finder\SplFileInfo;

class TwigFile extends Base
{

    /** @var \Twig_Environment */
    private $twig;

    /** @var string */
    private $cssFile;

    /**
     * @param SplFileInfo $file
     * @param \Twig_Environment $twig
     */
    public function __construct(SplFileInfo $file, \Twig_Environment $twig, $cssFile)
    {
        parent::__construct($file);
        $this->twig = $twig;
        $this->cssFile = $cssFile;
    }

    /**
     *
     */
    public function render()
    {
        $html = '<html><head><link rel="stylesheet" type="text/css" href="' . $this->cssFile . '" /></head><body>';

        $data = array();

        $dataFileYaml = str_replace('.html.twig', '.yml', $this->getFile()->getRealPath());
        if (file_exists($dataFileYaml)) {
            $data = array_merge($data, \Symfony\Component\Yaml\Yaml::parse(file_get_contents($dataFileYaml)));
        }
        $dataFileJson = str_replace('.html.twig', '.json', $this->getFile()->getRealPath());
        if (file_exists($dataFileJson)) {
            $data = array_merge($data, json_decode(file_get_contents($dataFileJson), true));
        }

        try {

            $html .= $this->twig->render($this->getFile()->getRelativePathname(), $data);

        } catch (\Exception $e) {
            $html = 'Pattern could not be rendered: ' . $e->getMessage();
        }

        $html .= '</bod></html>';

        return '<iframecontainer><iframedimensions>RESIZE ME!</iframedimensions><iframe srcdoc="' . htmlspecialchars($html) . '"></iframe></iframecontainer>';
    }
}
