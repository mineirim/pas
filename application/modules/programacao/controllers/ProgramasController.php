<?php

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
                ->initContext();
        if ($this->_request->isXmlHttpRequest())
            $this->_helper->layout()->disableLayout();

        $this->form = new Form_Geral();
        $this->formDescritivo = new Form_Descritivo();

        $this->form->menu->setRequired(true)
                ->addValidator('NotEmpty');

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
     */
    public function updateAction() {
        $this->saveAction();
        $this->render('save');
    }

    public function deleteAction() {

		$form = new Zend_Form();
		$form->addElement('hidden','id');
		$submit = new Zend_Form_Element_Submit('submit');
                $submit->setAttrib('class', 'by-ajax')->setLabel('Confirmar');
                $form->addElement($submit);
                $close = new Zend_Form_Element_Button('dialog_close');
                $close->setAttrib('class', 'dialog-form-close')->setLabel('Cancelar');
		$form->addElement($close);
		$programas = new Model_Programas();

		if ($this->getRequest()->isPost()) {
                    if ($form->isValid($this->getRequest()->getPost())) {
                        $id = $form->getValue('id');
                        $programa = $programas->fetchRow('id='.$id);
                        $programa->situacao_id=2;
                        $programa->save();
                        $this->_helper->viewRenderer->setNoRender(true);
                        $response = array('dados' => $programa,
                            'notice' => 'Programa apagado com sucesso',
                            'descricao' => $programa->menu,
                            'keepOpened' => true,
                            'refreshPage' =>true
                    );
                        echo Zend_Json::encode($programa);
                    }
		}elseif ((int)$this->_getParam('id', 0) > 0) {
                    $this->view->title = "Excluir";
                    $this->view->headTitle($this->view->title, 'PREPEND') ;
                    $id = $this->_getParam('id', 0);
                    $programa = $programas->fetchRow('id='.$id);
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
        $this->view->form = $this->form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                $id = $this->form->getValue('id');
                $dados = $this->form->getDados();
                $programas = new Model_Programas ( );

                if ($this->form->getValue('id') == '') {
                    $id = $programas->insert($dados);
                } else {
                    $id = $this->form->getValue('id');
                    $programas->update($dados, 'id=' . $id);
                }
                $programa = $programas->fetchRow('id=' . $id);
                $this->view->programa = $programa;
                $this->view->response = array('dados' => $programa,
                            'notice' => 'Dados atualizados com sucesso',
                            'descricao' => $programa->menu,
                            'keepOpened' => true,
                            'refreshPage' =>true
                    );
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Dados inválidos',
                                                'errors'=>$this->form->getErrors());
            }
        }else{
             $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Método esperado: POST');
        }
    }

}

