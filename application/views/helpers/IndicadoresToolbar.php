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
class Zend_View_Helper_IndicadoresToolbar {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	private $_indicador;
	private $_model;
	
	/**
	 *  
	 */
	public function indicadoresToolbar( Zend_Db_Table_Row_Abstract  $obj)
	{
		
		$this->_indicador = $obj;

		
		$toolbar = ""; 

		
		$acl = Zend_Registry::get('acl');
		$auth = Zend_Auth::getInstance();
		
		if ($auth->hasIdentity ()) {
			$role = $auth->getIdentity ()->username;
		} else {
			$role = 'guest';
		}
		$resource = 'indicadores';
		if (! $acl->has ( $resource )) 
			$resource = null;
			
		$toolbar = "<div style='width:55px;'>
						<a href='". $this->view->url(array('controller'=>'indicador','action'=>'show','id'=>$this->_indicador->id))."'
						class='my-button ui-state-default ui-corner-all '
						title='Visualizar'>
						<span class='ui-icon ui-icon-info'></span>
					</a>";
		
			
		if($acl->isAllowed($role,$resource,'editar') ||	!$resource)
		{
			$toolbar .=  "<a href='".$this->view->url(array('controller'=>'indicadores','action'=>'configurar','indicador_id'=>$this->_indicador->id))."'
							class='my-button ui-state-default ui-corner-all '
							title='Editar'	>
							<span class='ui-icon ui-icon-wrench '></span>
						 </a>";
		}
		$toolbar .="</div";
		return $toolbar; 
	}

	
				
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
