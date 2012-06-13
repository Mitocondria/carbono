<?php
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../'));

defined('SYSTEM_PATH') || define('SYSTEM_PATH', realpath(dirname(__FILE__) . '/../../kernel'));

require_once SYSTEM_PATH.'/Init.php';
$application = new Carbono_Init(
    'development', 
    APPLICATION_PATH.'/config/application.ini'
);