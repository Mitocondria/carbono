<?php
class Carbono_Init
{
    /**
     * Entorno de la aplicacion
     * 
     * @var string
     */
    protected $_enviroment;
    
    /**
     * Variables de configuracion de la aplicacion
     * 
     * @var Carbono_Config_Ini
     */
    protected $_config;
    
    /**
     * Variables de $_REQUEST de nuestra aplicacion
     * 
     * @var array
     */
    protected $_request;
    
    /**
     * Nombre del controlador llamado por la Url
     * 
     * @var string
     */
    protected $_controller;
    
    /**
     * Nombre del controlador llamado por la Url
     * 
     * @var string
     */
    protected $_action;
    
    /**
     * Variables enviadas por la Url a nuestra aplicacion, usando $_GET
     * 
     * @var array
     */
    protected $_params;
    
    /**
     * Constructor
     * 
     * Obtiene los datos del archivo de configuracion determinados en la 
     * variable $options, ademas estable el entorno en el que se trabajara.
     * 
     * @param string $enviroment
     * @param string $options
     */
    public function __construct($enviroment, $options = null)
    {
        require_once SYSTEM_PATH.'/Exception.php';
        
        $this->_enviroment = (string) $enviroment;
        
        if ($options !== null) {
            if (is_string($options)) {
                $options = $this->_loadConfig($options, $enviroment);
            }
            $this->setOptions($options);
        } else {
            throw new Carbono_Exception('No ha definido la ruta del archivo de configuracion de la aplicacion');
        }
        
        require 'Autoloader.php';
        $autoloader = Carbono_Autoloader::getInstance();
        
        $this->loadUrlRequest();
        $this->loadMVC();
    }
    
    /**
     * Lee el archivo de configuracion de la aplicacion con extension *.ini. 
     * Lo retorna en un array.
     * 
     * @param string $file
     * @param string $enviroment
     * @return array
     */
    
    protected function _loadConfig($file, $enviroment)
    {
        $suffix = pathinfo($file, PATHINFO_EXTENSION);
        switch (strtolower($suffix)) {
            case 'ini' :
                require_once SYSTEM_PATH.'/Config/Ini.php';
                $this->_config = new Carbono_Config_Ini($file, $enviroment);
                break;
            default:
                throw new Carbono_Exception('Extension no valida para el archivo de configuracion');
                break;
        }
        return $this->_config->toArray();
    }
    
    /**
     * Realiza la inclusion de librerias de acuerdo a la rutas definidas en el 
     * archivo INI de configuracion
     * 
     * @param array $options
     */
    public function setOptions(array $options)
    {
        if (!empty($options['includePaths'])) {
            $this->setIncludePaths($options['includePaths']);
        }
        $this->loadPackages($options['distribution']);
    }
    
    /**
     * Carga la carpeta de acuerdo a la distribucion escogida 
     * para la aplicacio
     * 
     * @param string $distribution
     */
    
    public function loadPackages($distribution = 'estable')
    {
        $this->setIncludePaths(APPLICATION_PATH."/../packages/".$distribution);
    }
    
    /**
     * Agrega al include_path la carpeta donde se encuentran las librerias
     * de acuerdo a la configuracion.
     * 
     * @param string $path
     */
    
    public function setIncludePaths($path)
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . realpath($path));
        return $this;
    }
    
    /**
     * Obtenemos la URL y obtenemos el controlador, accion y demas parametros 
     * de la variable $_SERVER['QUERY_STRING'], y reescribimos la varialbe 
     * $_REQUEST.
     */
    
    public function loadUrlRequest()
    {
        $dataServer = $_SERVER['QUERY_STRING'];
        $dataServer = explode('/', $dataServer);
        unset($dataServer[0]);
        if (isset($dataServer[1]) && $dataServer[1] != "") {
            $this->_request['controller'] = $dataServer[1];
            $this->_controller = $this->_request['controller'];
        } else {
            $this->_request['controller'] = $this->_config->defaultController;
            $this->_controller = $this->_config->defaultController;
        }
        
        if (isset($dataServer[2]) && $dataServer[2] != "") {
            $this->_request['action'] = $dataServer[2];
            $this->_action = $this->_request['action'];
        } else {
            $this->_request['action'] = "index";
            $this->_action = "index";
        }
        
        for ($i = 3; $i<=count($dataServer); $i++) {
            $this->_request[$dataServer[$i]] = @$dataServer[$i+1];
            $this->_params[$dataServer[$i]] = @$dataServer[$i+1];
            $i++;
        }
        $_REQUEST = $this->_request;
    }
    
    /**
     * A partir de los datos obtenidos por la Url, creamos el controlador y la
     * accion para ejecutarlo, respetando el patron de disenho MVC.
     */
    
    public function loadMVC()
    {
        require_once APPLICATION_PATH.'/modules/'.
            $this->_config->defaultModule.'/controllers/'.
            ucfirst($this->_controller.'Controller.php');
        
        $class = ucfirst($this->_controller.'Controller');
        $controller = new $class;
        $method = $this->_action.'Action';
        $controller->$method();
    }
}