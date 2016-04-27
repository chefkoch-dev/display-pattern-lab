<?php

require_once(__DIR__ . '/vendor/autoload.php');

$config = json_decode($argv[1], true);

$finder = new \Symfony\Component\Finder\Finder();
$finder = $finder
    ->in($config['twig']['rootDirectory'])
    ->name('*.twig');

$loader = null;
foreach ($config['twig']['namespaces'] as $namespace => $path) {
    if (!$loader) {
        $loader = new Twig_Loader_Filesystem($path);
    }
    $loader->addPath($path, $namespace);
}
$twig = new Twig_Environment($loader);

$indexFileName = basename($config['scss']['indexFile']);

$output = '<html><head><link rel="stylesheet" type="text/css" href="/css/' . str_replace('.scss', '.css', $indexFileName) . '" /></head><body>';

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

@mkdir(__DIR__ . '/output', 0777, true);

file_put_contents(__DIR__ . '/output/index.html', $output);