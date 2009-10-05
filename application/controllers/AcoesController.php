<?php

class AcoesController extends Zend_Controller_Action
{
	private $form;
	private $formObjetivos;
	private $formDescritivo;
    public function init()
    {
    	
 		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('validar', 'json')
        			->addActionContext('add',array('json','xml'))
        			->addActionContext('addObjetivo',array('json','xml'))
                    ->initContext();    	
        /* Initialize action controller here */
    	$this->form = new Form_Acoes();
    	
    	$this->formDescritivo = new Form_Descritivo();
    	
    	
    	
    	$form_acao_id = new Zend_Form_Element_Hidden('acao_id');
    	$form_acao_id->setRequired(true)->addValidator('NotEmpty');
    	$this->formDescritivo->addElement($form_acao_id);
    	$this->view->formDescritivo = $this->formDescritivo;
    	
    	$this->view->selectobjetivos = new Zend_Form_Element_Select('objetivo_id');
    	$this->view->selectobjetivos->setLabel("Vincular ao objetivo:");
    					
    	 
    }

    public function indexAction()
    {
        // action body
    }
    public function addAction()
    {
		$projeto_id = $this->_getParam ( 'projeto_id' );
    	
    	$this->form = new Form_Acoes();
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveAction();
    		
    	}
    	
