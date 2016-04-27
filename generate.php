<?php

require_once(__DIR__ . '/vendor/autoload.php');

$config = json_decode($argv[1], true);

$finder = new \Symfony\Component\Finder\Finder();
$finder = $finder
    ->in($config['twig']['rootDirectory'])
    ->name('*.twig');

@mkdir(__DIR__ . '/output', 0777, true);

$loader = null;
foreach ($config['twig']['namespaces'] as $namespace => $path) {
    if (!$loader) {
        $loader = new Twig_Loader_Filesystem($path);
    }
    $loader->addPath($path, $namespace);
}
$twig = new Twig_Environment($loader);

$indexFileName = basename($config['scss']['indexFile']);

$head = '<html><head><link rel="stylesheet" type="text/css" href="/css/' . str_replace('.scss', '.css', $indexFileName) . '" /></head><body>';
$foot = '</body>';
$documents = array();

foreach ($finder as $file) {
    /** @var $file \Symfony\Component\Finder\SplFileInfo */
    $directory = dirname($file->getRealPath());
    $fileName = basename($file->getRealPath());

    $data = array();

    $dataFileYaml = str_replace('.html.twig', '.yml', $file->getRealPath());
    if (file_exists($dataFileYaml)) {
        $data = array_merge($data, \Symfony\Component\Yaml\Yaml::parse(file_get_contents($dataFileYaml)));
    }
    $dataFileJson = str_replace('.html.twig', '.json', $file->getRealPath());
    if (file_exists($dataFileJson)) {
        $data = array_merge($data, json_decode(file_get_contents($dataFileJson), true));
    }

    $relativeDestinationFile = str_replace('.twig', '', $file->getRelativePathname());
    $destinationFile = __DIR__ . '/output/' . $relativeDestinationFile;
    $destinationDir = __DIR__ . '/output/' . $file->getRelativePath();
    @mkdir($destinationDir, 0777, true);
    file_put_contents($destinationFile, $twig->render($file->getRelativePathname(), $data));

    $documents[] = $relativeDestinationFile;
}

$output = '<html><head><link rel="stylesheet" type="text/css" href="/lab/lab.css" /></head><body>';
foreach ($documents as $document) {
    $output .= '<iframe src="' . $document . '"></iframe>';
}

$output .= '</body>';

file_put_contents(__DIR__ . '/output/index.html', $output);