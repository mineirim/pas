<?php

class IndicadoresController extends Zend_Controller_Action
{
	/**
	 * @var Model_Indicadores $indicadores Model_Indicadores()
	 */
	private $indicadores;

    public function init()
    {
        /* Initialize action controller here */
    	$this->indicadores = new Model_Indicadores();
    	
    	
    }

    public function indexAction()
    {
        $this->view->indicadores = $this->indicadores->fetchAll(null,'id');
    }

    public function editAction()
    {
        // action body
    }


}



