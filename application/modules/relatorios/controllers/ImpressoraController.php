<?php

class Relatorios_ImpressoraController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->setLayout('layout_report');
    }

    public function indexAction()
    {
        $this->_nivel = $this->_getParam('nivel');
        $this->_id    = $this->_getParam('id');
    }

    public function programasAction()
    {

        $select_projetos = Model_Projetos::getDefaultAdapter()->select();
        $select_projetos->order(array('id'));
        $select_objetivos = Model_ObjetivosEspecificos::getDefaultAdapter()->select();
        $select_objetivos->order('id');
        $select_metas       = Model_Metas::getDefaultAdapter()->select();
        $select_metas->order('id');
        $this->_id    = $this->_getParam('id');

        $model_programas = new Model_Programas();
        $programas = $model_programas->fetchAll('id='.$this->_id, 'id');

        foreach ($programas as $k => $programa) {
            $programa = & $programas[$k];
            $programa->projetos = array();
            $select_projetos->where('situacao_id=1');
            $projetos = $programa->findModel_Projetos($select_projetos);
            foreach ($projetos as $projeto) {
                $select_objetivos->reset('where');
                $select_objetivos->where('situacao_id=1');
                $objetivos = $projeto->findModel_ObjetivosEspecificos($select_objetivos);
                foreach ($objetivos as $objetivo) {
                    $select_metas->reset('where');
                    $select_metas->where('situacao_id=1');
                    $metas = $objetivo->findModel_Metas($select_metas);
                    foreach ($metas as $meta) {
                        $objetivo->metas[]=$meta;
                    }
                    $projeto->objetivos[]=$objetivo;
                }
                $programa->projetos[]=$projeto;
            }
            unset($programa);

        }
        $this->view->programas = $programas;
        $this->render('padrao');
    }

    public function projetosAction()
    {

        $select_projetos = Model_Projetos::getDefaultAdapter()->select();
        $select_projetos->order(array('id'));
        $select_objetivos = Model_ObjetivosEspecificos::getDefaultAdapter()->select();
        $select_objetivos->order('id');
        $select_metas       = Model_Metas::getDefaultAdapter()->select();
        $select_metas->order('id');
        $this->_id    = $this->_getParam('id');

        $model_projetos = new Model_Projetos();
        $projeto = $model_projetos->fetchRow('id='.$this->_id);

        $programa = $projeto->findParentRow('Model_Programas');
        $arr_programa=array();
        if($programa) {
            $arr_programa[0] = & $programa;
            if($projeto) {
                $select_objetivos->reset('where');
                $select_objetivos->where('situacao_id=1');
                $objetivos = $projeto->findModel_ObjetivosEspecificos($select_objetivos);
                foreach ($objetivos as $objetivo) {
                    $select_metas->reset('where');
                    $select_metas->where('situacao_id=1');
                    $metas = $objetivo->findModel_Metas($select_metas);
                    foreach ($metas as $meta) {
                        $objetivo->metas[]=$meta;
                    }
                    $projeto->objetivos[]=$objetivo;
                }
                $arr_programa[0]->projetos[]=$projeto;
            }
        }
        $this->view->programas = $arr_programa;
        $this->render('padrao');
    }
}



