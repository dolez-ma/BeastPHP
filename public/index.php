<?php
/**
 * @package Beast
 * @licence MIT
 * @author dolezma
 */

ini_set('display_errors', '1');

$beast = require_once(__DIR__ . '/../vendor/dolezma/BeastPHP/src/Framework/Bootstrap.php');

$beast->wakeUp();

echo $beast->getConfiguration()->getPath()->getBasepath() . '<br />';
echo $beast->getUrl()->getBaseurl();