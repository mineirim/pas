<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_TiposPeriodos extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_order = 'id';
	protected $_name = 'public.tipos_periodos';
	protected $_dependentTables = array('Model_IndicadoresConfiguracoes'); 
	
	

}


