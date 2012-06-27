<?php
class Carbono_Controller
{
    /**
     * Vista relacionada al controlador
     * 
     * @var Carbono_View
     */
    protected $view;
    
    /**
     * Parametros request.
     * 
     * @var array
     */
    
    private $_params;
    
    /**
     * Constructor
     * 
     * Creamos una clase Carbono_view() y luego asignamos los datos del 
     * $_REQUEST a la variable $_params
     * 
     * @param string $data
     */
    
    public function __construct($data = null)
    {
        $this->view = new Carbono_View();
        $this->_params = $_REQUEST;
    }
    
    public function loadView()
    {
        
    }
    
    /**
     * Retornamos los parametros.
     * 
     * @return string
     */
    
    public function getAllParams()
    {
        return $this->_params;
    }
    
    /**
     * Luego de ejecutar todo, al final renderizamos la vista.
     */
    
    public function __destruct()
    {
        $this->view->render();
    }
}