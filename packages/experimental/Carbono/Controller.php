<?php
class Carbono_Controller
{
    protected $view;
    
    private $_params;
    
    public function __construct($data = null)
    {
        $this->view = new Carbono_View();
        $this->_params = $_REQUEST;
    }
    
    public function loadView()
    {
        
    }
    
    public function getAllParams()
    {
        return $this->_params;
    }
    
    public function __destruct()
    {
        $this->view->render();
    }
}