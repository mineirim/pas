<?php
/**
 *
 * @author Marcone Costa
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * MyToolbar helper
 * 
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_MyTooltip {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * Retorna uma div com os dados da ajuda do controller/action
	 */
	public function myTooltip() {
		
		
		$this->_textoajuda = Zend_Registry::get('textoajuda');
		$this->_controller = Zend_Registry::get('pagina');
		$this->_action = Zend_Registry::get('acao');
		$tooltip = ""; 
		$mysession = new Zend_Session_Namespace ( 'mysession' );
		$this->acl = $mysession->acl;
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity ()) {
			$this->role = $auth->getIdentity ()->username;
		} else {
			$this->role = 'guest';
		}
		$resource = 'ajudas';
		if (! $this->acl->has ( $resource )) 
			$resource = null;
		
		if($this->role=='guest' && !$this->acl->hasRole('guest'))
			$this->acl->addRole('guest');
		
		
		
		if($this->acl->isAllowed($this->role,$resource,'editar') ||
					!$resource){ 
				$tooltip= $this->getTooltip();
			
		}
		return $tooltip;
	}
	
	private function getTooltip(){
		
		
		$tooltip = "<div class='tooltip' style='position: absolute; top: 0px; right: 0px; width: 35px;'
						title='".$this->_textoajuda."'>
			
			<a class='tooltip' alt='".$this->_textoajuda."' href='". $this->view->url(array('controller'=>'ajudas','action'=>'add', 'pagina'=>$this->_controller,'acao'=>$this->_action))."'>
					<img 
						src='".$this->view->baseUrl() ."/images/seehelp.jpg' width='28' height='28' border='0'
					>
			</a>
			</div>
		";
		
		
		
		return $tooltip ;
		
	}
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
