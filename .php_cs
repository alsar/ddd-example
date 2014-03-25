<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__ . '/src')
;
$config = Symfony\CS\Config\Config::create();

$config->finder($finder);
$config->addCustomFixer(new Alsar\CS\UseStatementOrderFixer());

return $config;
