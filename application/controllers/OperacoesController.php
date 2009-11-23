<?php

class OperacoesController extends Zend_Controller_Action {
	
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('validar', 'json')
        			->addActionContext('add',array('json','xml'))
                    ->initContext();    	
        /* Initialize action controller here */
    	$this->form = new Form_Operacoes();

    	
		
    	    	
		
	}
	
	public function indexAction() {
		$meta_id = $this->_getParam ( 'meta_id', 0 );
		
		$operacoes = new Model_Operacoes ( );
		$this->view->operacoes = $operacoes->fetchAll ( 'meta_id=' . $meta_id, 'id' );
	}

	/**
	 * Adiciona nova operação
	 * necessário passar o metas_id como parametro
	 * @return unknown_type
	 */
	public function addAction() {
        $this->view->title = "Adicionar Operação";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$meta_id = $this->_getParam ( 'meta_id' );
		$this->form = new Form_Operacoes();
    	$this->form->getElement('meta_id')->setValue($meta_id);
		$this->form->submit->setLabel('Adicionar');
		$this->view->form = $this->form;
	    $this->render('add');	
    	
    	if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$dados = $this->form->getDados ();
				
				$operacoes = new Model_Operacoes ( );
			
				if($this->form->getValue('id')==''){
					$id = $operacoes->insert ( $dados );
				}else{
					$id = $this->form->getValue('id');
					$operacoes->update($dados, 'id='.$id);
				}
				$this->_redirect('plano/meta/meta_id/'.$dados['meta_id']);
			}else{
				$this->form->populate ( $formData );
			}
		}
		
	}
	
	
	
	public function editAction() {
    	$id = $this->_getParam ( 'id' );
    	$operacoes = new Model_Operacoes();
    	$operacao = $operacoes->fetchRow('id='.$id);
    	

		
    	
		if ($this->getRequest ()->isPost ()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$dados = $this->form->getDados ();
				$operacoes = new Model_Operacoes ( );
			
				if($this->form->getValue('id')==''){
					$id = $operacoes->insert ( $dados );
				}else{
					$id = $this->form->getValue('id');
					$operacoes->update($dados, 'id='.$id);
				}
				$this->_redirect('plano/meta/meta_id/'.$dados['meta_id']);
				
			}else{
				$this->form->populate ( $formData );
			} 
			
		}
    	if($operacao)
    	{
    		$this->form->populate($operacao->toArray());
    	}
    	$this->view->operacao = $operacao;
    	$this->form->submit->setLabel('Salvar');
    	$this->view->form = $this->form;
		
		$this->render('edit');

	}

	
     
	public function deleteAction(){
		$this->view->title = "Excluir";
	    
		$this->view->headTitle($this->view->title, 'PREPEND') ;
		
		
		$id = $this->_getParam('id', 0);
		$meta_id = $this->_getParam('meta_id', 0);
		
		$form = new Zend_Form();
		$form->addElement('hidden','id');
		$form->addElement('submit','ok');
		
		$operacoes = new Model_Operacoes();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$id = $form->getValue('id');
				$operacao = $operacoes->fetchRow('id='.$id);
				$operacao->situacao_id=2;
				$operacao->save();
			}
			$this->_redirect('plano/meta/meta_id/'.$meta_id);
		}elseif ($id > 0) {
			
			$operacao = $operacoes->fetchRow('id='.$id);
			$this->view->acao = $operacao;
		}
		
		$form->populate($operacao->toArray());
		$this->view->form = $form;
	}    
    
}



