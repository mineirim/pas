<?php

/**
 * ObjetivosPrograma
 *  
 * @author PS00051
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_ObjetivosPrograma extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'objetivos_programa';

	protected $_referenceMap = array (
	                     		'Programas' => array ( 'columns' => 'programa_id', 
	                     							  'refTableClass' => 'Model_Programas', 
	                     							  'refColumns' => 'id' ));	
	
}
