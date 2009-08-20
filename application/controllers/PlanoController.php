<?php

class PlanoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function programasAction()
    {
        $programas = new Model_Programas ( );
        
        $this->view->programas = $programas->fetchAll ( null, 'id' );
    }

    public function projetosAction()
    {
      	$programa_id = $this->_getParam ( 'programa_id', 0 );
      	$programas = new Model_Programas();
		
		$projetos = new Model_Projetos ( );
		$this->view->projetos = $projetos->fetchAll ( 'programa_id=' . $programa_id, 'id' );
		$this->view->programa = $programas->fetchRow("id=".$programa_id);
    }


}







