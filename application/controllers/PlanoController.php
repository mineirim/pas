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
        
        $this->view->programas = $programas->fetchAll( "situacao_id=1", 'ordem'  );
        $this->view->nivel = 'Programas';
    }
	public function programaAction(){
		$projetos = new Model_Projetos ( );
		if($this->_hasParam('programa_id')){
      		$programas = new Model_Programas();
      		$programa_id = $this->_getParam ( 'programa_id', 0 );
      		$this->view->projetos = $projetos->fetchAll ( 'programa_id=' . $programa_id. 'and situacao_id=1 and projeto_id is null', 'ordem' );
			$this->view->programa = $programas->fetchRow("id=".$programa_id);
			$this->view->nivel = 'Programa';
			$this->view->tableheader = 'Projetos';
      	}
      	$this->renderScript ( 'plano/projeto.phtml' );
	}
    public function projetoAction()
    {
      	$projetos = new Model_Projetos ( );
      	$acoes = new Model_Acoes();
      	if($this->_hasParam('projeto_id')){
      		$projeto_id = $this->_getParam ( 'projeto_id', 0 );
      		$this->view->projeto = $projetos->fetchRow ( 'id=' . $projeto_id, 'id' );
      		$this->view->projetos = $projetos->fetchAll ( 'projeto_id=' . $projeto_id. 'and situacao_id=1', 'id' );
      		
      		$this->view->acoes	=	$acoes->fetchAll('projeto_id='. $projeto_id. 'and situacao_id=1', 'id' );
      		 
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'Projeto';
			$this->view->tableheader = 'Subprojetos';
      		
      	}
    }
    
    public function acaoAction()
    {
      	
      	$acoes = new Model_Acoes();
      	if($this->_hasParam('acao_id')){
      		$acao_id = $this->_getParam ( 'acao_id', 0 );
      		$this->view->acao = $acoes->fetchRow ( 'id=' . $acao_id, 'ordem' );
      		
      		$this->view->projeto = $this->view->acao->findParentRow('Model_Projetos');
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'Acao';
			$this->view->tableheader = 'Acoes';
      		
      	}else{
      		
      		echo $this->dispatch('programasAction');
      		
      	}
    }

    /*
     * metaAction()
     * @author Hugo
     */
    public function metaAction()
    {
      	
      	$metas = new Model_MetasAcao();
      	$operacoes = new Model_Operacoes();
      	if($this->_hasParam('meta_id')){
      		$meta_id = $this->_getParam ( 'meta_id', 0 );
      		$this->view->meta = $metas->fetchRow ( 'id=' . $meta_id, 'id' );
      		$this->view->operacoes	=	$operacoes->fetchAll('metas_acao_id=' . $meta_id . ' and situacao_id=1', 'id' );
      		
      		$this->view->acao = $this->view->meta->findParentRow('Model_Acoes');
      		$this->view->projeto = $this->view->acao->findParentRow('Model_Projetos');
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'Meta';
			$this->view->tableheader = 'Metas_Acao';
      		
      	}else{
      		
      		echo $this->dispatch('programasAction');
      		
      	}
    }
    
    /*
     * operacaoAction()
     * @author Hugo
     * 
     */
    public function operacaoAction()
    {
      	
      	$operacoes = new Model_Operacoes();
		$atividades = new Model_Atividades();
      	if($this->_hasParam('operacao_id')){
      		$operacao_id = $this->_getParam ( 'operacao_id', 0 );
      		$this->view->operacao = $operacoes->fetchRow ( 'id=' . $operacao_id, 'id' );
      		$this->view->atividades	=	$atividades->fetchAll('operacao_id=' . $operacao_id . ' and situacao_id=1', 'id' );

      		$this->view->meta = $this->view->operacao->findParentRow('Model_MetasAcao');
      		$this->view->acao = $this->view->meta->findParentRow('Model_Acoes');
      		$this->view->projeto = $this->view->acao->findParentRow('Model_Projetos');
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'Operação';
			$this->view->tableheader = 'Operacoes';
      		
      	}else{
      		
      		echo $this->dispatch('programasAction');
      		
      	}
    }

    /*
     * atividadeAction()
     * @author Hugo
     * 
     */
    public function atividadeAction()
    {
      	
      	$operacoes = new Model_Operacoes();
		$atividades = new Model_Atividades();
      	if($this->_hasParam('atividade_id')){
      		$atividade_id = $this->_getParam ( 'atividade_id', 0 );
      		$this->view->atividade = $atividades->fetchRow ( 'id=' . $atividade_id, 'id' );

			$this->view->operacao = $this->view->atividade->findParentRow('Model_Operacoes');
      		$this->view->meta = $this->view->operacao->findParentRow('Model_MetasAcao');
      		$this->view->acao = $this->view->meta->findParentRow('Model_Acoes');
      		$this->view->projeto = $this->view->acao->findParentRow('Model_Projetos');
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'Atividade';
			$this->view->tableheader = 'Atividades';
      		
      	}else{
      		
      		echo $this->dispatch('programasAction');
      		
      	}
    }
    
}







