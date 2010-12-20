<?php
/**
 * @author Marcone Costa
 * @version 
 */
class Model_TiposParcerias extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'tipos_parcerias';
	protected $_dependentTables = array('Model_ParceriaTipos');	

	public function init(){
		parent::init();
		$this->_schema = "public";
	}		

}

