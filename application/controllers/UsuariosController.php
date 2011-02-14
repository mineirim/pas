<?php

class UsuariosController extends Zend_Controller_Action
{

    public function init()
    {
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addContext('js', array('suffix' => 'js'));
        $ajaxContext->setAutoJsonSerialization(false);
        $ajaxContext->addActionContext('index', array('json', 'xml', 'js'))
                ->addActionContext('get', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function indexAction()
    {
        // action body
    }

    public function getAction()
    {
        $model_usuarios = new Model_Usuarios();

        $usuarios = $model_usuarios->fetchAll("situacao_id=1", 'nome');


        $this->view->dados = $usuarios;
    }


}



