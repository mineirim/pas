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
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
    	
		
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
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveAction();
    		
    	}
    	$atividade = $atividades->fetchRow('id='.$id);
    	
    	if($atividade){
    		$inicio = new Zend_Date($atividade->inicio_data,Zend_Date::ISO_8601);
    		
    		$prazo =  new Zend_Date($atividade->prazo_data,Zend_Date::ISO_8601);
    		
    		$atividade->inicio_data = $inicio->toString('dd/MM/yyyy');
    		$atividade->prazo_data = $prazo->toString('dd/MM/yyyy');
    		 
    		$this->form->populate($atividade->toArray());
    	}else{
    		$this->_redirect('error/naoexiste');
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

	
    public function saveAction()
    {
    	$this->view->form = $this->form;
    	if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$dados = $this->form->getDados ();
				$di =  new Zend_Date($dados['inicio_data']);
				$dados['inicio_data'] = $di->get(Zend_Date::W3C);
				$atividades = new Model_Atividades ( );
				
				
				if($this->form->getValue('id')==''){
					$dp = new Zend_Date($dados['prazo_data']);
					$dados['prazo_data'] =  $dp->get(Zend_Date::W3C);				
					$id = $atividades->insert ( $dados );
				}else{
					$id = $this->form->getValue('id');
					foreach($atividades->fetchAll("id=".$id, "id") as $atividade){					
						$dados['prazo_data'] = $atividade->prazo_data;
					}
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
			
			$this->_redirect('plano/operacao/operacao_id/'.$atividade->operacao_id);
		}elseif ($id > 0) {
			
			$atividade = $atividades->fetchRow('id='.$id);
			$this->view->atividade = $atividade;
		}
		
		$form->populate($atividade->toArray());
		$this->view->form = $form;
	}    

	
	/**
	 * Adiciona novo prazo na atividade
	 * necessário passar o atividade_id como parametro
	 * @return unknown_type
	 */
	public function addprazoAction() {
		
		$atividades = new Model_Atividades();
		$atividadesprazo = new Model_AtividadesPrazo();
		
		
		$atividade_id = $this->_getParam ( 'id' );
    	
    	$this->form = new Form_AtividadesPrazo();
    	
    	
    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->saveprazoAction();
    		
    	}

    	$atividadeprazo = $atividadesprazo->fetchRow('atividade_id='.$atividade_id, 'id DESC');
    	if($atividadeprazo){
	    		$prazo =  new Zend_Date($atividadeprazo->prazo_data,Zend_Date::ISO_8601);
	    		$atividadeprazo->prazo_data = $prazo->toString('dd/MM/yyyy');
	    		$atividadeprazo->motivopostergacao = '';
	    		
	    		$this->form->populate($atividadeprazo->toArray());
    	} else {
	    	$atividade = $atividades->fetchRow('id='.$atividade_id);
	    	
	    	if($atividade){
	    		$prazo =  new Zend_Date($atividade->prazo_data,Zend_Date::ISO_8601);
	    		$atividade->prazo_data = $prazo->toString('dd/MM/yyyy');
	    		 
	    		$this->form->populate($atividade->toArray());
	    	}else{
	    		$this->_redirect('error/naoexiste');
	    	}
    	}    	
    	
    	$this->view->form = $this->form;
    	$this->form->getElement('atividade_id')->setValue($atividade_id);
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->atividade);
    		
    	}else{
    		$this->render('addprazo');
    	}
	}

	/**
	 * Adiciona nova vinculação na atividade
	 * necessário passar o atividade_id como parametro
	 * @return unknown_type
	 */
	public function addvinculacaoAction() {
		
		$atividades = new Model_Atividades();
		$atividadesvinculacao = new Model_AtividadesVinculadas();

		$atividade_id = $this->_getParam ( 'id' );
    	
    	$this->form = new Form_AtividadesVinculacao();

    	if ($this->getRequest ()->isPost ()) 
    	{
    		$this->savevinculacaoAction();
    	}
    	
    	$atividade = $atividades->fetchRow('id='.$atividade_id);
    	
    	$this->view->form = $this->form;
    	$this->form->getElement('atividade_id')->setValue($atividade_id);
    	
    	if ($this->_request->isXmlHttpRequest()) {
                $this->_helper->layout()->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
               	echo $this->getXml($this->view->atividade);
    		
    	}else{
    		$this->render('addvinculacao');
    	}
    	
	}
	
    /*
     * Controller para Salvar os novas vinculações das atividades
     */
    public function savevinculacaoAction()
    {
    	$this->form = new Form_AtividadesVinculacao();
    	$this->view->form = $this->form;
    	
    	if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$dados = $this->form->getDados ();
				$atividades = new Model_Atividades();
				$resultado = $atividades->fetchRow('id='.$dados["depende_atividade_id"]);
				if (!$resultado)
				{
					$this->form->getElement('depende_atividade_id')->setValue($dados['depende_atividade_id']);
					$this->form->getElement('observacoes')->setValue($dados['observacoes']);
					$this->view->erro = "não existe";
				} else {			
					$atividadesvinculacao = new Model_AtividadesVinculadas ( );
					$id = $atividadesvinculacao->insert ( $dados );
					$this->_redirect('plano/atividade/atividade_id/'.$dados['atividade_id']);
				}
			}else{
				$this->form->populate ( $formData );
			}
		}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $this->getXml($this->view->atividade);
    	}else{
    		$this->render('addvinculacao');
    	}
    }
	
    /*
     * Controller para excluir as vinculações das atividades
     */
    public function deletevinculacaoAction()
    {
		$id = $this->_getParam('id', 0);
		$atividade_id = $this->_getParam('atividade_id', 0);
    	$atividadesvinculacao = new Model_AtividadesVinculadas ( );
    	$atividadesvinculacao->delete ( $id );
    	$this->_redirect('plano/atividade/atividade_id/'.$atividade_id);
    }
    
    
    
    
    /*
     * Controller para Salvar os novos prazos das atividades
     */
    public function saveprazoAction()
    {
    	$this->form = new Form_AtividadesPrazo();
    	$this->view->form = $this->form;
    	
    	if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$dados = $this->form->getDados ();
				$atividadesprazo = new Model_AtividadesPrazo ( );
				$dp = new Zend_Date($dados['prazo_data']);
				$dados['prazo_data'] =  $dp->get(Zend_Date::W3C);				
				$id = $atividadesprazo->insert ( $dados );
				$this->_redirect('plano/atividade/atividade_id/'.$dados['atividade_id']);
			}else{
				$this->form->populate ( $formData );
			}
		}
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $this->getXml($this->view->atividade);
    	}else{
    		$this->render('addprazo');
    	}
    }		

    /*
     * Controller para Concluir Atividades
     */
    public function concluirAction()
    {
    	$atividades = new Model_Atividades();
    	$dataatual = new Zend_Date();
    	$databanco = $dataatual->get(Zend_Date::W3C);
		$atividade_id = $this->_getParam ( 'id' );
		$dados = array("conclusao_data" => $databanco);
		$atividades->update($dados, 'id='.$atividade_id);
		$this->_redirect('plano/atividade/atividade_id/'.$atividade_id);
    }
    
    /*
     * Controller para Reativar Atividades
     */
    public function reativarAction()
    {
    	$atividades = new Model_Atividades();
		$atividade_id = $this->_getParam ( 'id' );
		$dados = array("conclusao_data" => null);
		$atividades->update($dados, 'id='.$atividade_id);
		$this->_redirect('plano/atividade/atividade_id/'.$atividade_id);
    }
    
    
    
	// Passando data do text box "DD/MM/AAAA" para "AAAA-MM-DD"
	function gravaData ($data) {
		if ($data != '') {
			$dt = split('/',$data);
		   return ($dt[2].'/'.$dt[1].'/'.$dt[0]);
		}
		else { return ''; }
	}	
}



