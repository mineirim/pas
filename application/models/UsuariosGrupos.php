<?php

/**
 * UsuariosGrupos
 *  
 * @author PS00051
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_UsuariosGrupos extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'public.usuarios_grupos';
	protected $_referenceMap = array (
	                     		'Usuarios' => array ( 'columns' => 'usuario_id', 
	                     							  'refTableClass' => 'Model_Usuarios', 
	                     							  'refColumns' => 'id' ) ,
								'Grupos' => array ( 'columns' => 'grupo_id', 
	                     							  'refTableClass' => 'Model_Grupos', 
	                     							  'refColumns' => 'id' ) 							
								);

								
	public function init(){
		parent::init();
		$this->_schema = "public";
	}									
}
