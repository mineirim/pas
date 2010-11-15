<?php

class InstrumentosController extends Zend_Controller_Action
{

    public function init()
    {
        if ($this->_request->isXmlHttpRequest())
                            $this->_helper->layout()->disableLayout();
    }

    /**
     * Lista todos os programas
     * 
     * 
     * 
     */
    public function indexAction()
    {
        $programas = new Model_Programas ( );
                        $this->view->programas = $programas->fetchAll("situacao_id=1", 'ordem');
                        $this->view->nivel = 'Programas';
    }

    public function programaAction()
    {
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

    public function projetoAction()
    {
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

    public function objetivoEspecificoAction()
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
                    $this->view->parent_id = $objetivo_especifico_id;
                    $this->view->nivel_id = 5;
              	}else{
                    echo $this->dispatch('programasAction');
                }
    }

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

      	}else
            echo $this->dispatch('programasAction');

      	
    }


}





