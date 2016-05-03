<?php

namespace Chefkoch\DisplayPatternLab\Document;

use Symfony\Component\Finder\SplFileInfo;

class TwigFile extends Base
{

    /**
     * @return array
     */
    public function getData()
    {
        $data = array();

        $dataFileYaml = str_replace('.html.twig', '.yml', $this->getFile()->getRealPath());
        if (file_exists($dataFileYaml)) {
            $data = array_merge($data, \Symfony\Component\Yaml\Yaml::parse(file_get_contents($dataFileYaml)));
        }
        $dataFileJson = str_replace('.html.twig', '.json', $this->getFile()->getRealPath());
        if (file_exists($dataFileJson)) {
            $data = array_merge($data, json_decode(file_get_contents($dataFileJson), true));
        }

        return $data;
    }
}
