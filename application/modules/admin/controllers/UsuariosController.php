<?php

class Admin_UsuariosController extends Zend_Controller_Action {

    public function init() {
        $auth = Zend_Auth::getInstance();
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addContext('js', array('suffix' => 'js'));
        $ajaxContext->setAutoJsonSerialization(false);
        $ajaxContext->addActionContext('index', array('json', 'xml', 'js'))
                ->addActionContext('create', array('html', 'json', 'xml'))
                ->addActionContext('update', array('html', 'json', 'xml'))
                ->addActionContext('delete', array('html', 'json', 'xml'))
                ->addActionContext('get', array('html', 'json', 'xml'))
                ->addActionContext('get2grid', array('html', 'json', 'xml'))
                ->addActionContext('salvar', array('json', 'xml'))
                ->addActionContext('localizar', array('html', 'json', 'xml'))
                ->initContext();

        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function indexAction() {
        $this->view->title = "Usuários";
        $this->view->headTitle($this->view->title, 'PREPEND');
        /*         * $usuarios = new Model_Usuarios();
          $this->view->usuarios = $usuarios->fetchAll("situacao_id=1",'nome');
          $this->view->usuarios_excluidos = $usuarios->fetchAll("situacao_id<>1",'nome');
         */
    }

    public function addAction() {
        $this->view->title = "Adicionar usuário";
        $this->view->headTitle($this->view->title, 'PREPEND');
        $form = new Form_Usuario();
        $form->submit->setLabel('Adicionar');
        $form->addUsernameAndPassword();
        $form->password->addValidator('NotEmpty')->setRequired(true);
        $form->username->addValidator('NotEmpty')->setRequired(true);
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $nome = $form->getValue('nome');
                $username = $form->getValue('username');
                $password = $form->getValue('password');
                $email = $form->getValue('email');

                $dados = array('nome' => $nome, 'username' => $username, 'password' => $password, 'email' => $email);
                $grupos = $form->getValue('grupos');

                $usuarios = new Model_Usuarios();
                $usuarios->addUsuario($dados, $grupos);
                $this->_redirect('usuarios');
            } else {
                $form->populate($formData);
            }
        }
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function adicionarAction() {
        $this->view->title = "Adicionar usuário";
        $this->view->headTitle($this->view->title, 'PREPEND');
        $form = new Form_Usuario();
        $form->submit->setLabel('Adicionar');
        $form->addUsernameAndPassword();
        $form->password->addValidator('NotEmpty')->setRequired(true);
        $form->username->addValidator('NotEmpty')->setRequired(true);
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $nome = $form->getValue('nome');
                $username = $form->getValue('username');
                $password = $form->getValue('password');
                $email = $form->getValue('email');

                $dados = array('nome' => $nome, 'username' => $username, 'password' => $password, 'email' => $email);
                $grupos = $form->getValue('grupos');

                $usuarios = new Model_Usuarios();
                $usuarios->addUsuario($dados, $grupos);
                $this->_redirect('usuarios');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction() {
        $this->view->title = "Editar usuário";
        $this->view->headTitle($this->view->title, 'PREPEND');
        $form = new Form_Usuario();
        $form->submit->setLabel('Salvar');
        $this->view->form = $form;

        $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $valores = array();
            $grupos = new Model_UsuariosGrupos();
            foreach ($grupos->fetchAll("usuario_id=$id") as $p)
                $valores [] = $p->grupo_id;

            $form->getElement('grupos')->setValue($valores);
            $model_usuarios = new Model_Usuarios();
            $form->populate($model_usuarios->getUsuario($id));
        } else {
            $this->view->response = array('notice' => 'Usuário não localizado',
                'errormessage' => "Informe um código de usuário para editar");
            $this->restoreAction("erro.phtml");
        }
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function changepasswordAction() {
        $usuarios = new Model_Usuarios();


        $auth = Zend_Auth::getInstance ();
        $id_auth = $auth->getIdentity()->id;


        if ($id_auth) {

            $this->view->usuario = $usuarios->find($id_auth)->current();

            $this->view->title = "Alterar senha";
            $this->view->headTitle($this->view->title, 'PREPEND');
            $form = new Zend_Form();
            $id = new Zend_Form_Element_Hidden('id');
            $id->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty');
            $password = new Zend_Form_Element_Password('password');

            $password->setLabel("Nova senha")
                    ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty');
            $confirm = new Zend_Form_Element_Password('confirm');
            $confirm->setLabel("Confirmar senha");
            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setLabel('Alterar');
            $form->addElements(array($id, $password, $confirm, $submit));
            $this->view->form = $form;
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    $id = (int) $form->getValue('id');
                    $password = $form->getValue('password');

                    $dados = array('id' => $id, 'password' => $password);


                    $usuarios->updatePassword($dados, 'id=' . $id);
                    $this->_redirect('index');
                } else {

                    $form->populate($formData);
                }
            } else {

                $id = $id_auth;
                if ($id > 0) {
                    $usuarios = new Model_Usuarios();
                    $form->populate($usuarios->getUsuario($id));
                }
            }
        } else {
            $this->_redirect('index');
        }
    }

    public function deleteAction() {
        $this->view->title = "Apagar Usuário";
        $this->view->headTitle($this->view->title, 'PREPEND');
        if ($this->getRequest()->isPost()) {
            $id = $this->getRequest()->getPost('id');
            //não se pode apagar o usuário administrador
            if ($id != 2) {
                $del = $this->getRequest()->getPost('del');
                if ($del == 'Sim') {
                    $usuarios = new Model_Usuarios();
                    $usuarios->deleteUsuario($id);
                }
                $this->_redirect('usuarios');
            }
        } else {
            $id = $this->_getParam('id');
            $usuarios = new Model_Usuarios();
            $this->view->usuario = $usuarios->getUsuario($id);
        }

        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function restoreAction() {
        if ($this->getRequest()->isPost()) {
            $restore = $this->getRequest()->getPost('restore');
            $id = $this->getRequest()->getPost('id');
            $model_usuarios = new Model_Usuarios();
            if ($restore == 'Sim') {
                
                $model_usuarios->restoreUsuario($id);
                $usuario = $model_usuarios->fetchRow('id='.$id);
            }
            if($this->_getParam('format')=='json'){
                $this->view->response = array('dados' => $usuario->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $dados['nome']);
            }else{
                $this->_redirect('usuarios');
            }
        } else {
            $this->view->title = "Restaurar Usuário";
            $this->view->headTitle($this->view->title, 'PREPEND');

            $id = $this->_getParam('id');
            $model_usuarios = new Model_Usuarios();
            $this->view->usuario = $model_usuarios->getUsuario($id);
        }

    }

    public function resetAction() {
        $this->view->title = "Resetar Senha";
        $this->view->headTitle($this->view->title, 'PREPEND');
        if ($this->getRequest()->isPost()) {
            $restore = $this->getRequest()->getPost('reset');
            if ($restore == 'Sim') {
                $id = $this->getRequest()->getPost('id');
                $dados = array('id' => $id, 'password' => 'saudesp');
                $usuarios = new Model_Usuarios();
                $usuarios->updatePassword($dados, 'id=' . $id);
            }
            $this->_redirect('usuarios');
        } else {
            $id = $this->_getParam('id');
            $usuarios = new Model_Usuarios();
            $this->view->usuario = $usuarios->getUsuario($id);
        }

        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function localizarAction() {
        $model_usuarios = new Model_Usuarios();
        $this->_helper->viewRenderer->setNoRender(true);

        $response = new stdClass();
        $page = $this->_getParam('page', 1);
        $limit = $this->_getParam('rows', 15);
        $sidx = $this->_getParam('sidx', 'nome');
        $sord = $this->_getParam('sord'); // get the direction
        $where = " situacao_id=" . $this->_getParam('situacao_id', 1);
        if ($this->_getParam('_search') == "true") {
            $filtros = Zend_Json::decode($this->_getParam('filters'), Zend_Json::TYPE_OBJECT);
            foreach ($filtros->rules as $regra) {
                $where .= " " . $filtros->groupOp . " " . $regra->field . " like '%" . $regra->data . "%'";
            }
        }

        $usuarios = $model_usuarios->fetchAll($where);

        $count = $usuarios->count();
        $total_pages = $count > 0 ? ceil($count / $limit) : $total_pages = 1;
        $page = ($page > $total_pages) ? $total_pages : $page;

        $start = $limit * $page - $limit; // do not put $limit*($page - 1)


        $usuarios = $model_usuarios->fetchAll($where, $sidx, $limit, $start);

        $response->page = $page;
        $response->total = $total_pages;
        $response->records = $count;

        foreach ($usuarios as $usuario) {
            $response->rows[] = $usuario->toArray();
        }

        $this->_helper->json($response);
    }

    public function updateAction() {
        $form = new Form_Usuario();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $dados = $form->getValue('usuario'); // array('id' => $id, 'nome' => $nome, 'email' => $email);
                $grupos = $form->getValue('grupos');
                $id = (int) $dados['id'];
                try {
                    $usuarios = new Model_Usuarios();
                    $usuarios->updateUsuario($dados, $grupos, 'id=' . $id);
                    $usuario = $usuarios->fetchRow('id=' . $id);
                    $this->view->response = array('dados' => $usuario->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $dados['nome']);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->getResponse()->setException($e);
                    $this->view->response = array('notice' => 'Erro ao gravar dados',
                        'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $this->view->response = array('notice' => 'Erro ao gravar dados',
                    'errormessage' => $e->getMessage(),
                    'errors' => $form->getErrors()
                );
            }
        }
    }

}

