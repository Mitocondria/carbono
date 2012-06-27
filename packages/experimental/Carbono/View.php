<?php
class Carbono_View
{
    /**
     * Controlador relacionada a la vista
     * 
     * @var string
     */
    protected $_controller;
    
    /**
     * Action relacionada a la vista
     * 
     * @var string
     */
    protected $_action;
    
    /**
     * Array de variables que se mostraran en la vista
     * 
     * @var array
     */
    protected $_data;
    
    /**
     * Nombre de la variable usada en la vista
     * 
     * @var string
     */
    protected $_layout;
    
    
    /**
     * Constructor
     * 
     * Obtenemos el controlador y la accion mediante la variable $_REQUEST 
     * y ademas asignamos el nombre del layout que usaremos (main por defecto).
     */
    public function __construct()
    {
        $this->_controller = $_REQUEST['controller'];
        $this->_action = $_REQUEST['action'];
        $this->_layout = 'main';
    }
    
    /**
     * Agregamos o modificamos una variable (generalmente en el controlador) 
     * que luego se mostrara en la vista.
     * 
     * @param string $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }
    
    /**
     * Retornamos el valor de una variable de la vista.
     * 
     * @param string $name
     */
    public function __get($name)
    {
        return $this->_data[$name];
    }
    
    /**
     * Renderizamos el layout.
     * 
     */
    public function render()
    {
        require_once APPLICATION_PATH.'/layouts/'.$this->_layout.'.phtml';
    }
    
    /**
     * Renderizamos solo la vista relacionada al controlador.
     * 
     */
    public function renderPartial()
    {
        require_once APPLICATION_PATH.'/modules/default/views/'.
            strtolower($this->_controller).'/'.strtolower($this->_action).'.phtml';
    }
    
    /**
     * Modificamos el nombre del layout usado en la vista.
     * 
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }
}