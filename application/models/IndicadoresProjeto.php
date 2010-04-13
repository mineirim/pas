<?php

/**
 * IndicadoresProjeto
 *  
 * @author Marcone Costa
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_IndicadoresProjeto extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'indicadores_projeto';

	protected $_referenceMap = array (
	                     		'Projeto' => array ( 'columns' => 'projeto_id', 
	                     							  'refTableClass' => 'Model_Projetos', 
	                     							  'refColumns' => 'id' ),
								'Indicador' => array('columns' => 'indicador_id', 
	                     							  'refTableClass' => 'Model_Indicadores', 
	                     							  'refColumns' => 'id',
	                     							  'onDelete' => self::SET_NULL)
								);	
	
}
