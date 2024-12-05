<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->exclude('.history')
    ->exclude('vendor')
    ->exclude('var')
    ->exclude('config')
    ->exclude('build')
    ->exclude('node_modules')
    ->notPath('src/Kernel.php')
    ->notPath('public/index.php')
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PhpCsFixer' => true,
    '@PHP82Migration' => true,
    '@DoctrineAnnotation' => true,
    'phpdoc_summary' => false,
    'yoda_style' => [
        'equal' => false,
        'identical' => false,
        'less_and_greater' => false,
    ],
    'php_unit_method_casing' => ['case' => 'snake_case'],
    'declare_strict_types' => true,
])
    ->setFinder($finder)
;
