<?php

/**
 * MetasProjeto
 *  
 * @author PS00051
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_ObjetivosProjeto extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'objetivos_projeto';
	protected $_referenceMap = array (
	                     		'Projetos' => array ( 'columns' => 'projeto_id', 
	                     							  'refTableClass' => 'Model_Projetos', 
	                     							  'refColumns' => 'id' ));	
	
}
