<?php

class Admin_SetoresController extends Zend_Controller_Action {

    public function init() {
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addContext('js', array('suffix' => 'js'));
        $ajaxContext->setAutoJsonSerialization(false);
        $ajaxContext->addActionContext('index', array('json', 'xml', 'js'))
                ->addActionContext('create', array('html', 'json', 'xml'))
                ->addActionContext('update', array('html', 'json', 'xml'))
                ->addActionContext('delete', array('html', 'json', 'xml'))
                ->addActionContext('get', array('html', 'json', 'xml'))
                ->addActionContext('get2grid', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function indexAction() {
        // action body
    }

    public function createAction() {
        $setor = $this->_getParam('setor');
        $id = $this->_getParam('id');
        $model_setores = new Model_Setores();

        try {
            $setor['id'] = $model_setores->insert($setor);
            $this->view->response = array('dados' => $setor,
                'notice' => 'Dados inseridos com sucesso',
                'descricao' => $setor ['nome']);
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(501);
            $this->getResponse()->setException($e);
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
        }
    }

    public function updateAction() {
        $setor = $this->_getParam('setor');
        if ($setor['setor_id'] == '')
            unset($setor['setor_id']);

        $id = $this->_getParam('id');
        $model_setor = new Model_Setores();

        try {
            $model_setor->update($setor, array('id=?' => $id));
            $this->view->response = array('dados' => $setor,
                'notice' => 'Dados atualizados com sucesso',
                'descricao' => $setor['nome']);
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(501);
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id');
        $model_setor = new Model_Setores();
        try {
            $setor = $model_setor->fetchRow('id=' . $id);
            $setor->situacao_id = 2;
            $setor->save();
            $this->view->response = array('dados' => $setor,
                'notice' => 'Setor apagado com sucesso',
                'descricao' => $setor->nome);
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(501);
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
        }
    }

    public function getAction() {
        $model_setores = new Model_Setores();
        $n_level = 0;
        if ($this->_getParam('nodeid')) {
            $setores = $model_setores->fetchAll("setor_id=" . $this->_getParam('nodeid'));
            $n_level = $this->_getParam('n_level') + 1;
        } else {
            $setores = $model_setores->fetchAll();
            $n_level = 0;
        }


        $this->view->dados = $setores;
    }

    public function get2gridAction() {
        $response = new stdClass ();
        $model_setores = new Model_Setores();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows");
        $sidx = $this->_request->getParam("sidx", 1);
        $sord = $this->_request->getParam("sord");
        $nodeid = $this->_getParam('nodeid');



        $n_level = 0;
        if ($nodeid) {
            $setores = $model_setores->fetchAll("situacao_id=1 and setor_id=" . $nodeid);
            $n_level = $this->_getParam('n_level') + 1;
        } else {
            $setores = $model_setores->fetchAll('situacao_id=1 and setor_id is null');
            $n_level = 0;
        }


        $response->page = 1;
        $response->total = 1;
        $response->records = count($setores);

        foreach ($setores as $setor) {
            /**
             * @todo implementar filtro para verificar no isleaf somente os setores com situacao_id =1
             */
            $leaf = count($setor->findModel_Setores()) == 0;
            $response->rows [] = array('id' => $setor->id,
                'nome' => $setor->nome,
                'sigla' => $setor->sigla,
                'descricao' => $setor->descricao,
                'setor_id' => $setor->setor_id,
                'level' => $n_level,
                'isLeaf' => $leaf,
                'parent' => $setor->setor_id,
                'colapsed' => false
            );
        }

        $this->view->dados = $response;
    }

}

