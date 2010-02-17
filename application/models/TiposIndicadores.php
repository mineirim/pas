<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_TiposIndicadores extends App_DefaultModel {

	protected $_name = 'public.tipos_indicadores';
	
	//protected $_primary = array('id');
	public function init(){
		parent::init();
		$this->_schema = "public";
	}			
	
	
	protected $_dependentTables = array('Model_Indicadores'); 
	
	

}


