<?php

//Definimos la Ruta de nuestra aplicacion
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../'));

//Definimos la Ruta del kernel del Framework
defined('SYSTEM_PATH') || define('SYSTEM_PATH', realpath(dirname(__FILE__) . '/../../kernel'));

//Iniciamos la aplicación
require_once SYSTEM_PATH.'/Init.php';
$application = new Carbono_Init(
    'development', 
    APPLICATION_PATH.'/config/application.ini'
);