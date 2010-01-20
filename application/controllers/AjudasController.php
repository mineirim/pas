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

		$caminho = "";
		$pagina = "";
		$parametros = $this->_getAllParams();
		$montar = 0;
		foreach($parametros as $parametro => $valor)
		{
			if ($parametro == "module"){
				$montar = 0;
			}
			if ($montar == 1){
				$caminho = $parametro . "/" . $valor . "/";	
				$pagina = $parametro;			
			}
			if ($parametro == "action"){
				$montar = 1;
			}
		}

		$pagina = str_replace("_id", "", $pagina);
		if ($pagina == "objetivo_especifico"){
			$pagina = "objetivos-especificos";
		}
		if ($pagina == "programa"){
			$pagina = "programas";
		}

		
		$ajudas = new Model_Ajudas ( );
		$ajuda = $ajudas->fetchRow("pagina='".$pagina."'");
		if ($ajuda){
			$this->form->populate($ajuda->toArray());
		} else {
	    	$this->form->getElement('pagina')->setValue($pagina);
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

				$variavel = $dados['pagina'] . "_id";
				if ($dados['pagina'] == "objetivos-especificos"){
					$variavel = "objetivo_especifico_id";
				}
				if ($dados['pagina'] == "programa"){
					$variavel = "programa_id";
				}
				$id = $this->_getParam ( $variavel, 0 );
				$this->_redirect('plano/' . $dados['pagina'] . '/' . $variavel . '/' . $id);
			} else {
				$this->form->populate ( $formData );
			}
    	}
	}

}

?>