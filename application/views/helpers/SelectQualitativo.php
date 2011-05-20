<?php
/**
 *
 * @author elan
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Altera Status Qualitativo
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
	 * @param $module
         * @param $id
	 * @return String $selectquali
	 */
	public function selectQuali($controller='indicadores', $module='programacao', $id = false) {
		
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

						
			$selectquali = "<div class=\"select-quali\" style=\"clear:both;\"></div>
						<input type=\"select\" style=\"width:100%;\"";
						
		}
		
		return $selectquali;
	}
}