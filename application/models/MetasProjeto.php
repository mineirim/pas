<?php

/**
 * MetasProjeto
 *  
 * @author PS00051
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_MetasProjeto extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'metas_projeto';
	protected $_referenceMap = array (
	                     		'Projetos' => array ( 'columns' => 'projeto_id', 
	                     							  'refTableClass' => 'Model_Projetos', 
	                     							  'refColumns' => 'id' ));	
	
}
