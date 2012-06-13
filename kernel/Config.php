<?php
class Carbono_Config
{
    protected $_data;
    
    public function __construct($arrayData)
    {
        $this->_data = array();
        $this->_data = $arrayData;
    }
    
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
    
    public function __get($value)
    {
        $dataArray = $this->toArray();
        return $dataArray[$value];
    }
}