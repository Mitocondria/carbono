<?php
class Carbono_View
{
    protected $_controller;
    protected $_action;
    protected $_data;
    protected $_layout;
    
    public function __construct()
    {
        $this->_controller = $_REQUEST['controller'];
        $this->_action = $_REQUEST['action'];
        $this->_layout = 'main';
    }
    
    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }
    
    public function __get($name)
    {
        return $this->_data[$name];
    }
    
    public function render()
    {
        require_once APPLICATION_PATH.'/layouts/'.$this->_layout.'.phtml';
    }
    
    public function renderPartial()
    {
        require_once APPLICATION_PATH.'/modules/default/views/'.
            strtolower($this->_controller).'/'.strtolower($this->_action).'.phtml';
    }
    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }
}