<?php

class Programacao_OperacoesController extends Zend_Controller_Action
{

    public function init()
    {
        $ajaxContext = $this->_helper->ajaxContext;
		$ajaxContext->addContext ( 'js', array ('suffix' => 'js' ) );
		$ajaxContext->setAutoJsonSerialization ( false );
		$ajaxContext->addActionContext ( 'index', array ('json', 'xml', 'js' ) )
					->addActionContext ( 'create', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'update', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'delete', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'get', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'save', array ('html', 'json', 'xml' ) )
					->initContext ();
		if ($this->_request->isXmlHttpRequest ())
			$this->_helper->layout ()->disableLayout ();
    }

    public function indexAction()
    {
       
    }

    public function createAction()
    {
		
		$meta_id = $this->_getParam ( 'meta_id' );
    	$this->form = new Programacao_Form_Operacao();
		
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveAction();
    	}else{
    		if($meta_id){
		        $this->view->title = "Adicionar Operação";
				$this->view->headTitle($this->view->title, 'PREPEND');
				$this->form->operacao->meta_id->setValue($meta_id);
		    	$this->view->form = $this->form;
		    	$this->render ( 'edit' );
    		}else {
				$this->_helper->viewRenderer->setNoRender ( true );
				echo "<h1>Esperado informar o código da Meta";
			}
    	}		
		
    }

    public function updateAction()
    {
        // action body
    }

    public function deleteAction()
    {
		$form = new Programacao_Form_Delete ();
		$model_operacoes = new Model_Operacoes();
		if ($this->getRequest ()->isPost ()) {
			if ($form->isValid ( $this->getRequest ()->getPost () )) {
				$id = $form->getValue ( 'id' );
				$this->view->response = array ();
				try {
					$model_operacoes->update ( array ('situacao_id' => 2 ), 'id=' . $id );
					$operacao = $model_operacoes->fetchRow ( 'id=' . $id );
					$this->view->response = array ('dados' => $operacao->toArray (), 
											'notice' => 'Operação apagada com sucesso', 
											'descricao' => $operacao->descricao, 
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
			$operacao = $model_operacoes->fetchRow ( 'id=' . $id );
			$this->view->operacao = $operacao;
			$form->populate ( $operacao->toArray () );
			$this->view->form = $form;
		}		
    }

    public function getAction()
    {
        // action body
    }

    public function editAction()
    {
	   	$id = $this->_getParam ('id',0);
	   	
	   	if ($id > 0) {
	    	$operacoes = new Model_Operacoes();
    		$operacao = $operacoes->fetchRow('id='.$id);
    	
	    	if($operacao)
	    	{
	    		$this->view->title = "Alterar Operação";
				$this->view->headTitle($this->view->title, 'PREPEND');
	    		$this->form = new Programacao_Form_Operacao();
	    		$this->form->populate($operacao->toArray());
		    	$this->view->operacao = $operacao;
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

    public function saveAction()
    {
       	$this->form = new Programacao_Form_Operacao();
		if ($this->getRequest ()->isPost ()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				try {
					$dados = $this->form->getValue('operacao');
					unset ( $dados ['id'] );
					$id = $this->form->operacao->getValue ( 'id' );
					$model_operacoes = new Model_Operacoes();
					if($id==''){
						$id = $model_operacoes->insert ( $dados );
						$newid = $id;
					}else{
						$model_operacoes->update($dados, 'id='.$id);
					}
					$operacao = $model_operacoes->fetchRow ( 'id=' . $id );
					$this->view->operacao = $operacao;
					$this->view->response = array ('dados' => $operacao->toArray (), 
													'notice' => 'Dados atualizados com sucesso', 
													'descricao' => $operacao->descricao, 
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


}













