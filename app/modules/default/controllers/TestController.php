<?php
class TestController extends Carbono_Controller
{
    public function indexAction()
    {
        $this->view->dato = 'test';
    }
    
    public function otroAction()
    {
        $this->view->otro = 'Otro dato probando el layout';
        $this->view->texto = 'Este es un texto de prueba de carbono framework';
    }
}