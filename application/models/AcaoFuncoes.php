<?php

/**  
 * @author Marcone Costa
 *  
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_AcaoFuncoes extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'public.acao_funcoes';
	

	protected $_referenceMap = array (
	                     		'Model_Paginas' => array ( 'columns' => 'pagina_id', 
	                     							  'refTableClass' => 'Model_Paginas', 
	                     							  'refColumns' => 'id' ) ,
								'Model_Funcoes' => array ( 'columns' => 'funcao_id', 
	                     							  'refTableClass' => 'Model_Funcoes', 
	                     							  'refColumns' => 'id' ) 							
								);	
	
	public function init(){
		parent::init();
		$this->_schema = "public";
	}									
	
	
	
}
