<?php

class ProjetosController extends Zend_Controller_Action {
	
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('validar', 'json')
        			->addActionContext('add',array('json','xml'))
        			->addActionContext('addobjetivo',array('json','xml'))
        			->addActionContext('addmeta',array('json','xml'))
                    ->initContext();    	
        /* Initialize action controller here */
    	$this->form = new Form_Geral();
    	$this->form->addElement('hidden','programa_id');
		$this->form->addElement('hidden','projeto_id');
		$this->form->addDisplayGroup(array('id', 'programa_id','projeto_id'),'ident');
    	$this->form->menu->setRequired(true)
			->addValidator('NotEmpty');
		
		
    	$this->formDescritivo = new Form_Descritivo();
    	
    	
    	/**
    	 *  @var Elemento que representa o id do programa nos forms descritivos(objetivos e metas)
    	 */
    	$form_projeto_id = new Zend_Form_Element_Hidden('projeto_id');
    	$form_projeto_id->setRequired(true)->addValidator('NotEmpty');
    	$this->formDescritivo->addElement($form_projeto_id);
    	$this->view->formDescritivo = $this->formDescritivo;
		$this->frmIndicador = new Form_Indicador();
		$this->frmIndicador->addElement($form_projeto_id); 
		$this->view->frmIndicador =$this->frmIndicador;    	
    	
    	    	
		if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}	
	}
	
	public function indexAction() {
		$programa_id = $this->_getParam ( 'programa_id', 0 );
		
		$projetos = new Model_Projetos ( );
		$this->view->projetos = $projetos->fetchAll ( 'programa_id=' . $programa_id, 'id' );
	}
	/**
	 * Adiciona novo projeto
	 * necessário passar o programa_id como parametro e o projeto_id quando subprojeto
	 * @return unknown_type
	 */
	public function addAction() {
		
		$this->form->submit->setLabel ( 'Adicionar' );
		$programa_id = $this->_getParam ( 'programa_id' );
		$projeto_id = $this->_getParam ( 'projeto_id' );
		
		$this->view->form = $this->form;
		
		if ($programa_id) 
		{
			$this->view->form->programa_id->setValue($programa_id);
			$this->view->form->projeto_id->setValue( $projeto_id);
			
			
			$this->render ( 'edit' );
		} else {
			$this->_redirect('erro');
		}
	}
	
	
	
	
	public function editAction() {

		
		$id = $this->_getParam ( 'id',0 );
		$this->form->submit->setLabel('Salvar');
		
    	if ($this->getRequest ()->isPost ()) {
    		$this->save();
    	}elseif ($id > 0) {
    		$projetos = new Model_Projetos ( );;
    		$projeto = $projetos->fetchRow('id='.$id );    	
	    	if($projeto)
	    	{
	    		$this->form->populate($projeto->toArray());
	    	}
	    	$this->view->projeto = $projeto;
	    	$this->view->form = $this->form;
	    	
	    	if ($this->_request->isXmlHttpRequest()) {
	                $this->_helper->layout()->disableLayout();
	                $this->_helper->viewRenderer->setNoRender(true);
	               	echo $this->getXml($this->view->projeto);
	    		
	    	}else{
	    		$this->render('edit');
	    	}
    	}else{
    		// o que fazer quando não passar parametro?
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
				
				
				$projetos = new Model_Projetos ( );
				
				if($this->form->getValue('id')==''){
					$dados['programa_id']=$this->form->getValue ( 'programa_id' );
					if($this->form->getValue ( 'projeto_id' ) )
						$dados['projeto_id']=$this->form->getValue ( 'projeto_id' ) ;
					$id = $projetos->insert ( $dados );
				}else{
					$projetos->update($dados, 'id='.$id );
				}
				$projeto = $projetos->fetchRow('id='.$id );
				$this->view->projeto = $projeto;
				$this->form->submit->setAttrib('class','byajax');
				$this->form->populate ( $projeto->toArray() );
							
			}else{
				
				$this->form->populate ( $formData );
			} 
			
		}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $this->getXml($this->view->projeto);
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
		
		$projetos = new Model_Projetos();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$id = $form->getValue('id');
				$projeto = $projetos->fetchRow('id='.$id);
				$projeto->situacao_id=2;
				$projeto->save();
			}
			$this->_redirect('plano/programas');
		}elseif ($id > 0) {
			
			$projeto = $projetos->fetchRow('id='.$id);
			$this->view->programa = $projeto;
		}
		
		$form->populate($projeto->toArray());
		$this->view->form = $form;
	}    
    
    
    /**
     * Adiciona objetio ao programa
     * @return unknown_type
     */
    public function addobjetivoAction(){
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$formData = $this->getRequest ()->getPost ();
			if ($this->formDescritivo->isValid ( $formData )) 
			{
    			$dados = $this->formDescritivo->getDados ();
    			$dados['projeto_id'] = $this->formDescritivo->getValue('projeto_id');
    			$objetivosProjeto = new Model_ObjetivosProjeto();
				if($this->formDescritivo->getValue('id')==''){
					$id = $objetivosProjeto->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$objetivosProjeto->update($dados, 'id='.$id);
				}
				
    			$objetivoProjeto = $objetivosProjeto->fetchRow('id='.$id);
    			$returns =array();
    			$toolbar = $this->view->lineToolbar('projetos',$objetivoProjeto);
    			$returns['toolbar']=$toolbar;
    			$returns['obj'] = $objetivoProjeto->toArray();
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
    		
    		$url = 'projetos/edit/id/'.$this->formDescritivo->getValue('projeto_id').'/tab/2';
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
    			$dados['projeto_id'] = $this->formDescritivo->getValue('projeto_id'); 
    			$metasProjeto = new Model_MetasProjeto();
				if($this->formDescritivo->getValue('id')==''){
					$id = $metasProjeto->insert ( $dados );
				}else{
					$id = $this->formDescritivo->getValue('id');
					$metasProjeto->update($dados, 'id='.$id);
				}
    			$metaProjeto = $metasProjeto->fetchRow('id='.$id);
    			$returns =array();
    			
    			$toolbar = $this->view->lineToolbar('projetos',$metaProjeto);
    			$returns['toolbar']=$toolbar;
    			$returns['obj'] = $metaProjeto->toArray();
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
    		
    		$url = 'projetos/edit/id/'.$this->formDescritivo->getValue('projeto_id').'/tab/3';
    		$this->_redirect($url);
    	}
    	
    }

    
    /**
     * Adiciona objetio ao programa
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
				
				$projeto_id = $this->frmIndicador->getValue('projeto_id');
				$indicadoresProjeto = new Model_IndicadoresProjeto();
				$indicadorProjeto = $indicadoresProjeto->fetchRow('projeto_id='.$projeto_id.' and indicador_id='.$id);
				if(!$indicadorProjeto){
					$arr = array('projeto_id'=>$projeto_id, 'indicador_id'=>$id);
					$indicadoresProjeto->insert($arr);
				}
    			$indicador = $indicadores->fetchRow('id='.$id);
    			
    			$returns =array();
    			$toolbar = $this->view->lineToolbar('projetos',$indicador);
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
    		
    		$url = 'projetos/edit/id/'.$this->frmIndicador->getValue('projeto_id').'/tab/3';
    		$this->_redirect($url);
    	}
    	
    }    
        
    
}



