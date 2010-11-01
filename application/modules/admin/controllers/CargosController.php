<?php

class Admin_CargosController extends Zend_Controller_Action
{

    public function init()
    {
        $ajaxContext = $this->_helper->ajaxContext;
                                                 		
                        		$ajaxContext->setAutoJsonSerialization(false);
                                $ajaxContext->addActionContext('index',array('json','xml'))
                                             ->addActionContext('create',array('html','json'))
                                             ->addActionContext('get',array('html','json'))
                                             ->addActionContext('procurartrimestre',array('json'))
                                             ->addActionContext('addindicador',array('json','html'))
                                             ->initContext();
    }

    public function indexAction()
    {
        $model_cargos = new Model_Cargos();
        $cargos = $model_cargos->fetchAll();
        $this->view->cargos = $cargos;
        
        
    }

    public function createAction()
    {
        // action body
    }

    public function updateAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function getAction()
    {
        // action body
    }

    public function putAction()
    {
        // action body
    }

    public function postAction()
    {
        // action body
    }


}













