<?php

class Programacao_AtividadesController extends Zend_Controller_Action {

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
	 */
    public function updateAction() {
        
        $model_atividadesHistorico = new Model_AtividadesHistorico();
        $model_atividadesVinculadas= new Model_AtividadesVinculadas();
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
        }else{
        	$atividade_id = $this->_getParam('atividade_id');
                $atividadeHistorico = $model_atividadesHistorico->fetchCurrentRow($atividade_id);
                if($atividadeHistorico){
                    $form = new Programacao_Form_AtividadeAcompanhamento($atividade_id);
                    $form->populate($atividadeHistorico->toArray());
                    $this->view->form = $form;
                }  else {
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
       	$id = $this->_getParam ('id',0);
	   	
        if ($id > 0) {
            $model_atividades = new Model_Atividades();
            $model_historico = new Model_AtividadesHistorico();
            $atividade = $model_atividades->fetchRow('id='.$id);

            if($atividade)
            {
                $historico = $model_historico->fetchRow('situacao_id=1 and atividade_id='.$atividade->id);
                $dados_historico =$historico->toArray();
                unset($dados_historico['id']);
                $this->view->title = "Alterar Atividade";
                $this->view->headTitle($this->view->title, 'PREPEND');
                $this->form = new Programacao_Form_Atividade();
                $this->form->populate(array_merge($atividade->toArray(),$dados_historico ));
                $this->form->historico->data_inicio
                        ->setAttrib('readonly','true')->setAttrib('class','')
                        ->setDescription('Alterações de data de início só poderão ser feitas na tela de detalhes da atividade');
                $this->form->historico->data_prazo
                        ->setAttrib('readonly','true')->setAttrib('class','')
                        ->setDescription('Alterações de prazos só poderão ser feitas na tela de detalhes da atividade');
                $this->view->atividade = $atividade;
                $this->view->form = $this->form;
                $this->render('edit');
            } else {
                $this->_helper->viewRenderer->setNoRender ( true );
                echo "Operação não encontrada";
            }
        } else {
            $this->_helper->viewRenderer->setNoRender ( true );
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
                    $dados_historico['atividade_id']=$id;
                    $where = array('situacao_id=?'=>1, 'atividade_id=?'=>$id, 'responsavel_id=?'=>$dados_historico['responsavel_id']);
                    $historico = $model_atividadesHistorico->fetchRow($where);
                    if(!$historico){
                        $where = array('situacao_id=?'=>1, 'atividade_id=?'=>$id);
                        $historico = $model_atividadesHistorico->fetchRow($where);
                        $tmp = array();
                        if($historico)
                            $tmp = $historico->toArray();
                        unset($tmp['id']);
                        $model_atividadesHistorico->insert(array_merge($tmp,$dados_historico));
                    }
                    $atividade = $model_atividades->fetchRow('id=' . $id);
                    $this->view->atividade = $atividade;
                    $this->view->response = array('dados' => $atividade->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $atividade->descricao,
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
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Método esperado: POST');
        }
    }

    
    /**
     * 
     * usada para gravar peso diretamente da tela de operacao
     */
    
    public function mudapesoAction() {
		
		$model_atividades = new Model_Atividades ();
		if ($this->getRequest ()->isPost ()) {
			try {
				$dados = array ('peso' => $this->_getParam ( 'peso' ) );
				$id = $this->_getParam ( 'id' );

				$model_atividades->update ( $dados, 'id = ' . $id );
				
				$atividade = $model_atividades->fetchRow ( 'id = ' . $id );
				
				$this->view->response = array ('dados' => $atividade->toArray (), 
											   'notice' => 'Dados atualizados com sucesso', 
											   'descricao' => $atividade->descricao, 
											   'keepOpened' => true, 
											   'refreshPage' => true );
			} catch ( Exception $e ) {
				$this->getResponse ()->setHttpResponseCode ( 501 );
				$this->view->response = array ('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage () );
			}
		} else {
			$this->getResponse ()->setHttpResponseCode ( 501 );
			$this->view->response = array ('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos', 'errors' => $this->form->getErrors () );
		}
	
	}
    
    
}

