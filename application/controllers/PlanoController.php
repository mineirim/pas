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
      	$projetos = new Model_Projetos ( );
      	if($this->_hasParam('projeto_id')){
      		$projeto_id = $this->_getParam ( 'projeto_id', 0 );
      		$this->view->projeto = $projetos->fetchRow ( 'id=' . $projeto_id, 'id' );
      		$this->view->projetos = $projetos->fetchAll ( 'projeto_id=' . $projeto_id. 'and situacao_id=1', 'id' );
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'Projeto';
			$this->view->tableheader = 'Subprojetos';
      		
      	}elseif($this->_hasParam('programa_id')){
      		$programas = new Model_Programas();
      		$programa_id = $this->_getParam ( 'programa_id', 0 );
      		$this->view->projetos = $projetos->fetchAll ( 'programa_id=' . $programa_id. 'and situacao_id=1', 'id' );
			$this->view->programa = $programas->fetchRow("id=".$programa_id);
			$this->view->nivel = 'Programa';
			$this->view->tableheader = 'Projetos';
      	}
      	
		
		
		
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







