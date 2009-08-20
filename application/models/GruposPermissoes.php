<?php

/**
 * UsuariosGrupos
 *  
 * @author PS00051
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_GruposPermissoes extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'grupos_permissoes';
	protected $_referenceMap = array (
	                     		'Model_Paginas' => array ( 'columns' => 'pagina_id', 
	                     							  'refTableClass' => 'Model_Paginas', 
	                     							  'refColumns' => 'id' ) ,
								'Model_Grupos' => array ( 'columns' => 'grupo_id', 
	                     							  'refTableClass' => 'Model_Grupos', 
	                     							  'refColumns' => 'id' ) 							
								);

}
