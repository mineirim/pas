<?php

/**
 * IndicadoresPrograma
 *  
 * @author Marcone Costa
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_IndicadoresPrograma extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'indicadores_programa';

	protected $_referenceMap = array (
	                     		'Programa' => array ( 'columns' => 'programa_id', 
	                     							  'refTableClass' => 'Model_Programas', 
	                     							  'refColumns' => 'id' ),
								'Indicador' => array('columns' => 'indicador_id', 
	                     							  'refTableClass' => 'Model_Indicadores', 
	                     							  'refColumns' => 'id' )
								);	
	
}
