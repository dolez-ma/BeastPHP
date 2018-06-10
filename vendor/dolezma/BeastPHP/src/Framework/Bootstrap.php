<?php

/**
 * @package Beast Framework
 * @licence MIT
 * @author dolezma
 */

define('SEP', DIRECTORY_SEPARATOR);
define('BASEPATH', realpath(__DIR__ . SEP . '..' . SEP . '..' . SEP . '..' . SEP . '..' . SEP . '..'));

/* **************************
 * * ERROR REPORTING LEVELS *
 * *************************/
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('display_errors', '1');

$autoloadPath = BASEPATH . SEP . 'vendor' . SEP . 'autoload.php';
require_once($autoloadPath);

/** @var \BeastPHP\Framework\Autoloader $autoLoader */
$autoLoader = \BeastPHP\DependencyInjection\Container::get(\BeastPHP\Framework\Autoloader::class);
$autoLoader->addLocation(BASEPATH . SEP . 'app');
$autoLoader->register();

if(PHP_SAPI === 'cli'){
    return \BeastPHP\DependencyInjection\Container::get(\BeastPHP\Cli\Application::class);
}

return \BeastPHP\DependencyInjection\Container::get(\BeastPHP\Framework\Application::class);
