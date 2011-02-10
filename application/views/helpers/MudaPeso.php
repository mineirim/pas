<?php
/**
 *
 * @author elan
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * MyToolbar helper
 * 
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_MudaPeso {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * Retorna uma toolbar com operações disponíveis para o registro
	 * @param $controller
	 * @param $type top ou line
	 * @return String $toolbar
	 */
	public function mudaPeso($controller='programas', $id = false, $peso = false) {
		
		$barrapeso = $peso;
		
		$this->_controller = $controller;
		$this->_id = $id;
		$mysession = new Zend_Session_Namespace ( 'mysession' );
		$this->acl = $mysession->acl;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity ()) {
			$this->role = $auth->getIdentity ()->username;
		} else {
			$this->role = 'guest';
		}
		$resource = $controller;
		if (! $this->acl->has ( $resource )) 
			$resource = null;
		
		$this->res = $resource;	

		if($this->role=='guest' && !$this->acl->hasRole('guest'))
			$this->acl->addRole('guest');
		
		
			
		if($this->acl->isAllowed($this->role,$resource,'editar') ||
					!$resource ){ 

						
			$barrapeso = "<div class=\"slider-peso\" style=\"clear:both;\"></div>
						<input type=\"text\" value=\"$peso\" id=\"$id\"/ style=\"width:100%;\" class=\"text ui-widget-content ui-corner-all\">";
						
		}
		
		return $barrapeso;
	}
}