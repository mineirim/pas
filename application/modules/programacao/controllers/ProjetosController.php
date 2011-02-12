<?php

class Programacao_ProjetosController extends Zend_Controller_Action {

    public function init() {
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addContext('js', array('suffix' => 'js'));
        $ajaxContext->setAutoJsonSerialization(false);
        $ajaxContext->addActionContext('index', array('json', 'xml', 'js'))
                ->addActionContext('create', array('html', 'json', 'xml'))
                ->addActionContext('update', array('html', 'json', 'xml'))
                ->addActionContext('delete', array('html', 'json', 'xml'))
                ->addActionContext('get', array('html', 'json', 'xml'))
                ->addActionContext('save', array('html', 'json', 'xml'))
                ->addActionContext('addobjetivo', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest())
            $this->_helper->layout()->disableLayout();

        $this->form = new Programacao_Form_Projeto();
        $this->formDescritivo = new Programacao_Form_Descritivo();

        /**
         *  @var Elemento que representa o id do programa nos forms descritivos(objetivos e metas)
         */
        $form_projeto_id = new Zend_Form_Element_Hidden('projeto_id');
        $form_projeto_id->setRequired(true)->addValidator('NotEmpty');
        $this->formDescritivo->addElement($form_projeto_id);
        $this->view->formDescritivo = $this->formDescritivo;
    }

    public function indexAction() {
        // action body
    }

    public function createAction() {
        $programa_id = $this->_getParam('programa_id');
        $projeto_id = $this->_getParam('projeto_id');

        if (!$programa_id && $projeto_id) {
            $model_projetos = new Model_Projetos ( );
            $projeto = $model_projetos->fetchRow('id=' . $projeto_id);
            $programa_id = $projeto->programa_id;
        }

        if ($this->getRequest()->isPost()) {
            $this->saveAction();
            $this->render('save');
        } else {
            if ($programa_id) {
                $this->form->projeto->programa_id->setValue($programa_id);
                $this->form->projeto->projeto_id->setValue($projeto_id);
                $this->form->submit->setLabel('Salvar');
                $this->view->form = $this->form;
                $this->render('edit');
            } else {
                $this->_helper->viewRenderer->setNoRender(true);
                echo "<h1>Esperado informar o código do programa";
            }
        }
    }

    public function updateAction() {
        $this->saveAction();
        $this->render('save');
    }

    public function deleteAction() {
        $form = new Programacao_Form_Delete();
        $model_projetos = new Model_Projetos();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $id = $form->getValue('id');
                $this->view->response = array();
                try {
                    $model_projetos->update(array('situacao_id' => 2), 'id=' . $id);
                    $projeto = $model_projetos->fetchRow('id=' . $id);
                    $this->view->response = array('dados' => $projeto->toArray(),
                        'notice' => 'Projeto apagado com sucesso',
                        'descricao' => $projeto->menu,
                        'keepOpened' => false,
                        'refreshPage' => true
                    );
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Dados inválidos',
                        'errors' => $this->form->getErrors());
                }
                $this->render('save');
            }
        } elseif ((int) $this->_getParam('id', 0) > 0) {
            $this->view->title = "Excluir";
            $this->view->headTitle($this->view->title, 'PREPEND');
            $id = $this->_getParam('id', 0);
            $projeto = $model_projetos->fetchRow('id=' . $id);
            $this->view->projeto = $projeto;
            $form->populate($projeto->toArray());
            $this->view->form = $form;
        }
    }

    public function getAction() {
        // action body
    }

    public function editAction() {
        $id = $this->_getParam('id');
        if ($id > 0) {
            $this->form->submit->setLabel('Salvar');
            $model_projetos = new Model_Projetos();
            $projeto = $model_projetos->fetchRow('situacao_id=1 AND id=' . $id);
            if ($projeto) {
                $this->form->populate($projeto->toArray());
                $this->view->projeto = $projeto;
                $this->view->form = $this->form;
                $this->render('edit');
            } else {
                $this->_helper->viewRenderer->setNoRender(true);
                echo "Programa não encontrado";
            }
        } else {
            $this->_helper->viewRenderer->setNoRender(true);
            echo "<<h2>Esperado informar ID para edição</h2>";
        }
    }

    public function saveAction() {
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                try {
                    $dados = $this->form->getValue('projeto');
                    unset($dados['id']);
                    if ($dados['projeto_id'] == "")
                        unset($dados['projeto_id']);
                    $id = $this->form->projeto->getValue('id');

                    $model_projetos = new Model_Projetos ( );
                    if ($id == '') {
                        $id = $model_projetos->insert($dados);
                        $newid = $id;
                    } else {
                        $model_projetos->update($dados, 'id=' . $id);
                    }
                    $projeto = $model_projetos->fetchRow('id=' . $id);
                    $this->view->projeto = $projeto;
                    $this->view->response = array('dados' => $projeto->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $projeto->menu,
                        'keepOpened' => false,
                        'refreshPermissions'=>true,
                        'refreshPage' => true
                    );
                    if (isset($newid)) {
                        $this->view->response['newid'] = $newid;
                    }
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados',
                        'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos',
                    'errors' => $this->form->processAjax($formData));
            }
        } else {
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Método esperado: POST');
        }
    }

    public function addobjetivoAction() {
        if ($this->getRequest()->isPost()) {
            $this->formDescritivo->descricao->addValidator(new Zend_Validate_StringLength(0, 500));
            $formData = $this->getRequest()->getPost();
            if ($this->formDescritivo->isValid($formData)) {
                $dados = $this->formDescritivo->getDados();
                $dados['projeto_id'] = $this->formDescritivo->getValue('projeto_id');
                $model_objetivosProjetos = new Model_ObjetivosProjeto();
                if ($this->formDescritivo->getValue('id') == '') {
                    $id = $model_objetivosProjetos->insert($dados);
                } else {
                    $id = $this->formDescritivo->getValue('id');
                    $model_objetivosProjetos->update($dados, 'id=' . $id);
                }

                $objetivoProjeto = $model_objetivosProjetos->fetchRow('id=' . $id);
                $returns = array();
                $toolbar = $this->view->lineToolbar('projetos', $objetivoProjeto);
                $returns['toolbar'] = $toolbar;
                $returns['obj'] = $objetivoProjeto->toArray();
                $return = Zend_Json_Encoder::encode($returns);
            } else {
                $this->formDescritivo->populate($formData);
                $return = $this->formDescritivo->processAjax($this->_request->getPost());
            }
        }

        $this->_helper->viewRenderer->setNoRender(true);
        echo $return;
    }

}

