<?php
class App_Controller_AjudaPlugin extends Zend_Controller_Plugin_Abstract {
	
	public function __construct() {
		
	}
	
	public function preDispatch(Zend_Controller_Request_Http $request) {
		$ajudas = new Model_Ajudas();
		$cont = $request->getControllerName();
		$act = $request->getActionName();
		$ajuda = $ajudas->fetchRow("pagina='$cont' AND acao='$act'");
		
		$request->setParam('textoajuda',$ajuda->textoajuda);
		
	}

	
}
