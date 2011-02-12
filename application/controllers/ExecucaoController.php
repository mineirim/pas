<?php

class ExecucaoController extends Zend_Controller_Action
{

    public function init()
    {
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->setAutoJsonSerialization(false);
        $ajaxContext->addActionContext('index', array('json', 'xml'))
                ->initContext();

        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        
    }

    public function indexAction()
    {
        
        $nivel = $this->_getParam('progresso');
        $parent_id = $this->_getParam('parent_id');
        switch ($nivel) {
            case 1:
                $model_objetos = new Model_Programas();
                $objetos = $model_objetos->fetchAll('situacao_id=1');
                break;
            case 2:
                $model_objetos = new Model_Projetos();
                $objetos = $model_objetos->fetchAll("situacao_id=1 and programa_id=$parent_id");
                break;
            case 3:
                $model_objetos = new Model_Projetos();
                $objetos = $model_objetos->fetchAll("situacao_id=1 and projeto_id=$parent_id");
                break;
            case 4:
                $model_objetos = new Model_ObjetivosEspecificos();
                $objetos = $model_objetos->fetchAll("situacao_id=1 and projeto_id=$parent_id");
                break;
            case 5:
                $model_objetos = new Model_Metas();
                $objetos = $model_objetos->fetchAll("situacao_id=1 and objetivo_especifico_id=$parent_id");
                break;
            case 6:
                $model_objetos = new Model_Operacoes();
                $objetos = $model_objetos->fetchAll("situacao_id=1 and meta_id=$parent_id");
                break;
            case 7:
                $model_objetos = new Model_Atividades();
                $objetos = $model_objetos->fetchAll("situacao_id=1 and operacao_id=$parent_id");
                break;
            default:
                break;
        }
        $my_json = new stdClass();
        $atividades = new Model_Atividades ();
        if ($nivel == 7){
                foreach ($objetos as $resultado){
	                $pesodenominador = 100;
	                if ($resultado->conclusao_data){
	                        $pesototal = 100; // atividade realizada
	                } else {
	                        $pesototal = 0; // atividade não realizada
	                }
	                $ix = $resultado->id;
                	$my_json->$ix = $resultado;
                }
        } else {
            if($objetos){
                foreach ($objetos as $objeto) {
                    $id=$objeto->id;
                    if ($nivel == 6){
                            $pesodenominador = 100; // operação sempre terá denominador 100
                    } else {
                            $pesodenominador = $atividades->calculovalor($nivel, $id, 2);
                    }
                    $pesototal = $atividades->calculovalor($nivel, $id, 1);
                    $ix = $objeto->id;
                    $my_json->$ix = $pesodenominador>0?($pesototal/$pesodenominador)*100:0;
                }
            }
        }
        echo $this->_helper->_json($my_json);
    }
}