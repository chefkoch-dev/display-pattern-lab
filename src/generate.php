<?php

require_once(__DIR__ . '/../vendor/autoload.php');

$config = json_decode($argv[1], true);

$loader = null;
foreach ($config['twig']['namespaces'] as $namespace => $path) {
    if (!$loader) {
        $loader = new Twig_Loader_Filesystem($path);
    }
    $loader->addPath($path, $namespace);
}
$twig = new Twig_Environment($loader);

$indexFileName = basename($config['scss']['indexFile']);
$cssFile = '/css/' . str_replace('.scss', '.css', $indexFileName);

$factory = new \Chefkoch\DisplayPatternLab\Document\Factory($twig, $cssFile);

$tree = $factory->start($config['twig']['rootDirectory']);

$output = '<html><head><link rel="stylesheet" type="text/css" href="/lab/lab.css" /></head><body>';
$output .= $tree->render();
$output .= '</body>';

file_put_contents(__DIR__ . '/../output/index.html', $output);