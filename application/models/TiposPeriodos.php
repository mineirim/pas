<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_TiposPeriodos extends App_DefaultModel {

	protected $_name = 'public.tipos_periodos';
	
	//protected $_primary = array('id');
	public function init(){
		parent::init();
		$this->_schema = "public";
	}			
	
	
	protected $_dependentTables = array('Model_IndicadoresConfiguracoes'); 
	
	

}


