<?php

class Programacao_MetasController extends Zend_Controller_Action {
	
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
		$ajaxContext->addContext ( 'js', array ('suffix' => 'js' ) );
		$ajaxContext->setAutoJsonSerialization ( false );
		$ajaxContext->addActionContext ( 'index', array ('json', 'xml', 'js' ) )
					->addActionContext ( 'create', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'update', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'delete', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'get', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'save', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'addparceria', array ('html', 'json', 'xml' ) )
					->initContext ();
		if ($this->_request->isXmlHttpRequest ())
			$this->_helper->layout ()->disableLayout ();
	}
	
	public function indexAction() {
		// action body
	}
	
	public function createAction() {
		$this->form = new Programacao_Form_Metas();
		$objetivo_especifico_id = $this->_getParam ( 'objetivo_especifico_id' );
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveAction();
    	}else{
    		if($objetivo_especifico_id){
		    	$this->form->meta->getElement('objetivo_especifico_id')->setValue($objetivo_especifico_id);
		    	$this->view->form = $this->form;
		    	$this->render ( 'edit' );
    		}else {
				$this->_helper->viewRenderer->setNoRender ( true );
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
		if ($this->getRequest ()->isPost ()) {
			if ($form->isValid ( $this->getRequest ()->getPost () )) {
				$id = $form->getValue ( 'id' );
				$this->view->response = array ();
				try {
					$model_metas->update ( array ('situacao_id' => 2 ), 'id=' . $id );
					$meta = $model_metas->fetchRow ( 'id=' . $id );
					$this->view->response = array ('dados' => $meta->toArray (), 
											'notice' => 'Projeto apagado com sucesso', 
											'descricao' => $meta->descricao, 
											'keepOpened' => false, 
											'refreshPage' => true );
				} catch ( Exception $e ) {
					$this->getResponse ()->setHttpResponseCode ( 501 );
					$this->view->response = array ('notice' => 'Erro ao gravar dados', 
											'errormessage' => 'Dados inválidos', 
											'errors' => $this->form->getErrors () );
				}
				$this->render ( 'save' );
			}
		} elseif (( int ) $this->_getParam ( 'id', 0 ) > 0) {
			$this->view->title = "Excluir";
			$this->view->headTitle ( $this->view->title, 'PREPEND' );
			$id = $this->_getParam ( 'id', 0 );
			$meta = $model_metas->fetchRow ( 'id=' . $id );
			$this->view->meta = $meta;
			$form->populate ( $meta->toArray () );
			$this->view->form = $form;
		}		

	}

	public function editAction() {
	   	$id = $this->_getParam ('id',0);
	   	if ($id > 0) {
	    	$metas = new Model_Metas();
	    	$meta = $metas->fetchRow('id='.$id);
    	
	    	if($meta)
	    	{
	    		$this->form = new Programacao_Form_Metas();
	    		$this->form->populate($meta->toArray());
		    	$this->view->meta = $meta;
		    	$this->view->form = $this->form;	
		    	$this->render('edit');
	    	} else {
				$this->_helper->viewRenderer->setNoRender ( true );
				echo "Meta não encontrada";
			}
		} else {
			$this->_helper->viewRenderer->setNoRender ( true );
			echo "<<h2>Esperado informar ID para edição</h2>";
		}	
    	
	}
	
	public function saveAction() {
    	$this->form = new Programacao_Form_Metas();
		if ($this->getRequest ()->isPost ()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				try {
					$dados = $this->form->getValue('meta');
					unset ( $dados ['id'] );
					$id = $this->form->meta->getValue ( 'id' );
					$metas = new Model_Metas ( );
				
					if($id==''){
						$id = $metas->insert ( $dados );
						$newid = $id;
					}else{
						$metas->update($dados, 'id='.$id);
					}
					$meta = $metas->fetchRow ( 'id=' . $id );
					$this->view->meta = $meta;
					$this->view->response = array ('dados' => $meta->toArray (), 
													'notice' => 'Dados atualizados com sucesso', 
													'descricao' => $meta->descricao, 
													'keepOpened' => true, 'refreshPage' => true );
					if (isset ( $newid )) {
						$this->view->response ['newid'] = $newid;
					}
				} catch ( Exception $e ) {
					$this->getResponse ()->setHttpResponseCode ( 501 );
					$this->view->response = array ('notice' => 'Erro ao gravar dados', 
												'errormessage' => $e->getMessage () );
				}			
			} else {
				$this->getResponse ()->setHttpResponseCode ( 501 );
				$this->view->response = array ('notice' => 'Erro ao gravar dados', 
												'errormessage' => 'Formulário com dados inválidos', 
												'errors' => $this->form->getErrors() );
			}
		} else {
			$this->view->response = array ('notice' => 'Erro ao gravar dados', 'errormessage' => 'Método esperado: POST' );
		}
	}
	
	public function addindicadorAction() {
		// action body
	}
	
	public function settrimestralAction() {
		// action body
	}
	
	public function gettrimestreAction() {
		// action body
	}
	
	public function salvartrimestreAction() {
		// action body
	}
	
	public function preencherelatorioAction() {
		// action body
	}
	
	public function procurartrimestreAction() {
		// action body
	}
	public function getAction() {
		// action body
	}
}