<?php

/**
 * IndicadoresPrograma
 *  
 * @author Marcone Costa
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_IndicadoresMeta extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'indicadores_meta';

	protected $_referenceMap = array (
	                     		'Meta' => array ( 'columns' => 'meta_id',
                                                          'refTableClass' => 'Model_Metas',
                                                          'refColumns' => 'id' ),
                                        'Indicador' => array('columns' => 'indicador_id',
                                                          'refTableClass' => 'Model_Indicadores',
                                                          'refColumns' => 'id' ,
                                                          'onDelete' => self::CASCADE)
                                        );
	
}
