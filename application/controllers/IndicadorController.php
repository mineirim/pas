<?php

class IndicadorController extends Zend_Controller_Action
{

    public function init()
    {
        $this->indicadores = new Model_Indicadores ( );
    }

    public function indexAction()
    {
        // action body
    }

    public function showAction()
    {
        $id = $this->_getParam ( 'id' );
        		if (! $id) {
        			$msg = "id não informado";
        			$this->_redirect ( '/error/notfound/msg/' . $msg );
        		}
        $this->view->indicador = $this->indicadores->find ( $id )->current ();
        $this->view->indicadores_configs = $this->view->indicador->findDependentRowset('Model_IndicadoresConfiguracoes');
        
    }


}



