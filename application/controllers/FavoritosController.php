<?php

class FavoritosController extends Zend_Controller_Action {
	
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('validar', 'json')
        			->addActionContext('add',array('json','xml'))
                    ->initContext();    	
        /* Initialize action controller here */
    	
		
	}
	
	/**
	 * Adiciona favorito
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
		$favoritos = new Model_Favoritos ( );
		$favoritos->insert ($caminho);
		$pagina = str_replace("_id", "", $pagina);
		if ($pagina == "objetivo_especifico"){
			$pagina = "objetivos-especificos";
		}
		if ($pagina == "programa"){
			$pagina = "programas";
		}
		$caminho = "plano/" . $pagina . "/" . $caminho;
		$this->_redirect($caminho);
	}
	
	/*
	 * Visualiza Favoritos
	 */
	public function listAction(){
		$auth = Zend_Auth::getInstance();
		$favoritos = new Model_Favoritos();
		$usuario_id = $auth->getIdentity()->id;
		$this->view->favoritos = $favoritos->fetchAll("usuario_id=". $usuario_id);
		$this->view->programas = new Model_Programas();
		$this->view->projetos = new Model_Projetos();
		$this->view->objetivosespecificos = new Model_ObjetivosEspecificos();
		$this->view->metas = new Model_Metas();
		$this->view->operacoes = new Model_Operacoes();
		$this->view->atividades = new Model_Atividades();
		$this->render('list'); 
	}

}



