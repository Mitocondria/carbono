<?php

class Carbono_Autoloader
{
    protected static $_instance;
    
    protected $_autoloaders = array();
    
    protected $_namespaces = array(
        'Carbono_'  => true,
    );
    
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function autoload($class)
    {
        $nameFile = str_replace('_', '/', $class);
        require $nameFile.'.php';
    }
    
    public function getNamespaceAutoloaders()
    {
        return $this->_namespaces;
    }
    
    protected function __construct()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
}