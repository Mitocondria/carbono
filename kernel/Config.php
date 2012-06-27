<?php
require_once SYSTEM_PATH.'/Exception.php';

class Carbono_Config
{
    /**
     * Datos del archivo de configuracion
     * 
     * @var array
     */
    protected $_data = array();
    
    /**
     * Constructor
     * 
     * Asignamos los datos entregados a la variable $_data
     * 
     * @param unknown_type $arrayData
     */
    public function __construct($arrayData)
    {
        if (!isset($arrayData) || $arrayData = null) {
            throw new Carbono_Exception('No hay datos de configuracion');
        }
        $this->_data = $arrayData;
    }
    
    /**
     * Convertimos la variable $_data a un array.
     * 
     * @return multitype:array Carbono_Config
     */
    public function toArray()
    {
        $array = array();
        $data = $this->_data;
        foreach ($data as $key => $value) {
            if ($value instanceof Carbono_Config) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }
    
    /**
     * Retornamos el valor de una variable asignado en el archivo de 
     * configuracion
     * 
     * @param string $value
     * @return string
     */
    public function __get($value)
    {
        $dataArray = $this->toArray();
        return $dataArray[$value];
    }
}