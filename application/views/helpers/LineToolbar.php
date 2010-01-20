<?php
/**
 *
 * @author marcone
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * LineToolbar helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_LineToolbar {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	private $_controller;
	private $_obj;
	private $_model;
	
	/**
	 *  
	 */
	public function lineToolbar($controller, Zend_Db_Table_Row_Abstract  $obj)
	{
		
		$this->_controller = $controller;
		$this->_obj = $obj;

		$classe = explode("_", $this->_obj->getTableClass());
		
				
		$this->_model = $classe[count($classe)-1];
		
		$rowname = substr($controller,0,strlen($controller)-1);
		if(strpos(strtolower($this->_model),strtolower($rowname)) )
			$this->_model = substr($this->_model,0, strlen($this->_model)-strlen($controller));
		
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
			
		
		if($acl->isAllowed($role,$resource,'editar') ||	!$resource)
		{
			$toolbar =$this->getLineToobar(); 
		}
		return $toolbar; 
	}
	private function getLineToobar()
	{
		$id_a = strtolower($this->_model);
		
		$toolbar = "
		<div style='width:55px;'>
		<a href='".$this->view->url(array('controller'=>'search','action'=>'object','id'=>$this->_obj->id,'classe'=>$this->_obj->getTableClass()))."'
					class='my-button ui-state-default ui-corner-all editdescription'
					title='Editar' 
					id='edit-$id_a' 
					>
					<span class='ui-icon ui-icon-pencil '></span>
					</a>
		<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'delete'.strtolower($this->_model),'id'=>$this->_obj->id))."'
		class='my-button ui-state-default ui-corner-all editdescription '
		title='Excluir' 
		id='edit-$id_a'
		>
		<span class='ui-icon ui-icon-trash '></span>
		</a>
		</div>
		";
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
