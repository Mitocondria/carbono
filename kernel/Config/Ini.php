<?php
require_once SYSTEM_PATH.'/Config.php';
require_once SYSTEM_PATH.'/Exception.php';

class Carbono_Config_Ini extends Carbono_Config
{
    /**
     * Constructor
     * 
     * Lee el archivo INI y devuelve los parametros de acuerdo a un entorno 
     * asignado
     * 
     * @param string $file
     * @param string $enviroment
     */
    public function __construct($file, $enviroment = 'development')
    {
        if ($enviroment == null) {
            throw new Carbono_Exception('Entorno no especificado');
        }
        if (file_exists($file)) {
            $iniArray = parse_ini_file($file, true);
            parent::__construct($iniArray[$enviroment]);
        } else {
            throw new Carbono_Exception('No se puede leer el archivo de configuracion');
        }
    }
    
}