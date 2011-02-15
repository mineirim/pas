<?php

class Programacao_AtividadesController extends Zend_Controller_Action {

    private $form = null;

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
                ->addActionContext('mudapeso', array('html', 'json', 'xml'))
                ->addActionContext('addvinculacao', array('html', 'json', 'xml'))
                ->addActionContext('deletevinculacao', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest())
            $this->_helper->layout()->disableLayout();
    }

    public function indexAction() {
        // action body
    }

    public function createAction() {
        $operacao_id = $this->_getParam('operacao_id');
        $this->form = new Programacao_Form_Atividade();

        if ($this->getRequest()->isPost()) {
            $this->saveAction();
        } else {
            if ($operacao_id) {
                $this->view->title = "Adicionar Atividade";
                $this->view->headTitle($this->view->title, 'PREPEND');
                $this->form->atividade->operacao_id->setValue($operacao_id);
                $this->view->form = $this->form;
                $this->render('edit');
            } else {
                $this->_helper->viewRenderer->setNoRender(true);
                echo "<h1>Esperado informar o código da Operação";
            }
        }
    }

    /**
     * Utilizado para atualizações de data e andamento da atividade
     * 
     * 
     */
    public function updateAction() {
        $model_atividadesHistorico = new Model_AtividadesHistorico();
        $model_atividadesVinculadas = new Model_AtividadesVinculadas();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            $this->form = new Programacao_Form_AtividadeAcompanhamento($this->_request->getPost('atividade_id'));
            if ($this->form->isValid($formData)) {
                try {
                    $dados = $this->form->getValue('historico');
                    $andamento_id = $this->form->getValue('andamento_id');
                    $model_atividadesHistorico = new Model_AtividadesHistorico();
                    $newid = $model_atividadesHistorico->insert($dados);

                    $atividade_historico = $model_atividadesHistorico->fetchRow('id=' . $newid);
                    $this->view->response = array('dados' => $atividade_historico->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $atividade_historico->findParentRow('Model_Andamentos')->descricao,
                        'keepOpened' => true, 'refreshPage' => true);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados',
                        'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $this->view->response = array('notice' => 'Erro ao gravar dados',
                    'errormessage' => 'Formulário com dados inválidos',
                    'errors' => $this->form->getErrors());
            }
            $this->render('save');
        } else {
            $atividade_id = $this->_getParam('atividade_id');
            $atividadeHistorico = $model_atividadesHistorico->fetchCurrentRow($atividade_id);
            if ($atividadeHistorico) {
                $form = new Programacao_Form_AtividadeAcompanhamento($atividade_id);
                $form->populate($atividadeHistorico->toArray());
                $this->view->form = $form;
            } else {
                $this->view->errorMessage = "Atividade não encontrada";
                $this->render('erro');
            }
        }
    }

    public function deleteAction() {
        $form = new Programacao_Form_Delete ();
        $model_atividades = new Model_Atividades();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $id = $form->getValue('id');
                $this->view->response = array();
                try {
                    $model_atividades->update(array('situacao_id' => 2), 'id=' . $id);
                    $atividade = $model_atividades->fetchRow('id=' . $id);
                    $this->view->response = array('dados' => $atividade->toArray(),
                        'notice' => 'Atividade apagada com sucesso',
                        'descricao' => $atividade->descricao,
                        'keepOpened' => false,
                        'refreshPage' => true);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados',
                        'errormessage' => 'Dados inválidos',
                        'errors' => $this->form->getErrors());
                }
                $this->render('save');
            }
        } elseif ((int) $this->_getParam('id', 0) > 0) {
            $this->view->title = "Excluir";
            $this->view->headTitle($this->view->title, 'PREPEND');
            $id = $this->_getParam('id', 0);
            $atividade = $model_atividades->fetchRow('id=' . $id);
            $this->view->atividade = $atividade;
            $form->populate($atividade->toArray());
            $this->view->form = $form;
        }
    }

    public function getAction() {
        // action body
    }

    public function editAction() {
        $id = $this->_getParam('id', 0);

        if ($id > 0) {
            $model_atividades = new Model_Atividades();
            $model_historico = new Model_AtividadesHistorico();
            $atividade = $model_atividades->fetchRow('id=' . $id);

            if ($atividade) {
                $historico = $model_historico->fetchRow('situacao_id=1 and atividade_id=' . $atividade->id);
                $dados_historico = $historico->toArray();
                unset($dados_historico['id']);
                $this->view->title = "Alterar Atividade";
                $this->view->headTitle($this->view->title, 'PREPEND');
                $this->form = new Programacao_Form_Atividade();
                $this->form->populate(array_merge($atividade->toArray(), $dados_historico));
                $this->form->historico->data_inicio
                        ->setAttrib('readonly', 'true')->setAttrib('class', '')
                        ->setDescription('Alterações de data de início só poderão ser feitas na tela de detalhes da atividade');
                $this->form->historico->data_prazo
                        ->setAttrib('readonly', 'true')->setAttrib('class', '')
                        ->setDescription('Alterações de prazos só poderão ser feitas na tela de detalhes da atividade');
                $this->view->atividade = $atividade;
                $this->view->form = $this->form;
                $this->render('edit');
            } else {
                $this->_helper->viewRenderer->setNoRender(true);
                echo "Operação não encontrada";
            }
        } else {
            $this->_helper->viewRenderer->setNoRender(true);
            echo "<<h2>Esperado informar ID para edição</h2>";
        }
    }

    public function saveAction() {
        $this->form = new Programacao_Form_Atividade();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                try {
                    $dados = $this->form->getValue('atividade');
                    $dados_historico = $this->form->getValue('historico');

                    $id = $this->form->getValue('id');
                    $model_atividades = new Model_Atividades();
                    $model_atividadesHistorico = new Model_AtividadesHistorico();
                    if ($id == '') {
                        $id = $model_atividades->insert($dados);
                        $newid = $id;
                    } else {
                        $model_atividades->update($dados, 'id=' . $id);
                    }
                    $dados_historico['atividade_id'] = $id;
                    $where = array('situacao_id=?' => 1, 'atividade_id=?' => $id, 'responsavel_id=?' => $dados_historico['responsavel_id']);
                    $historico = $model_atividadesHistorico->fetchRow($where);
                    if (!$historico) {
                        $where = array('situacao_id=?' => 1, 'atividade_id=?' => $id);
                        $historico = $model_atividadesHistorico->fetchRow($where);
                        $tmp = array();
                        if ($historico)
                            $tmp = $historico->toArray();
                        unset($tmp['id']);
                        $model_atividadesHistorico->insert(array_merge($tmp, $dados_historico));
                    }
                    $atividade = $model_atividades->fetchRow('id=' . $id);
                    $this->view->atividade = $atividade;
                    $this->view->response = array('dados' => $atividade->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $atividade->descricao,
                        'keepOpened' => false,
                        'refreshPermissions'=>true,
                        'refreshPage' => true);
                    if (isset($newid)) {
                        $this->view->response ['newid'] = $newid;
                    }
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados',
                        'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $this->view->response = array('notice' => 'Erro ao gravar dados',
                    'errormessage' => 'Formulário com dados inválidos',
                    'errors' => $this->form->getErrors());
            }
        } else {
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Método esperado: POST');
        }
    }

    /**
     * usada para gravar peso diretamente da tela de operacao
     * 
     * 
     */
    public function mudapesoAction() {
        $model_atividades = new Model_Atividades ();
        if ($this->getRequest()->isPost()) {
            try {
                $dados = array('peso' => $this->_getParam('peso'));
                $id = $this->_getParam('id');

                $model_atividades->update($dados, 'id = ' . $id);

                $atividade = $model_atividades->fetchRow('id = ' . $id);

                $this->view->response = array('dados' => $atividade->toArray(),
                    'notice' => 'Dados atualizados com sucesso',
                    'descricao' => $atividade->descricao,
                    'keepOpened' => true,
                    'refreshPage' => true);
                if (isset($newid)) {
                    $this->view->response ['newid'] = $newid;
                }
            } catch (Exception $e) {
                $this->getResponse()->setHttpResponseCode(501);
                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
            }
        } else {
            $this->getResponse()->setHttpResponseCode(501);
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos', 'errors' => $this->form->getErrors());
        }
    }

    public function addvinculacaoAction() {
        $this->form = new Programacao_Form_AtividadesVinculadas();
        $atividade_id = $this->_getParam('atividade_id', 0);
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                try {
                    $auth = Zend_Auth::getInstance ();
                    $depende_atividade_id = $this->_getParam('depende_atividade_id');
                    /**
                     * vefica se já existe o vinculo
                     */
                    $modelAtividadesVinculadas = new Model_AtividadesVinculadas();
                    $where = array('atividade_id=?' => $atividade_id,
                        'depende_atividade_id=?' => $depende_atividade_id,
                        'situacao_id=?' => 1);
                    $atividadesVinculadas = $modelAtividadesVinculadas->fetchAll($where);
                    if ($atividadesVinculadas->valid()) {
                        $this->view->response = array(
                            'alert' => 'Vínculo já existe!',
                            'keepOpened' => true,
                            'refreshPage' => false);
                        return false;
                    }



                    /**
                     * buscar o responsável pela atividade 
                     * 
                     */
                    $modelAtividadesHistorico = new Model_AtividadesHistorico();
                    $atividadesHistorico = $modelAtividadesHistorico->fetchCurrentRow($atividade_id);
                    $responsavel_id = $atividadesHistorico->responsavel_id;

                    /**
                     *
                     * se o responsável está vinculando atividades dele o pacto é automático
                     * @var unknown_type
                     */
                    $is_pactuado = ($auth->getIdentity()->id === $responsavel_id) ? 1 : 0;

                    $dados = array('atividade_id' => $atividade_id,
                        'depende_atividade_id' => $depende_atividade_id,
                        'justificativa' => $this->_getParam('justificativa'),
                        'is_pactuado' => $is_pactuado,
                        'situacao_id' => 1
                    );
                    $modelAtividadesVinculadas = new Model_AtividadesVinculadas();

                    try {
                        $modelAtividadesVinculadas->insert($dados);
                        $this->view->response = array(
                            'notice' => 'Dados atualizados com sucesso',
                            'keepOpened' => false,
                            'refreshPage' => true);
                    } catch (Zend_Db_Exception $e) {
                        $this->view->response = array('notice' => $e->getMessage(),
                            'keepOpened' => true,
                            'refreshPage' => false);
                    }
                } catch (Exception $e) {
                    $this->form->populate($formData);
                }
            }
        } else {
            if ($atividade_id) {
                $this->form->getElement('atividade_id')->setValue($atividade_id);
                $this->view->form = $this->form;
            } else {
                $this->_helper->viewRenderer->setNoRender(true);
                echo "<h1>Esperado informar o código da atividade</h1>";
            }
        }
    }

    public function deletevinculacaoAction() {
        $form = new Programacao_Form_Delete ();
        $modelAtividadesVinculadas = new Model_AtividadesVinculadas();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $id = $form->getValue('id');
                try {
                    $modelAtividadesVinculadas->update(array('situacao_id' => 2), 'id=' . $id);
                    $atividadesVinculadas = $modelAtividadesVinculadas->fetchRow('id=' . $id);
                    $this->view->response = array(
                        'notice' => 'Vínculo excluído com sucesso',
                        'keepOpened' => false,
                        'refreshPage' => true);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados',
                        'errormessage' => 'Dados inválidos',
                        'errors' => $this->form->getErrors());
                }
            }
        } elseif ((int) $this->_getParam('id', 0) > 0) {
            $this->view->title = "Excluir";
            $this->view->headTitle($this->view->title, 'PREPEND');
            $id = $this->_getParam('id', 0);
            $atividadesVinculadas = $modelAtividadesVinculadas->fetchRow('id=' . $id);

            $modelAtividades = new Model_Atividades;

            $this->view->atividadePai = $modelAtividades->fetchRow('id = ' . $atividadesVinculadas->depende_atividade_id);
            $this->view->atividadeFilho = $modelAtividades->fetchRow('id = ' . $atividadesVinculadas->atividade_id);

            $this->view->atividadesVinculadas = $atividadesVinculadas;
            $form->populate($atividadesVinculadas->toArray());
            $this->view->form = $form;
        }
    }
    
    
}

