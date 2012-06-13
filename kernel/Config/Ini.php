<?php
require_once SYSTEM_PATH.'/Config.php';

class Carbono_Config_Ini extends Carbono_Config
{
    public function __construct($file, $enviroment)
    {
        $iniArray = parse_ini_file($file, true);
        
        parent::__construct($iniArray[$enviroment]);
    }
    
}