<?php

class InstrumentosController extends Zend_Controller_Action {

    public function init() {
        if ($this->_request->isXmlHttpRequest())
            $this->_helper->layout()->disableLayout();
    }

    /**
     * Lista todos os programas
     * 
     */
    public function indexAction() {
        $programas = new Model_Programas ( );
        $this->view->programas = $programas->fetchAll("situacao_id=1", 'ordem');
        $this->view->nivel = 'Programas';
    }
    /*
     * exibe os detalhes de um programa específico
     */
    public function programaAction() {
        $projetos = new Model_Projetos ( );
        if ($this->_hasParam('programa_id')) {
            $programas = new Model_Programas();
            $programa_id = $this->_getParam('programa_id', 0);
            $this->view->projetos = $projetos->fetchAll('programa_id=' . $programa_id . 'and situacao_id=1 and projeto_id is null', 'ordem');
            $this->view->programa = $programas->fetchRow("id=" . $programa_id);
            $this->view->nivel = 'Programa';
            $this->view->tableheader = 'Projetos';
        }
        $this->view->parent_id = $programa_id;
        $this->view->nivel_id = 2;
    }

    public function projetoAction() {
      	$projetos = new Model_Projetos ( );
      	$objetivos_especificos = new Model_ObjetivosEspecificos();
      	if($this->_hasParam('projeto_id')){
            $projeto_id = $this->_getParam ( 'projeto_id', 0 );
            $this->view->projeto = $projetos->fetchRow ( 'id=' . $projeto_id, 'id' );
            $this->view->projetos = $projetos->fetchAll ( 'projeto_id=' . $projeto_id. 'and situacao_id=1', 'id' );
            $this->view->objetivos_especificos	=$objetivos_especificos->fetchAll('projeto_id='. $projeto_id. 'and situacao_id=1', 'id' );
            $this->view->programa = $this->view->projeto->findParentRow('Model_Programas');
            $this->view->nivel = 'Projeto';
            $this->view->tableheader = 'Subprojetos';
      	}
        $this->view->parent_id = $projeto_id;
        $this->view->nivel_id = 4;
        $this->render('programa');
    }

}

