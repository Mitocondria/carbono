<?php
class Carbono_Init
{
    protected $_enviroment;
    protected $_config;
    protected $_request;
    protected $_controller;
    protected $_action;
    protected $_params;
    
    public function __construct($enviroment, $options = null)
    {
        $this->_enviroment = (string) $enviroment;
        
        require_once SYSTEM_PATH.'/Config/Ini.php';
        
        if ($options !== null) {
            if (is_string($options)) {
                $options = $this->_loadConfig($options, $enviroment);
            }
            $this->setOptions($options);
        }
        
        require 'Autoloader.php';
        $autoloader = Carbono_Autoloader::getInstance();
        
        $this->loadUrlRequest();
        $this->loadMVC();
    }
    
    protected function _loadConfig($file, $enviroment)
    {
        $suffix = pathinfo($file, PATHINFO_EXTENSION);
        switch (strtolower($suffix)) {
            case 'ini' :
                $this->_config = new Carbono_Config_Ini($file, $enviroment);
                break;
        }
        return $this->_config->toArray();
    }
    
    public function setOptions(array $options)
    {
        if (!empty($options['includePaths'])) {
            $this->setIncludePaths($options['includePaths']);
        }
        $this->loadPackages($options['distribution']);
    }
    
    public function loadPackages($distribution = 'estable')
    {
        $this->setIncludePaths(APPLICATION_PATH."/../packages/".$distribution);
    }
    
    public function setIncludePaths($path)
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . realpath($path));
        return $this;
    }
    
    public function loadUrlRequest()
    {
        $dataServer = $_SERVER['REQUEST_URI'];
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