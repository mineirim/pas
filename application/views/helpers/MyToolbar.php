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
		$divsini = '	<div class="fg-toolbar ui-widget-header ui-corner-all ui-helper-clearfix">
							<div class="fg-buttonset ui-helper-clearfix">';
		$divsfim ='			</div>
						</div>';
		$toolbar = "<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'add'))."'
					title='Novo' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all'>
					<span class='ui-icon ui-icon-document'>Novo</span>Novo</a>";
		
		
		
		$ret = $divsini.$toolbar.$divsfim;
		return $ret;
	}
	private function getLineBar(){
		
		$toolbar = "
		<div style='width:55px;'>
		<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'edit','id'=>$this->_id))."'
					class='my-button ui-state-default ui-corner-all '
					title='Editar' 
					
					>
					<span class='ui-icon ui-icon-pencil '>ssss</span>
					</a>
		<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'delete','id'=>$this->_id))."'
		class='my-button ui-state-default ui-corner-all '
		title='Excluir' 
		
		>
		<span class='ui-icon ui-icon-trash '>ssss</span>
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