    	$this->form->getElement('projeto_id')->setValue($projeto_id);
    	$this->view->form = $this->form;
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->acao);
    		
    	}else{
    		$this->render('edit');
    	}
    	
    } 
    public function editAction()
    {
    	$id = $this->_getParam ( 'id' );
    	$acoes = new Model_Acoes();
    	$acao = $acoes->fetchRow('id='.$id);
    	
    	if($acao)
    	{
    		$this->form->populate($acao->toArray());
    	}
    	$this->view->acao = $acao;
    	$this->view->form = $this->form;
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->acao);
    		
    	}else{
    		$this->render('edit');
    	}
    	
    }
    public function saveAction()
    {
    	$this->view->form = $this->form;
    	
		if ($this->getRequest ()->isPost ()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$dados = $this->form->getDados ();
				$acoes = new Model_Acoes ( );
			
				if($this->form->getValue('id')==''){
					$id = $acoes->insert ( $dados );
				}else{
					$id = $this->form->getValue('id');
					$acoes->update($dados, 'id='.$id);
				}
				$acao = $acoes->fetchRow('id='.$id);
				$this->view->acao = $acao;
				$this->form->submit->setAttrib('class','byajax');
				$this->form->populate ( $acao->toArray() );			
			}else{
				$this->form->populate ( $formData );
			} 
			
		}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $this->getXml($this->view->acao);
    	}else{
    		$this->render('edit');
    	}
		
    
    }
    /**
     * Adiciona objetio à ação
     * @return unknown_type
     */
    public function addobjetivoAction(){
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$formData = $this->getRequest ()->getPost ();
			if ($this->formDescritivo->isValid ( $formData )) 
			{
    			$dados = $this->formDescritivo->getDados ();
    			$dados['acao_id'] = $this->formDescritivo->getValue('acao_id');
    			$objetivosAcao = new Model_ObjetivosAcao();
				if($this->formDescritivo->getValue('id')==''){
					$id = $objetivosAcao->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$objetivosAcao->update($dados, 'id='.$id);
				}
				
    			$objetivoAcao = $objetivosAcao->fetchRow('id='.$id);
    			$return = Zend_Json_Encoder::encode($objetivoAcao->toArray());
			}else{
				$this->formDescritivo->populate($formData);
				$return = $this->formDescritivo->processAjax($this->_request->getPost());
			}
    	}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $return;
    	}else{
    		$this->_setParam('id',$this->formDescritivo->getValue('acao_id'));
    		$this->_forward('edit');
    	}
    	
    }
    /**
     * Adiciona Estratégia à ação
     */
    public function addestrategiaAction(){
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$formData = $this->getRequest ()->getPost ();
			if ($this->formDescritivo->isValid ( $formData )) 
			{
    			$dados = $this->formDescritivo->getDados ();
    			$dados['acao_id'] = $this->formDescritivo->getValue('acao_id');
    			$objetivo_id = $this->formDescritivo->getValue('acao_id');
    			$dados['objetivo_id']= $objetivo_id?$objetivo_id :'null';
    			 
    			$estrategiasAcao = new Model_EstrategiasAcao();
				if($this->formDescritivo->getValue('id')==''){
					$id = $estrategiasAcao->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$estrategiasAcao->update($dados, 'id='.$id);
				}
    			$estrategiaAcao = $estrategiasAcao->fetchRow('id='.$id);
    			$return = Zend_Json_Encoder::encode($estrategiaAcao->toArray());
			}else{
				$this->formDescritivo->populate($formData);
				$return = $this->formDescritivo->processAjax($this->_request->getPost());
			}
    	}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $return;
    	}else{
    		$this->_setParam('id',$this->formDescritivo->getValue('acao_id'));
    		$this->dispatch('edit');
    	}
    	
    }    

    
    /**
     * Adiciona meta à ação
     * @return unknown_type
     */
    public function addmetaAction(){
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$formData = $this->getRequest ()->getPost ();
			if ($this->formDescritivo->isValid ( $formData )) 
			{
    			$dados = $this->formDescritivo->getDados ();
    			$dados['acao_id'] = $this->formDescritivo->getValue('acao_id'); 
    			$metasAcao = new Model_MetasAcao();
				if($this->formDescritivo->getValue('id')==''){
					$id = $metasAcao->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$metasAcao->update($dados, 'id='.$id);
				}
    			$metaAcao = $metasAcao->fetchRow('id='.$id);
    			$return = Zend_Json_Encoder::encode($metaAcao->toArray());
    			
			}else{
				$this->formDescritivo->populate($formData);
				$return = $this->formDescritivo->processAjax($this->_request->getPost());
			}
    	}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $return;
    	}else{
    		$this->_forward('edit',null,null,array('id'=>$this->formDescritivo->getValue('acao_id')));
    	}
    	
    }       

    /**
     * Adiciona parceria à ação
     * @return unknown_type
     */
    public function addparceriaAction(){
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$formData = $this->getRequest ()->getPost ();
			if ($this->formDescritivo->isValid ( $formData )) 
			{
    			$dados = $this->formDescritivo->getDados ();
    			$dados['acao_id'] = $this->formDescritivo->getValue('acao_id'); 
    			$parceriasAcao = new Model_ParceriasAcao();
				if($this->formDescritivo->getValue('id')==''){
					$id = $parceriasAcao->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$parceriasAcao->update($dados, 'id='.$id);
				}
    			$parceriaAcao = $parceriasAcao->fetchRow('id='.$id);
    			$return = Zend_Json_Encoder::encode($parceriaAcao->toArray());
    			
			}else{
				$this->formDescritivo->populate($formData);
				$return = $this->formDescritivo->processAjax($this->_request->getPost());
			}
    	}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $return;
    	}else{
    		$this->_forward('edit',null,null,array('id'=>$this->formDescritivo->getValue('acao_id')));
    	}
    	
    }      
    
    public function validarAction() {
        if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
                echo($this->form->processAjax($this->_request->getPost()));
                
        }
	}
    
	private function getXml($row =false){
		$this->_xml = new DOMDocument('1.0', 'UTF-8');
        $this->_xml->formatOutput = true;
 
		$responseNode = $this->_xml->createElement('acao');
		if($row){
			$id = $this->_xml->createElement('id',$row->id);
			$responseNode->appendChild($id);
		}
        $this->_xml->appendChild($responseNode);
		return $this->_xml->saveXML();
		
	}
}

