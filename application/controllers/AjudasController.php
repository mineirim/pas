<?php

class AjudasController extends Zend_Controller_Action {
	
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('validar', 'json')
        			->addActionContext('add',array('json','xml'))
                    ->initContext();    	
        /* Initialize action controller here */
    	
		$this->form = new Form_Ajudas();		
	}
	
	/**
	 * Adiciona ajuda
	 * 
	 * @return unknown_type
	 */
	public function addAction() {

		
		
		$session = new Zend_Session_Namespace('goback');
		$session->parametros = $this->_request->getUserParams();
		
		
		$pagina = $this->_getParam('pagina');
		$acao = $this->_getParam('acao');
		$ajudas = new Model_Ajudas ( );
		$ajuda = $ajudas->fetchRow("pagina='$pagina' AND acao='$acao'");
		if ($ajuda){
			$this->form->populate($ajuda->toArray());
		} else {
	    	$this->form->getElement('pagina')->setValue($pagina);
	    	$this->form->getElement('acao')->setValue($acao);
		}

		
		$this->view->form = $this->form;
		$this->render('edit');
	}
	
	/*
	 * save
	 * 
	 * Salva (insere ou updata) ajudas.
	 */
	public function saveAction(){
    	$this->view->form = $this->form;		
    	if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$dados = $this->form->getDados ();
				$ajudas = new Model_Ajudas();
				if($this->form->getValue('id')==''){
					$id = $ajudas->insert ( $dados );
				} else {
					$id = $this->form->getValue('id');
					$ajudas->update($dados, 'id='.$id);
				}
				
				$session = new Zend_Session_Namespace('goback');
				$back_to = "";
				foreach($session->parametros as $k=>$v )
				{
					$back_to .= "/$k/$v";
				}
				
				$this->_redirect($dados['pagina'] . '/' . $dados['acao'] . $back_to);
			} else {
				$this->form->populate ( $formData );
			}
    	}
	}

}

?>