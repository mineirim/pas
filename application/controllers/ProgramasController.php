<?php

class ProgramasController extends Zend_Controller_Action {
	private $form;
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('validar', 'json')
        			->addActionContext('add',array('json','xml'))
        			->addActionContext('addObjetivo',array('json','xml'))
                    ->initContext();    	
        /* Initialize action controller here */
    	$this->form = new Form_Geral();
    	$this->formDescritivo = new Form_Descritivo();
    	
    	$this->form->menu->setRequired(true)
			->addValidator('NotEmpty');
    	
    	/**
    	 *  @var Elemento que representa o id do programa nos forms descritivos(objetivos e metas)
    	 */
    	$form_programa_id = new Zend_Form_Element_Hidden('programa_id');
    	$form_programa_id->setRequired(true)->addValidator('NotEmpty');
    	$this->formDescritivo->addElement($form_programa_id);
    	$this->view->formDescritivo = $this->formDescritivo;
		$this->frmIndicador = new Form_Indicador();
		$this->view->frmIndicador =$this->frmIndicador;    	

		
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
    			
	}
	
	public function indexAction() {
		$programas = new Model_Programas ( );
		
		$this->view->programas = $programas->fetchAll ( null, 'id' );
	}
	
	public function addAction() {
		
		$this->form->submit->setLabel ( 'Adicionar' );
		$this->view->form = $this->form;
    	
   		$this->render('edit');
		
	}
	
	/**
	 * Edita o programa
	 */
	public function editAction() {
		
		$this->form->submit->setLabel('Salvar');
		
		
		$id = $this->_getParam ( 'id' );
    	
    	if ($this->getRequest ()->isPost ()) {
    		$this->save();
    	}elseif ($id > 0) {
    		$programas = new Model_Programas();
    		$programa = $programas->fetchRow('id='.$id);    	
	    	if($programa)
	    	{
	    		$this->form->populate($programa->toArray());
	    	}
	    	$this->view->programa = $programa;
	    	$this->view->form = $this->form;
	    	
	    	if ($this->_request->isXmlHttpRequest()) {
	                $this->_helper->layout()->disableLayout();
	                $this->_helper->viewRenderer->setNoRender(true);
	               	echo $this->getXml($this->view->programa);
	    		
	    	}else{
	    		$this->render('edit');
	    	}
    	}

	}

	
    private function save()
    {
		$this->view->form = $this->form;
    	$this->form->submit->setLabel('Salvar');
    	
		if ($this->getRequest ()->isPost ()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$id = $this->form->getValue('id');
				$dados = $this->form->getDados ();
				$programas = new Model_Programas ( );;
				
			
				if($this->form->getValue('id')==''){
					$id = $programas->insert ( $dados );
				}else{
					$id = $this->form->getValue('id');
					$programas->update($dados, 'id='.$id );
				}
				$programa = $programas->fetchRow('id='.$id );
				$this->view->programa = $programa;
				$this->form->submit->setAttrib('class','byajax');
				$this->form->populate ( $programa->toArray() );
							
			}else{
				
				$this->form->populate ( $formData );
			} 
			
		}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $this->getXml($this->view->programa);
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
		
		$programas = new Model_Programas();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$id = $form->getValue('id');
				$programa = $programas->fetchRow('id='.$id);
				$programa->situacao_id=2;
				$programa->save();
			}
			$this->_redirect('plano/programas');
		}elseif ($id > 0) {
			
			$programa = $programas->fetchRow('id='.$id);
			$this->view->programa = $programa;
		}
		
		$form->populate($programa->toArray());
		$this->view->form = $form;
	}
	
	
    /**
     * Adiciona objetio ao programa
     * @return unknown_type
     */
    public function addobjetivoAction(){
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->formDescritivo->descricao->addValidator(new Zend_Validate_StringLength(0,500));
    		$formData = $this->getRequest ()->getPost ();
			if ($this->formDescritivo->isValid ( $formData )) 
			{
    			$dados = $this->formDescritivo->getDados ();
    			$dados['programa_id'] = $this->formDescritivo->getValue('programa_id');
    			$objetivosPrograma = new Model_ObjetivosPrograma();
				if($this->formDescritivo->getValue('id')==''){
					$id = $objetivosPrograma->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$objetivosPrograma->update($dados, 'id='.$id);
				}
				
    			$objetivoPrograma = $objetivosPrograma->fetchRow('id='.$id);
				$returns =array();
    			$toolbar = $this->view->lineToolbar('programas',$objetivoPrograma);
    			$returns['toolbar']=$toolbar;
    			$returns['obj'] = $objetivoPrograma->toArray();    			
    			$return = Zend_Json_Encoder::encode($returns);
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
    		
    		$url = 'programas/edit/id/'.$this->formDescritivo->getValue('programa_id').'/tab/2';
    		$this->_redirect($url);
    	}
    	
    }
	
  
    /**
     * Adiciona indicador ao programa
     * @return unknown_type
     */
    public function addindicadorAction(){
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$formData = $this->getRequest ()->getPost ();
			if ($this->frmIndicador->isValid ( $formData )) 
			{
    			$dados = $this->frmIndicador->getDados ();
    			$indicadores = new Model_Indicadores();
				if($this->frmIndicador->getValue('id')==''){
					$id = $indicadores->insert ( $dados );
				}else{
					$id = $this->frmIndicador->getValue('id');
					$indicadores->update($dados, 'id='.$id);
				}
				$programa_id = $this->_getParam('programa_id');
				$indicadoresPrograma = new Model_IndicadoresPrograma();
				$indicadorPrograma = $indicadoresPrograma->fetchRow('programa_id='.$programa_id.' and indicador_id='.$id);
				if(!$indicadorPrograma){
					$arr = array('programa_id'=>$programa_id, 'indicador_id'=>$id);
					$indicadoresPrograma->insert($arr);
				}
    			$indicador = $indicadores->fetchRow('id='.$id);
    			
    			$returns =array();
    			$toolbar = $this->view->lineToolbar('indicadores',$indicador);
    			$toolbar .= "</td><td>". $this->view->indicadoresToolbar($indicador);
    			$returns['toolbar']=$toolbar;
    			$returns['obj'] = $indicador->toArray(); 
    			$return = Zend_Json_Encoder::encode($returns);
			}else{
				$this->frmIndicador->populate($formData);
				$return = $this->frmIndicador->processAjax($this->_request->getPost());
			}
    	}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $return;
    	}else{
    		
    		$url = 'programas/edit/id/'.$this->frmIndicador->getValue('programa_id').'/tab/4';
    		$this->_redirect($url);
    	}
    	
    }    
    
    /**
     * Adiciona meta ao programa
     * @return unknown_type
     */
    public function addmetaAction(){
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$formData = $this->getRequest ()->getPost ();
			if ($this->formDescritivo->isValid ( $formData )) 
			{
    			$dados = $this->formDescritivo->getDados ();
    			$dados['programa_id'] = $this->formDescritivo->getValue('programa_id'); 
    			$metasPrograma = new Model_MetasPrograma();
				if($this->formDescritivo->getValue('id')==''){
					$id = $metasPrograma->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$metasPrograma->update($dados, 'id='.$id);
				}
    			$metaPrograma = $metasPrograma->fetchRow('id='.$id);
    			$returns =array();
    			$toolbar = $this->view->lineToolbar('metas',$metaPrograma);
    			$returns['toolbar']=$toolbar;
    			$returns['obj'] = $metaPrograma->toArray(); 
    			$return = Zend_Json_Encoder::encode($returns);
    			
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
    		
    		$url = 'programas/edit/id/'.$this->formDescritivo->getValue('programa_id').'/tab/3';
    		$this->_redirect($url);
    	}
    	
    }       
    	
}







