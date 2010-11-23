<?php

class Programacao_ObjetivosEspecificosController extends Zend_Controller_Action {
	
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
		$ajaxContext->addContext ( 'js', array ('suffix' => 'js' ) );
		$ajaxContext->setAutoJsonSerialization ( false );
		$ajaxContext->addActionContext ( 'index', array ('json', 'xml', 'js' ) )->addActionContext ( 'create', array ('html', 'json', 'xml' ) )->addActionContext ( 'update', array ('html', 'json', 'xml' ) )->addActionContext ( 'delete', array ('html', 'json', 'xml' ) )->addActionContext ( 'get', array ('html', 'json', 'xml' ) )->addActionContext ( 'save', array ('html', 'json', 'xml' ) )->addActionContext ( 'addparceria', array ('html', 'json', 'xml' ) )->initContext ();
		if ($this->_request->isXmlHttpRequest ())
			$this->_helper->layout ()->disableLayout ();
		
		$this->form = new Programacao_Form_ObjetivoEspecifico ();
		
		$this->formDescritivo = new Programacao_Form_Descritivo ();
		
		$form_objetivoespecifico_id = new Zend_Form_Element_Hidden ( 'objetivo_especifico_id' );
		$form_objetivoespecifico_id->setRequired ( true )->addValidator ( 'NotEmpty' );
		$this->formDescritivo->addElement ( $form_objetivoespecifico_id );
		$this->view->formDescritivo = $this->formDescritivo;
	}
	
	public function indexAction() {
		// action body
	}
	
	public function createAction() {
		$projeto_id = $this->_getParam ( 'projeto_id' );
		
		$this->form = new Programacao_Form_ObjetivoEspecifico ();
		if ($this->getRequest ()->isPost ()) {
			$this->saveAction ();
			$this->render ( 'save' );
		} else {
			if ($projeto_id) {
				$this->form->objetivoespecifico->getElement ( 'projeto_id' )->setValue ( $projeto_id );
				$this->view->form = $this->form;
				$this->render ( 'edit' );
			} else {
				$this->_helper->viewRenderer->setNoRender ( true );
				echo "<h1>Esperado informar o código do projeto";
			}
		}
	}
	
	public function updateAction() {
		$this->_forward ( 'save' );
	}
	
	public function deleteAction() {
		$form = new Programacao_Form_Delete ();
		$model_objetivos = new Model_ObjetivosEspecificos ();
		if ($this->getRequest ()->isPost ()) {
			if ($form->isValid ( $this->getRequest ()->getPost () )) {
				$id = $form->getValue ( 'id' );
				$this->view->response = array ();
				try {
					$model_objetivos->update ( array ('situacao_id' => 2 ), 'id=' . $id );
					$objetivo = $model_objetivos->fetchRow ( 'id=' . $id );
					$this->view->response = array ('dados' => $objetivo->toArray (), 'notice' => 'Projeto apagado com sucesso', 'descricao' => $objetivo->descricao, 'keepOpened' => false, 'refreshPage' => true );
				} catch ( Exception $e ) {
					$this->getResponse ()->setHttpResponseCode ( 501 );
					$this->view->response = array ('notice' => 'Erro ao gravar dados', 'errormessage' => 'Dados inválidos', 'errors' => $this->form->getErrors () );
				}
				$this->render ( 'save' );
			}
		} elseif (( int ) $this->_getParam ( 'id', 0 ) > 0) {
			$this->view->title = "Excluir";
			$this->view->headTitle ( $this->view->title, 'PREPEND' );
			$id = $this->_getParam ( 'id', 0 );
			$objetivo = $model_objetivos->fetchRow ( 'id=' . $id );
			$this->view->objetivo = $objetivo;
			$form->populate ( $objetivo->toArray () );
			$this->view->form = $form;
		}
	}
	
	public function getAction() {
		// action body
	}
	
	public function editAction() {
		$id = $this->_getParam ( 'id' );
		if ($id > 0) {
			$model_objetivosEspecificos = new Model_ObjetivosEspecificos ();
			$objetivo_especifico = $model_objetivosEspecificos->fetchRow ( 'id=' . $id );
			if ($objetivo_especifico) {
				$this->form->populate ( $objetivo_especifico->toArray () );
				$this->view->objetivo_especifico = $objetivo_especifico;
				$this->view->form = $this->form;
				$this->render ( 'edit' );
			} else {
				$this->_helper->viewRenderer->setNoRender ( true );
				echo "Objetivo específico não encontrado";
			}
		} else {
			$this->_helper->viewRenderer->setNoRender ( true );
			echo "<<h2>Esperado informar ID para edição</h2>";
		}
	}
	
	public function saveAction() {
		if ($this->getRequest ()->isPost ()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) {
				try {
					$dados = $this->form->getValue ( 'objetivoespecifico' );
					unset ( $dados ['id'] );
					$id = $this->form->objetivoespecifico->getValue ( 'id' );
					
					$model_objetivosEspecificos = new Model_ObjetivosEspecificos ();
					if ($id == '') {
						$id = $model_objetivosEspecificos->insert ( $dados );
						$newid = $id;
					} else {
						$model_objetivosEspecificos->update ( $dados, 'id=' . $id );
					}
					$objetivo_especifico = $model_objetivosEspecificos->fetchRow ( 'id=' . $id );
					$this->view->objetivo_especifico = $objetivo_especifico;
					$this->view->response = array ('dados' => $objetivo_especifico->toArray (), 'notice' => 'Dados atualizados com sucesso', 'descricao' => $objetivo_especifico->descricao, 'keepOpened' => true, 'refreshPage' => true );
					if (isset ( $newid )) {
						$this->view->response ['newid'] = $newid;
					}
				} catch ( Exception $e ) {
					$this->getResponse ()->setHttpResponseCode ( 501 );
					$this->view->response = array ('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage () );
				}
			} else {
				$this->getResponse ()->setHttpResponseCode ( 501 );
				$this->view->response = array ('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos', 'errors' => $this->form->processAjax ( $formData ) );
			}
		} else {
			$this->view->response = array ('notice' => 'Erro ao gravar dados', 'errormessage' => 'Método esperado: POST' );
		}
	}
	
	public function addparceriaAction() {
		if ($this->getRequest ()->isPost ()) {
			$this->formDescritivo->descricao->addValidator ( new Zend_Validate_StringLength ( 0, 2000 ) );
			$formData = $this->getRequest ()->getPost ();
			if ($this->formDescritivo->isValid ( $formData )) {
				$dados = $this->formDescritivo->getDados ();
				$dados ['objetivo_especifico_id'] = $this->formDescritivo->getValue ( 'objetivo_especifico_id' );
				$model_parcerias = new Model_Parcerias ();
				if ($this->formDescritivo->getValue ( 'id' ) == '') {
					$id = $model_parcerias->insert ( $dados );
				} else {
					$id = $this->formDescritivo->getValue ( 'id' );
					$model_parcerias->update ( $dados, 'id=' . $id );
				}
				
				$parceria = $model_parcerias->fetchRow ( 'id=' . $id );
				$returns = array ();
				$toolbar = $this->view->lineToolbar ( 'objetivo-especifico', $parceria );
				$returns ['toolbar'] = $toolbar;
				$returns ['obj'] = $parceria->toArray ();
				$return = Zend_Json_Encoder::encode ( $returns );
			} else {
				$this->formDescritivo->populate ( $formData );
				$return = $this->formDescritivo->processAjax ( $this->_request->getPost () );
			}
		}
		$this->_helper->viewRenderer->setNoRender ( true );
		echo $return;
	}
}















