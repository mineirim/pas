<?php

class Programacao_MetasController extends Zend_Controller_Action {

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
                ->addActionContext('settrimestral', array('html', 'json'))
                ->addActionContext('preencherelatorio', array('html', 'json'))
                ->addActionContext('procurartrimestre', array('json'))
                ->addActionContext('addindicador', array('json', 'html'))
                ->addActionContext('addparceria', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest())
            $this->_helper->layout()->disableLayout();
    }

    public function indexAction() {
        // action body
    }

    public function createAction() {
        $this->form = new Programacao_Form_Metas();
        $objetivo_especifico_id = $this->_getParam('objetivo_especifico_id');
        if ($this->getRequest()->isPost()) {
            $this->saveAction();
        } else {
            if ($objetivo_especifico_id) {
                $this->form->meta->getElement('objetivo_especifico_id')->setValue($objetivo_especifico_id);
                $this->view->form = $this->form;
                $this->render('edit');
            } else {
                $this->_helper->viewRenderer->setNoRender(true);
                echo "<h1>Esperado informar o código do projeto";
            }
        }
    }

    public function updateAction() {
        // action body
    }

    public function deleteAction() {

        $form = new Programacao_Form_Delete ();
        $model_metas = new Model_Metas ();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $id = $form->getValue('id');
                $this->view->response = array();
                try {
                    $model_metas->update(array('situacao_id' => 2), 'id=' . $id);
                    $meta = $model_metas->fetchRow('id=' . $id);
                    $this->view->response = array('dados' => $meta->toArray(),
                        'notice' => 'Meta apagado com sucesso',
                        'descricao' => $meta->descricao,
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
            $meta = $model_metas->fetchRow('id=' . $id);
            $this->view->meta = $meta;
            $form->populate($meta->toArray());
            $this->view->form = $form;
        }
    }

    public function editAction() {
        $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $metas = new Model_Metas();
            $meta = $metas->fetchRow('id=' . $id);

            if ($meta) {
                $this->form = new Programacao_Form_Metas();
                $this->form->populate($meta->toArray());
                $this->view->meta = $meta;
                $this->view->form = $this->form;
                $this->render('edit');
            } else {
                $this->_helper->viewRenderer->setNoRender(true);
                echo "Meta não encontrada";
            }
        } else {
            $this->_helper->viewRenderer->setNoRender(true);
            echo "<<h2>Esperado informar ID para edição</h2>";
        }
    }

    public function saveAction() {
        $this->form = new Programacao_Form_Metas();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                try {
                    $dados = $this->form->getValue('meta');
                    unset($dados ['id']);
                    $id = $this->form->meta->getValue('id');
                    $metas = new Model_Metas ( );

                    if ($id == '') {
                        $id = $metas->insert($dados);
                        $newid = $id;
                    } else {
                        $metas->update($dados, 'id=' . $id);
                    }
                    $meta = $metas->fetchRow('id=' . $id);
                    $this->view->meta = $meta;
                    $this->view->response = array('dados' => $meta->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $meta->descricao,
                        'keepOpened' => false, 'refreshPage' => true);
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

    public function addindicadorAction() {
        $form = new Zend_Form();
        $form_meta_id = new Zend_Form_Element_Hidden('meta_id');
        $form_meta_id->setRequired(true)->addValidator('NotEmpty');
        $form->addElement($form_meta_id);

        $model_metas = new Model_Metas();
        $meta_id = $this->_getParam('meta_id');
        $meta = $model_metas->fetchRow("id=$meta_id");

        $projeto = $meta->findParentModel_ObjetivosEspecificos()->findParentModel_Projetos();
        $indicadores_projeto = $projeto->findModel_IndicadoresProjeto();


        $indicador_ids = new Zend_Form_Element_MultiCheckbox('indicador_ids');
        $indicadores = array();
        foreach ($indicadores_projeto as $ip) {
            $indicador_ids->addMultiOption($ip->indicador_id, $ip->findParentModel_Indicadores()->descricao);
            $indicadores[] = $ip;
        }

        $programa = $projeto->findParentModel_Programas();
        $indicadores_programa = $programa->findModel_IndicadoresPrograma();
        foreach ($indicadores_programa as $ip) {
            $indicador_ids->addMultiOption($ip->indicador_id, $ip->findParentModel_Indicadores()->descricao);
            $indicadores[] = $ip;
        }


        $form->addElement($indicador_ids);
        $this->view->form = $form;
        $model_indicador_metas = new Model_IndicadoresMeta();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $meta_id = $form->getValue('meta_id');
                $indicador_ids = $form->getValue('indicador_ids');

                $meta = $model_metas->find($meta_id)->current();
                $objetivo_especifico_id = $meta->objetivo_especifico_id;
                $projeto_id = $meta->findParentRow('Model_ObjetivosEspecificos')->projeto_id;
                $programa_id = $meta->findParentRow('Model_ObjetivosEspecificos')->findParentRow('Model_Projetos')->programa_id;

                foreach ($indicadores as $indicador) {
                    $where = "meta_id=$meta_id and indicador_id = " . $indicador->indicador_id;
                    if (!in_array($indicador->indicador_id, $indicador_ids)) {
                        $model_indicador_metas->delete($where);
                    } else {
                        $indicador_meta = $model_indicador_metas->fetchRow($where);
                        if (!$indicador_meta) {
                            $data = array('meta_id' => $meta_id,
                                'indicador_id' => $indicador->indicador_id
                            );
                            $model_indicador_metas->insert($data);
                        }
                    }
                }

                if (!$this->_request->isXmlHttpRequest()) {
                    $this->_helper->redirector->gotoSimple('metas', 'plano', false,
                            array('meta_id' => $meta_id));
                } else {
                    $retorno = array('retorno' => 'sucesso', 'status' => "Salvo com sucesso", 'msg' => 'Salvo com sucesso!!');
                    $this->_helper->json($retorno);
                    return;
                }
            } else {
                $form->populate($formData);
                if ($this->_request->isXmlHttpRequest()) {
                    $this->_helper->json(array('retorno' => 'falha', 'status' => 'Erro ao validar formulário'));
                }
            }
        } else {
            $meta_id = $this->_getParam('meta_id');
            $indicadores_meta = $model_indicador_metas->fetchAll('meta_id=' . $meta_id, 'indicador_id');
            $indicador_ids = array();
            foreach ($indicadores_meta as $indicador_meta)
                $indicador_ids[] = $indicador_meta->indicador_id;
            $form->indicador_ids->setValue($indicador_ids);
            $form->meta_id->setValue($this->_getParam('meta_id'));

            if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
            }
        }
    }

    public function settrimestralAction() {

        /**
         * pega os trimestres
         */
        $locale = Zend_Registry::get("locale");
        $trimestres = $locale->getTranslationList('quarter');


        $model_metas_trimestres = new Model_MetasTrimestres();
        $model_metas = new Model_Metas();
        $form = new Zend_Form('trimestral');
        $meta_id = new Zend_Form_Element_Hidden('meta_id');
        $trimestres_ids = new Zend_Form_Element_MultiCheckbox('trimestres_ids');

        $trimestres_ids->addMultiOptions($trimestres);
        $trimestres_ids->setLabel('Selecione o(s) trimestre(s)');

        $form->addElements(array($meta_id, $trimestres_ids));

        if ($this->getRequest()->isPost()) {

            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $meta_id = $form->getValue('meta_id');
                $trimestres_ids = $form->getValue('trimestres_ids');

                $meta = $model_metas->find($meta_id)->current();
                $objetivo_especifico_id = $meta->objetivo_especifico_id;
                $projeto_id = $meta->findParentRow('Model_ObjetivosEspecificos')->projeto_id;
                $programa_id = $meta->findParentRow('Model_ObjetivosEspecificos')->findParentRow('Model_Projetos')->programa_id;

                foreach ($trimestres as $trimestre => $descritivo) {
                    $where = "meta_id=$meta_id and trimestre = $trimestre";
                    if (!in_array($trimestre, $this->_getParam('trimestres_ids'))) {
                        $meta_trimestre = $model_metas_trimestres->fetchRow($where);
                        if ($meta_trimestre) {
                            $meta_trimestre->situacao_id = 2;
                            $meta_trimestre->save();
                        }
                    } else {

                        $meta_trimestre = $model_metas_trimestres->fetchRow($where);
                        if (!$meta_trimestre) {
                            $data = array('meta_id' => $meta_id,
                                'trimestre' => $trimestre,
                                'programa_id' => $programa_id,
                                'projeto_id' => $projeto_id,
                                'objetivo_especifico_id' => $objetivo_especifico_id
                            );

                            $model_metas_trimestres->insert($data);
                        } else {
                            $meta_trimestre->situacao_id = 1;
                            $meta_trimestre->save();
                        }
                    }
                }

                if (!$this->_request->isXmlHttpRequest()) {
                    $this->_helper->redirector->gotoSimple('objetivos-especificos', 'plano', false,
                            array('objetivo_especifico_id' => $objetivo_especifico_id));
                } else {

                    $retorno = array('retorno' => 'sucesso', 'msg' => 'Salvo com sucesso!!');
                    $this->_helper->json($retorno);
                    return;
                }
            } else {
                $form->populate($formData);
                if ($this->_request->isXmlHttpRequest()) {
                    $form->populate($formData);
                    $this->_helper->json(array('retorno' => 'falha', 'erro' => 'Erro ao validar formulário'));
                }
            }
        } else {
            $meta_id = $this->_getParam('meta_id');
            $metas_trimestres = $model_metas_trimestres->fetchAll('situacao_id=1 and meta_id=' . $meta_id, 'trimestre');
            $trimestres = array();
            foreach ($metas_trimestres as $trimestre)
                $trimestres[] = $trimestre->trimestre;
            $form->trimestres_ids->setValue($trimestres);
            $form->meta_id->setValue($this->_getParam('meta_id'));
        }

        $this->view->form = $form;
    }

    public function gettrimestreAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $model_metas_trimestres = new Model_MetasTrimestres();
        $meta_trimestre = $model_metas_trimestres->fetchRow("meta_id=" . $this->_getParam('meta_id') . " and trimestre=" . $this->_getParam('trimestre'));

        $this->_helper->json($meta_trimestre->toArray());
    }

    public function salvartrimestreAction() {
        $model_metas_trimestres = new Model_MetasTrimestres();
        if ($this->getRequest()->isPost()) {
            $form = $this->makeForm(array(1, 2, 3, 4));
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                unset($formData['submit']);
                unset($formData['id']);

                if ($id) {
                    $model_metas_trimestres->update($formData, "id=$id");
                    $meta_trimestre = $model_metas_trimestres->find($id)->current();
                    $retorno = array('status' => 'sucesso', 'objeto' => $meta_trimestre->toArray());
                    $this->_helper->json($retorno);
                } else {
                    $this->getResponse()
                            ->setHttpResponseCode(404)
                            ->appendBody("Não encontrado");
                }
                //$meta_trimestre = $model_metas_trimestres->fin
            }
        }
    }

    public function preencherelatorioAction() {
        $model_metas_trimestres = new Model_MetasTrimestres();
        $model_metas = new Model_Metas();
        $dataatual = new Zend_Date();
        $trimestre_atual = (int) floor($dataatual->get('M') / 3.1) + 1;

        if ($this->_getParam('id')) {
            $meta_trimestre = $model_metas_trimestres->find($this->_getParam('id'))->current();
            $meta_id = $meta_trimestre->meta_id;
        } elseif ($this->_getParam('meta_id')) {
            $meta_id = $this->_getParam('meta_id');
            $meta_trimestre = $model_metas_trimestres->fetchRow("situacao_id=1 and trimestre= $trimestre_atual and meta_id=$meta_id", 'trimestre');
            if (!$meta_trimestre) {

                $meta_trimestre = $model_metas_trimestres->fetchAll("situacao_id=1 and meta_id=$meta_id", 'trimestre')->current();
            }
        }
        $metas_trimestres = $model_metas_trimestres->fetchAll('situacao_id=1 and meta_id=' . $meta_id, 'trimestre');
        foreach ($metas_trimestres as $t) {
            $trimestres[] = $t->trimestre;
        }
        $form = $this->makeForm($trimestres);
        if ($meta_trimestre) {

            $form->populate($meta_trimestre->toArray());
        }
        $this->view->form = $form;
    }

    public function getAction() {

    }

    private function makeForm($t) {
        $form = new Zend_Form('trimestral');
        $id = new Zend_Form_Element_Hidden('id');
        $meta_id = new Zend_Form_Element_Hidden('meta_id');

        $locale = Zend_Registry::get("locale");
        $lst = $locale->getTranslationList('quarter');
        $trimestres = array();
        foreach ($t as $trim) {
            $trimestres[$trim] = $lst[$trim];
        }


        $trimestre = new Zend_Form_Element_Select('trimestre');

        $trimestre->addMultiOptions($trimestres);
        $trimestre->setLabel('Selecione o trimestre');

        $percentual = new Zend_Form_Element_Text('percentual');
        $percentual->setAttrib('size', 2)
                ->setAttrib('maxlength', 3)
                ->setAttrib('readonly', 'true')
                ->setLabel('% execução da meta')
                ->setValue(0);

        $avaliacao_descritiva = new Zend_Form_Element_Textarea('avaliacao_descritiva');
        $avaliacao_descritiva->setLabel('Avaliação descritiva:')
                ->setAttrib('rows', 7)
                ->setAttrib('cols', 60);

        $form->addElements(array($id, $meta_id, $trimestre, $percentual, $avaliacao_descritiva));
        return $form;
    }

}