<?php

class PlanoController extends Zend_Controller_Action
{
	
    public function init()
    {
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
    	
    	
    	
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
      	$objetivos_especificos = new Model_ObjetivosEspecificos();
      	if($this->_hasParam('projeto_id')){
      		$projeto_id = $this->_getParam ( 'projeto_id', 0 );
      		$this->view->projeto = $projetos->fetchRow ( 'id=' . $projeto_id, 'id' );
      		$this->view->projetos = $projetos->fetchAll ( 'projeto_id=' . $projeto_id. 'and situacao_id=1', 'id' );
      		
      		$this->view->objetivos_especificos	=	$objetivos_especificos->fetchAll('projeto_id='. $projeto_id. 'and situacao_id=1', 'id' );
      		 
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'Projeto';
			$this->view->tableheader = 'Subprojetos';
      		
      	}
    }
    
    public function objetivosEspecificosAction()
    {
      	$metas = new Model_Metas();
      	$objetivosEspecificos = new Model_ObjetivosEspecificos();
      	if($this->_hasParam('objetivo_especifico_id')){
      		$objetivo_especifico_id = $this->_getParam ( 'objetivo_especifico_id', 0 );
      		$this->view->objetivo_especifico = $objetivosEspecificos->fetchRow ( 'id=' . $objetivo_especifico_id, 'ordem' );
      		$this->view->metas = $metas->fetchAll('objetivo_especifico_id='.$objetivo_especifico_id. 'and situacao_id=1', 'id');
      		$this->view->projeto = $this->view->objetivo_especifico->findParentRow('Model_Projetos');
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'ObjetivoEspecifico';
			$this->view->tableheader = 'Objetivos Especificos';
      		
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
      	
      	$metas = new Model_Metas();
      	$operacoes = new Model_Operacoes();
      	if($this->_hasParam('meta_id')){
      		$meta_id = $this->_getParam ( 'meta_id', 0 );
      		$this->view->meta = $metas->fetchRow ( 'id=' . $meta_id, 'id' );
      		$this->view->operacoes	=	$operacoes->fetchAll('meta_id=' . $meta_id . ' and situacao_id=1', 'id' );
      		
      		$this->view->objetivo_especifico = $this->view->meta->findParentRow('Model_ObjetivosEspecificos');
      		$this->view->projeto = $this->view->objetivo_especifico->findParentRow('Model_Projetos');
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'Meta';
			$this->view->tableheader = 'Metas';
      		
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
		$atividadesprazo = new Model_AtividadesPrazo();
		if($this->_hasParam('operacao_id')){
      		$operacao_id = $this->_getParam ( 'operacao_id', 0 );
      		$this->view->operacao = $operacoes->fetchRow ( 'id=' . $operacao_id, 'id' );
      		$this->view->atividades	=	$atividades->fetchAll('operacao_id=' . $operacao_id . ' and situacao_id=1', 'id' );
      		$this->view->atividadeprazo = $atividadesprazo;
      		
      		$this->view->meta = $this->view->operacao->findParentRow('Model_Metas');
      		
      		$this->view->objetivo_especifico = $this->view->meta->findParentRow('Model_ObjetivosEspecificos');
      		$this->view->projeto = $this->view->objetivo_especifico->findParentRow('Model_Projetos');
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
		$atividadesprazo = new Model_AtividadesPrazo();
		$atividadesvinculadas = new Model_AtividadesVinculadas();
		if($this->_hasParam('atividade_id')){
      		$atividade_id = $this->_getParam ( 'atividade_id', 0 );
			$this->view->atividades = $atividades;
      		$this->view->atividade = $atividades->fetchRow ( 'id=' . $atividade_id, 'id' );
      		$this->view->atividadeprazo = $atividadesprazo->fetchAll('atividade_id=' . $atividade_id, 'id ASC');
      		$this->view->atividadevinculada = $atividadesvinculadas->fetchAll('atividade_id=' . $atividade_id, 'id ASC');
    		$inicio = new Zend_Date($this->view->atividade->inicio_data,Zend_Date::ISO_8601);
    		
    		$prazo =  new Zend_Date($this->view->atividade->prazo_data,Zend_Date::ISO_8601);
    		
    		$this->view->atividade->inicio_data = $inicio->toString('dd/MM/yyyy');
    		$this->view->atividade->prazo_data = $prazo->toString('dd/MM/yyyy');
      		
			$this->view->operacao = $this->view->atividade->findParentRow('Model_Operacoes');
      		$this->view->meta = $this->view->operacao->findParentRow('Model_Metas');
      		$this->view->objetivo_especifico = $this->view->meta->findParentRow('Model_ObjetivosEspecificos');
      		$this->view->projeto = $this->view->objetivo_especifico->findParentRow('Model_Projetos');
			$this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
			$this->view->nivel = 'Atividade';
			$this->view->tableheader = 'Atividades';
			$this->view->resource = "atividades";
      		
      	}else{
      		
      		echo $this->dispatch('programasAction');
      		
      	}
    }
    
}







