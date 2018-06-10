<?php
/**
 * @package Beast
 * @licence MIT
 * @author dolezma
 */

ini_set('display_errors', '1');

$app = require_once(__DIR__ . '/../vendor/dolezma/BeastPHP/src/Framework/Bootstrap.php');

$app->run();

echo $app->getConfiguration()->getPath()->getBasepath() . '<br />';
echo $app->getUrl()->getBaseurl();