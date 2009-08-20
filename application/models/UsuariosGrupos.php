<?php

/**
 * UsuariosGrupos
 *  
 * @author PS00051
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_UsuariosGrupos extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'usuarios_grupos';
	protected $_referenceMap = array (
	                     		'Usuarios' => array ( 'columns' => 'usuario_id', 
	                     							  'refTableClass' => 'Model_Usuarios', 
	                     							  'refColumns' => 'id' ) ,
								'Grupos' => array ( 'columns' => 'grupo_id', 
	                     							  'refTableClass' => 'Model_Grupos', 
	                     							  'refColumns' => 'id' ) 							
								);

}
