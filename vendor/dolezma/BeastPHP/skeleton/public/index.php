<?php
/**
 * @package Beast
 * @licence MIT
 * @author dolezma
 */

ini_set('display_errors', '1');

$app = require_once(__DIR__ . '/../../src/Framework/Bootstrap.php');

$app->run();

echo $app->getConfig()->getPath()->getBasepath();