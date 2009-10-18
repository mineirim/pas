<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_TiposPeriodo extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_order = 'id';
	protected $_name = 'tipos_periodo';
	protected $_dependentTables = array('Model_IndicadoresConfigs'); 
	
	

}


