<?php
/**
 *
 * @author marcone
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * MyToolbar helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_MyToolbar {
	
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
	public function myToolbar($controller='programas', $type='top', $id = false) {
		$this->_controller = $controller;
		$this->_id = $id;
		$toolbar = ""; 
		$mysession = new Zend_Session_Namespace ( 'mysession' );
		$acl = $mysession->acl;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity ()) {
			$role = $auth->getIdentity ()->username;
		} else {
			$role = 'guest';
		}
		$resource = $controller;
		if (! $acl->has ( $resource )) 
			$resource = null;
			
		
		if($acl->isAllowed($role,$resource) ||
					!$resource){ 
			if($type=='top'){
				$toolbar= $this->getTopBar();
			}else{
				$toolbar= $this->getLineBar();
			}
		}
		return $toolbar;
	}
	
	private function getTopBar(){
		$toolbar = "<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'add'))."'>Adicionar</a>";
		return $toolbar;
	}
	private function getLineBar(){
		
		$toolbar = "<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'edit','id'=>$this->_id))."'>Editar</a>";
		return $toolbar ;
		
	}
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
