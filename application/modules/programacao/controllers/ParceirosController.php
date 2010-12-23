<?php

class Programacao_ParceirosController extends Zend_Controller_Action {

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
                ->addActionContext('get2grid', array('html', 'json', 'xml'))
                ->addActionContext('autocomplete', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function indexAction() {
        // action body
    }

    public function createAction() {

        $this->form = new Programacao_Form_Parceiro();

        if ($this->getRequest()->isPost()) {
            $this->saveAction();
        } else {
            $this->view->title = "Adicionar Parceiro";
            $this->view->headTitle($this->view->title, 'PREPEND');
            $this->view->form = $this->form;
            $this->render('edit');
        }
    }

    public function updateAction() {
        // action body
    }

    public function deleteAction() {
        // action body
    }

    public function getAction() {
        // action body
    }

    public function editAction() {
        // action body
    }

    public function saveAction() {
        $this->form = new Programacao_Form_Parceiro();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                try {
                    $dados = $this->form->getValue('parceiro');
                    $id = $this->form->getValue('id');
                    $model_parceiros = new Model_Parceiros();
                    if ($id == '') {
                        $id = $model_parceiros->insert($dados);
                        $newid = $id;
                    } else {
                        $model_parceiros->update($dados, 'id=' . $id);
                    }
                    $parceiro = $model_parceiros->fetchRow('id=' . $id);
                    $this->view->parceiro = $parceiro;
                    $this->view->response = array('dados' => $parceiro->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $parceiro->nome,
                        'keepOpened' => true, 'refreshPage' => true);
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
            $this->view->response = array ('notice' => 'Erro ao gravar dados', 'errormessage' => 'Método esperado: POST' );
        }
    }


public function autocompleteAction()
{
		$term = $this->_getParam ( 'term' );
		$model_parceiros = new Model_Parceiros ();
		$parceiros = $model_parceiros->fetchAll ( "nome ILIKE '%$term%' OR sigla ILIKE '%$term%'" );
		$arr = array ();
		foreach ( $parceiros as $parceiro ) {
			$arr [] = array ('id' => $parceiro->id, 
								'label' => $parceiro->nome . ' - ' . $parceiro->sigla, 
								'value' => $parceiro->nome . ' - ' . $parceiro->sigla );
		}
		if (count ( $arr ) == 0) {
			$arr [] = array ('id' => 'new', 
								'label' => 'adicionar novo com o termo "' . $term . '"', 
								'value' => 'add' );
		}
		$this->view->dados = $arr;
	}

}

