<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Symfony\Component\Yaml\Yaml;

$config = json_decode($argv[1], true);

$labTwigTemplatePath = realpath(__DIR__ . '/../html');
$loader = new Twig_Loader_Filesystem($labTwigTemplatePath);
$loader->addPath($labTwigTemplatePath, 'lab');
foreach ($config['twig']['namespaces'] as $namespace => $path) {
    $loader->addPath($path, $namespace);
}
$twig = new Twig_Environment($loader);

$indexFileName = basename($config['scss']['indexFile']);
$cssFile = './css/' . str_replace('.scss', '.css', $indexFileName);

$twig->addGlobal('displayPatternsCss', $cssFile);

$filter = new Twig_SimpleFilter('dump', function ($string) {
    return '<pre>' . trim(Yaml::dump($string, /*inline*/1, /*indent*/2)) . '</pre>';
}, ['is_safe' => ['html']]);
$twig->addFilter($filter);

$factory = new \Chefkoch\DisplayPatternLab\Model\Factory();

$tree = $factory->start($config['twig']['rootDirectory']);

file_put_contents(
    __DIR__ . '/../output/index.html',
    $twig->render(
        '@lab/index.html.twig',
        array(
            'tree' => $tree
        )
    )
);