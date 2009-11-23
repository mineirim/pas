<?php

class MetasController extends Zend_Controller_Action
{

	private $form;
	private $formObjetivos;
	private $formDescritivo;
    public function init()
    {
    	
 		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('validar', 'json')
        			->addActionContext('add',array('json','xml'))
                    ->initContext();    	
        /* Initialize action controller here */
    	
    	$this->form = new Form_Metas();
    	
    	
    	
    	 
    }

    public function indexAction()
    {
        // action body
    }
    public function addAction()
    {
		$objetivo_especifico_id = $this->_getParam ( 'objetivo_especifico_id' );
    	
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveAction();
    		
    	}
    	$this->form->getElement('objetivo_especifico_id')->setValue($objetivo_especifico_id);
    	$this->view->form = $this->form;
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->meta);
    		
    	}else{
    		$this->render('edit');
    	}
    	
    } 
    public function editAction()
    {
    	$id = $this->_getParam ( 'id' );
    	$metas = new Model_Metas();
    	$meta = $metas->fetchRow('id='.$id);
    	
    	if($meta)
    	{
    		$this->form->populate($meta->toArray());
    	}
    	$this->view->meta = $meta;
    	$this->view->form = $this->form;
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->meta);
    		
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
				$metas = new Model_Metas ( );
			
				if($this->form->getValue('id')==''){
					$id = $metas->insert ( $dados );
				}else{
					$id = $this->form->getValue('id');
					$metas->update($dados, 'id='.$id);
				}
				$objetivo_especifico_id = $dados['objetivo_especifico_id'];
				$url = $this->view->url(array('controller'=>'plano','action'=>'objetivos-especificos','objetivo_especifico_id'=>$objetivo_especifico_id));
				
				$this->_redirect($url,array('prependBase' => false));
				$meta = $metas->fetchRow('id='.$id);
				$this->view->meta = $meta;
				$this->form->populate ( $meta->toArray() );			
			}else{
				$this->form->populate ( $formData );
			} 
			
		}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $this->getXml($this->view->meta);
    	}else{
    		$this->render('edit');
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

