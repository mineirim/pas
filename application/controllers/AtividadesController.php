<?php

class AtividadesController extends Zend_Controller_Action {
	
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('validar', 'json')
        			->addActionContext('add',array('json','xml'))
                    ->initContext();    	
        /* Initialize action controller here */
    	$this->form = new Form_Atividades();
    	$this->form->addElement('hidden','operacao_id');
    	$this->form->addDisplayGroup(array('id', 'operacao_id','operacao_id'),'ident');
    	$this->formDescritivo = new Form_Descritivo();
    	
    	
    	/**
    	 *  @var Elemento que representa o id do programa nos forms descritivos(objetivos e metas)
    	 */
    	$form_atividade_id = new Zend_Form_Element_Hidden('atividade_id');
    	$form_atividade_id->setRequired(true)->addValidator('NotEmpty');
    	$this->formDescritivo->addElement($form_atividade_id);
    	$this->view->formDescritivo = $this->formDescritivo;
		
    	    	
		
	}
	
	public function indexAction() {
		$operacao_id = $this->_getParam ( 'operacao_id', 0 );
		
		$atividades = new Model_Atividades ( );
		$this->view->atividades = $atividades->fetchAll ( 'operacao_id=' . $operacao_id, 'id' );
	}
	/**
	 * Adiciona nova atividade
	 * necessário passar o operacao_id como parametro
	 * @return unknown_type
	 */
	public function addAction() {
		
		$operacao_id = $this->_getParam ( 'operacao_id' );
    	
    	$this->form = new Form_Atividades();
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveAction();
    		
    	}
    	
    	$this->view->form = $this->form;
    	$this->form->getElement('operacao_id')->setValue($operacao_id);
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->atividade);
    		
    	}else{
    		$this->render('add');
    	}
	}
	
	
	
	
	public function editAction() {
    	$id = $this->_getParam ( 'id' );
    	$atividades = new Model_Atividades();
    	$atividade = $atividades->fetchRow('id='.$id);
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveAction();
    		
    	}
    	$this->view->atividade = $atividade;
    	$this->view->form = $this->form;
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->atividade);
    		
    	}else{
    		$this->render('edit');
    	}
	}

	
    private function saveAction()
    {
    	$this->view->form = $this->form;
    	
    	if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$dados = $this->form->getDados ();
				
				$atividades = new Model_Atividades ( );
			
				if($this->form->getValue('id')==''){
					$id = $atividades->insert ( $dados );
				}else{
					$id = $this->form->getValue('id');
					$atividades->update($dados, 'id='.$id);
				}
				$this->_redirect('plano/operacao/operacao_id/'.$dados['operacao_id']);
			}else{
				$this->form->populate ( $formData );
			}
		}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $this->getXml($this->view->atividade);
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
		
		$atividades = new Model_Atividades();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$id = $form->getValue('id');
				$atividade = $atividades->fetchRow('id='.$id);
				$atividade->situacao_id=2;
				$atividade->save();
			}
			$this->_redirect('plano/operacoes');
		}elseif ($id > 0) {
			
			$atividade = $atividades->fetchRow('id='.$id);
			$this->view->operacao = $atividade;
		}
		
		$form->populate($atividade->toArray());
		$this->view->form = $form;
	}    
    
}



