<?php
class App_Controller_AjudaPlugin extends Zend_Controller_Plugin_Abstract {
	
	public function __construct() {
		
	}
	
	public function dispatchLoopStartup(Zend_Controller_Request_Http $request) {
        /**
         * passa a variável ajudatexto para a view
         * na view basta chamar $this->ajuda
         */
		$ajudas = new Model_Ajudas();
		$pagina = $request->getControllerName();
		$acao = $request->getActionName();
		Zend_Registry::set('pagina',$pagina);
		Zend_Registry::set('acao',$acao);
		
		$where = "pagina='".$pagina."' AND acao='".$acao."'";
		$ajuda = $ajudas->fetchRow($where);
		if($ajuda){
		  Zend_Registry::set('textoajuda',$ajuda->textoajuda);
		}else{
			Zend_Registry::set('textoajuda','');
		}

	}

	
}
