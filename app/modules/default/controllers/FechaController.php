<?php
class FechaController extends Carbono_Controller
{
    public function verAction()
    {
        $this->view->fechaActual = date('Y-m-d');
    }
}
