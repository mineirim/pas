<?php

class ObjetivosEspecificosController extends Zend_Controller_Action
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
    	$this->form = new Form_ObjetivosEspecificos();
    	
    	$this->formDescritivo = new Form_Descritivo();
    	
    	
    	
    	$form_objetivoespecifico_id = new Zend_Form_Element_Hidden('objetivo_especifico_id');
    	$form_objetivoespecifico_id->setRequired(true)->addValidator('NotEmpty');
    	$this->formDescritivo->addElement($form_objetivoespecifico_id);
    	$this->view->formDescritivo = $this->formDescritivo;
    	
    	 
    }

    public function indexAction()
    {
        // action body
    }
    public function addAction()
    {
		$projeto_id = $this->_getParam ( 'projeto_id' );
    	
    	$this->form = new Form_ObjetivosEspecificos();
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveAction();
    		
    	}
    	
    	$this->form->getElement('projeto_id')->setValue($projeto_id);
    	$this->view->form = $this->form;
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->objetivo_especifico);
    		
    	}else{
    		$this->render('edit');
    	}
    	
    } 
    public function editAction()
    {
    	$id = $this->_getParam ( 'id' );
    	$objetivosEspecificos = new Model_ObjetivosEspecificos();
    	$objetivo_especifico = $objetivosEspecificos->fetchRow('id='.$id);
    	
    	if($objetivo_especifico)
    	{
    		$this->form->populate($objetivo_especifico->toArray());
    	}
    	$this->view->objetivo_especifico = $objetivo_especifico;
    	$this->view->form = $this->form;
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->objetivo_especifico);
    		
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
				$objetivosEspecificos = new Model_ObjetivosEspecificos ( );
			
				if($this->form->getValue('id')==''){
					$id = $objetivosEspecificos->insert ( $dados );
				}else{
					$id = $this->form->getValue('id');
					$objetivosEspecificos->update($dados, 'id='.$id);
				}
				$objetivo_especifico = $objetivosEspecificos->fetchRow('id='.$id);
				$this->view->objetivo_especifico = $objetivo_especifico;
				$this->form->submit->setAttrib('class','byajax');
				$this->form->populate ( $objetivo_especifico->toArray() );			
			}else{
				$this->form->populate ( $formData );
			} 
			
		}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $this->getXml($this->view->objetivo_especifico);
    	}else{
    		$this->render('edit');
    	}
		
    
    }

    /**
     * Adiciona Estratégia ao ObjetivoEspecífico
     */
    public function addestrategiaAction(){
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$formData = $this->getRequest ()->getPost ();
			if ($this->formDescritivo->isValid ( $formData )) 
			{
    			$dados = $this->formDescritivo->getDados ();
    			$dados['objetivo_especifico_id'] = $this->formDescritivo->getValue('objetivo_especifico_id');
    			 
    			$estrategias = new Model_Estrategias();
				if($this->formDescritivo->getValue('id')==''){
					$id = $estrategias->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$estrategias->update($dados, 'id='.$id);
				}
    			$estrategia = $estrategias->fetchRow('id='.$id);
    			$return = Zend_Json_Encoder::encode($estrategia->toArray());
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
    		$this->_setParam('id',$this->formDescritivo->getValue('objetivo_especifico_id'));
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
    			$dados['objetivo_especifico_id'] = $this->formDescritivo->getValue('objetivo_especifico_id');
    			
    			$metas = new Model_Metas();
				if($this->formDescritivo->getValue('id')==''){
					$id = $metas->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$metas->update($dados, 'id='.$id);
				}
    			$meta = $metas->fetchRow('id='.$id);
    			$return = Zend_Json_Encoder::encode($meta->toArray());
    			
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
    		$this->_forward('edit',null,null,array('id'=>$this->formDescritivo->getValue('objetivo_especifico_id')));
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
    			$dados['objetivo_especifico_id'] = $this->formDescritivo->getValue('objetivo_especifico_id'); 
    			
    			$parcerias = new Model_Parcerias();
				if($this->formDescritivo->getValue('id')==''){
					$id = $parcerias->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$parcerias->update($dados, 'id='.$id);
				}
    			$parceria = $parcerias->fetchRow('id='.$id);
    			$return = Zend_Json_Encoder::encode($parceria->toArray());
    			
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
    		$this->_forward('edit',null,null,array('id'=>$this->formDescritivo->getValue('objetivo_especifico_id')));
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
 
		$responseNode = $this->_xml->createElement('objetivo_especifico');
		if($row){
			$id = $this->_xml->createElement('id',$row->id);
			$responseNode->appendChild($id);
		}
        $this->_xml->appendChild($responseNode);
		return $this->_xml->saveXML();
		
	}
}

