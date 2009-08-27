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
        
        $this->view->programas = $programas->fetchAll( "situacao_id=1", 'id' );
    }

    public function projetosAction()
    {
      	$programa_id = $this->_getParam ( 'programa_id', 0 );
      	$programas = new Model_Programas();
		
		$projetos = new Model_Projetos ( );
		$this->view->projetos = $projetos->fetchAll ( 'programa_id=' . $programa_id. 'and situacao_id=1', 'id' );
		$this->view->programa = $programas->fetchRow("id=".$programa_id);
    }
    public function projetoAction()
    {
      	$id = $this->_getParam ( 'id', 0 );
      	
		$projetos = new Model_Projetos ( );
		$projeto = $projetos->find($id);
		
		$this->view->projeto = $projeto->current() ;
		$this->view->programa = $projeto->current()->findParentRow('Model_Programas');
		
    }
    

}







