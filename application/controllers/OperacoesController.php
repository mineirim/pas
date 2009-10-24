<?php

class OperacoesController extends Zend_Controller_Action {
	
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('validar', 'json')
        			->addActionContext('add',array('json','xml'))
                    ->initContext();    	
        /* Initialize action controller here */
    	$this->form = new Form_Operacoes();
    	$this->form->addElement('hidden','metas_acao_id');
    	$this->form->addDisplayGroup(array('id', 'metas_acao_id','metas_acao_id'),'ident');
    	$this->formDescritivo = new Form_Descritivo();
    	
    	
    	/**
    	 *  @var Elemento que representa o id do programa nos forms descritivos(objetivos e metas)
    	 */
    	$form_operacao_id = new Zend_Form_Element_Hidden('operacao_id');
    	$form_operacao_id->setRequired(true)->addValidator('NotEmpty');
    	$this->formDescritivo->addElement($form_operacao_id);
    	$this->view->formDescritivo = $this->formDescritivo;
		
    	    	
		
	}
	
	public function indexAction() {
		$metas_acao_id = $this->_getParam ( 'metas_acao_id', 0 );
		
		$operacoes = new Model_Operacoes ( );
		$this->view->operacoes = $operacoes->fetchAll ( 'metas_acao_id=' . $metas_acao_id, 'id' );
	}
	/**
	 * Adiciona nova operação
	 * necessário passar o metas_acao_id como parametro
	 * @return unknown_type
	 */
	public function addAction() {
		
		$metas_acao_id = $this->_getParam ( 'metas_acao_id' );
    	
    	$this->form = new Form_Acoes();
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveAction();
    		
    	}
    	
    	$this->form->getElement('metas_acao_id')->setValue($metas_acao_id);
    	$this->view->form = $this->form;
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->operacao);
    		
    	}else{
    		$this->render('edit');
    	}
	}
	
	
	
	
	public function editAction() {
    	$id = $this->_getParam ( 'id' );
    	$operacoes = new Model_Operacoes();
    	$operacao = $operacoes->fetchRow('id='.$id);
    	
    	if($operacao)
    	{
    		$this->form->populate($operacao->toArray());
    	}
    	$this->view->operacao = $operacao;
    	$this->view->form = $this->form;
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->operacao);
    		
    	}else{
    		$this->render('edit');
    	}
	}

	
    private function save()
    {
    	$this->view->form = $this->form;
    	
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
				$operacao = $operacoes->fetchRow('id='.$id);
				$this->view->operacao = $operacao;
				$this->form->submit->setAttrib('class','byajax');
				$this->form->populate ( $operacao->toArray() );			
			}else{
				$this->form->populate ( $formData );
			} 
			
		}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $this->getXml($this->view->operacao);
    	}else{
    		$this->render('edit');
    	}
    }		

    
	public function deleteAction(){
		$this->view->title = "Excluir";
	    
		$this->view->headTitle($this->view->title, 'PREPEND') ;
		
		
		$id = $this->_getParam('id', 0);
		
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
			$this->_redirect('plano/acoes');
		}elseif ($id > 0) {
			
			$operacao = $operacoes->fetchRow('id='.$id);
			$this->view->acao = $operacao;
		}
		
		$form->populate($operacao->toArray());
		$this->view->form = $form;
	}    
    
}



