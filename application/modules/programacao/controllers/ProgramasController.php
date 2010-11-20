<?php

/**
 * @author Marcone Costa
 * 
 */
class Programacao_ProgramasController extends Zend_Controller_Action {

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

        $this->form = new Programacao_Form_Programa();
        $this->formDescritivo = new Programacao_Form_Descritivo();

        /**
         *  @var Elemento que representa o id do programa nos forms descritivos(objetivos e metas)
         */
        $form_programa_id = new Zend_Form_Element_Hidden('programa_id');
        $form_programa_id->setRequired(true)->addValidator('NotEmpty');
        $this->formDescritivo->addElement($form_programa_id);
        $this->view->formDescritivo = $this->formDescritivo;
    }

    public function indexAction() {
        // action body
    }

    public function createAction() {
        if ($this->getRequest()->isPost()) {
            $this->saveAction();
            $this->render('save');
        } else {
            $this->form->submit->setLabel('Adicionar');
            $this->view->form = $this->form;
            $this->render('edit');
        }
    }

    /**
     * Mantido por questões de padronização
     * substituido pelo método save
     * 
     */
    public function updateAction() {
        $this->saveAction();
        $this->render('save');
    }

    public function deleteAction() {
        $form = new Programacao_Form_Delete();
        $programas = new Model_Programas();
        if ($this->getRequest()->isPost()) {
            $this->_helper->viewRenderer->setNoRender(true);
            if ($form->isValid($this->getRequest()->getPost())) {
                $id = $form->getValue('id');
                $this->view->response = array();
                try {
                    $programas->update(array('situacao_id' => 2), 'id=' . $id);
                    $programa = $programas->fetchRow('id=' . $id);
                    $this->view->response = array('dados' => $programa->toArray(),
                        'notice' => 'Programa apagado com sucesso',
                        'descricao' => $programa->menu,
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
            $programa = $programas->fetchRow('id=' . $id);
            $this->view->programa = $programa;
            $form->populate($programa->toArray());
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
            $model_programas = new Model_Programas();
            $programa = $model_programas->fetchRow('situacao_id=1 AND id=' . $id);
            if ($programa) {
                $this->form->populate($programa->toArray());
                $this->view->programa = $programa;
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
                    $dados = $this->form->getValue('programa');
                    unset($dados['id']);
                    $id = $this->form->programa->getValue('id');
                    $model_programas = new Model_Programas ( );
                    if ($id == '') {
                        $id = $model_programas->insert($dados);
                        $newid = $id;
                    } else {
                        $model_programas->update($dados, 'id=' . $id);
                    }
                    $programa = $model_programas->fetchRow('id=' . $id);
                    $this->view->programa = $programa;
                    $this->view->response = array('dados' => $programa->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $programa->menu,
                        'keepOpened' => true,
                        'refreshPage' => true
                    );
                    if(isset($newid)){
                    	$this->view->response['newid']=$newid; 
                    }
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados', 
                    								'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos',
                    'errors' => $this->form->processAjax($formData) );
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
                $dados['programa_id'] = $this->formDescritivo->getValue('programa_id');
                $model_objetivosPrograma = new Model_ObjetivosPrograma();
                if ($this->formDescritivo->getValue('id') == '') {
                    $id = $model_objetivosPrograma->insert($dados);
                } else {
                    $id = $this->formDescritivo->getValue('id');
                    $model_objetivosPrograma->update($dados, 'id=' . $id);
                }

                $objetivoPrograma = $model_objetivosPrograma->fetchRow('id=' . $id);
                $returns = array();
                $toolbar = $this->view->lineToolbar('programas', $objetivoPrograma);
                $returns['toolbar'] = $toolbar;
                $returns['obj'] = $objetivoPrograma->toArray();
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