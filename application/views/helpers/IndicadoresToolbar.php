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
	public function indicadoresToolbar( Zend_Db_Table_Row_Abstract  $obj, $controller='programas', $type='top', $id = false)
	{
		
		$this->_indicador = $obj;
		
		$acao = $this->_indicador->tipo_indicador_id==1 ? "configurar":"configurarqualitativos";
		
		$toolbar = ""; 

		$f = Zend_Controller_Front::getInstance();
		
		$session = new Zend_Session_Namespace('back_indicador');
		$session->url = $f->getRequest()->getPathInfo();
		
		
		
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
			
		$toolbar = "<div style='width:80px;'>
						<a href='". $this->view->url(array(	'controller'=>'indicadores',
															'action'=>'edit', 
															'module'=>'programacao',
															'id'=>$this->_indicador->id))."'
						class='my-button ui-state-default ui-corner-all ajax-form-load'
						title='Editar'>
						<span class='ui-icon ui-icon-pencil ajax-form-load'></span>
					</a>";
		
		
		if($acl->isAllowed($role,$resource,'editar') ||	!$resource)
		{
			/**
			 * removido por não haver mais necessidade, pois a configuração está junto com a edição
			 */
			/*$toolbar .=  "<a href='".$this->view->url(array('controller'=>'indicadores',
															'action'=>'configurar',
															'module'=>'programacao',
															'id'=>$this->_indicador->id))."'
							class='my-button ui-state-default ui-corner-all  ajax-form-load'
							title='Configurar'	>
							<span class='ui-icon ui-icon-wrench '></span>
						 </a>";*/
			
			$toolbar .=  "<a href='".$this->view->url(array('controller'=>'indicadores',
															'action'=>'delete', 
															'module'=>'programacao',
															'id'=>$this->_indicador->id))."'
							class='my-button ui-state-default ui-corner-all ajax-form-load'
							title='Exclusão permanente'	>
							<span class='ui-icon ui-icon-trash'></span>
						 </a>";
		}
		$toolbar .="</div>";
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
