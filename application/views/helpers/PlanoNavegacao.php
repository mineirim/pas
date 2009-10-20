<?php
/**
 *
 * @author marcone
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * PlanoNavegacao helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_PlanoNavegacao {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	private $niveis = array('Programas','Projetos','Subprojetos');
	/**
	 *  
	 */
	public function planoNavegacao( $obj) {

		$classe = explode("_", get_class($obj));
		
		$nivel = $classe[count($classe)-1];
		
		$ini =array_search($nivel,$this->niveis);
		
		$arr_nav=array($this->niveis[$ini]=>$obj->descricao);
		
		
		
		for ($i = $ini-1; $i >0; $i--) {
			$arr_nav[$this->niveis[$i]]=$obj->findParentRow($this->niveis[$i]->descricao);
		}
		
		$ret = "<table class='removedui-widget-header removedui-state-highlight'> ";
		foreach ($arr_nav as $key=>$value)
		{
			$key = substr($key,0,strlen($key)-1);
			
			$ret.= "<tr><th class='ui-widget-header ' width='180px'> $key</th><td >$value</td></tr>";
		}
		$ret .= "</table>";
		
		return  $ret;;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
