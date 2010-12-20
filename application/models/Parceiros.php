<?php
/**
 * Parceiros
 *  
 * @author marcone
 * @version 
 */
class Model_Parceiros extends App_DefaultModel 
{
	protected $_name = 'parceiros';
	protected $_dependentTables = array('Model_Parcerias');
	
	public function init(){
		parent::init();
		$this->_schema = "public";
	}		
}

