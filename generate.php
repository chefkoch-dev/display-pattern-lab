<?php

require_once(__DIR__ . '/vendor/autoload.php');

$pathToDisplayPatterns = $argv[1];

$finder = new \Symfony\Component\Finder\Finder();
$finder = $finder
    ->in(__DIR__ . '/' . $pathToDisplayPatterns)
    ->name('*.twig');

$twig = new Twig_Environment(
    new Twig_Loader_Filesystem(array(__DIR__ . '/' . $pathToDisplayPatterns))
);

$output = '<html><head><link rel="stylesheet" type="text/css" href="/css/styles.css" /></head><body>';

foreach ($finder as $file) {
    /** @var $file \Symfony\Component\Finder\SplFileInfo */
    $directory = dirname($file->getRealPath());
    $fileName = basename($file->getRealPath());

    $dataFile = str_replace('.html.twig', '.yml', $file->getRealPath());

    if (file_exists($dataFile)) {
        $data = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($dataFile));
    } else {
        $data = array();
    }

    $html = $twig->render($file->getRelativePathname(), $data);

    $output .= $html;
}

$output .= '</body>';

file_put_contents(__DIR__ . '/output/index.html', $output);