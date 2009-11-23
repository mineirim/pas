<?php

/**
 * UsuariosGrupos
 *  
 * @author PS00051
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_GruposPermissoes extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'public.grupos_permissoes';
	protected $_referenceMap = array (
	                     		'Model_Paginas' => array ( 'columns' => 'pagina_id', 
	                     							  'refTableClass' => 'Model_Paginas', 
	                     							  'refColumns' => 'id' ) ,
								'Model_Grupos' => array ( 'columns' => 'grupo_id', 
	                     							  'refTableClass' => 'Model_Grupos', 
	                     							  'refColumns' => 'id' ) 							
								);

	public function init(){
		parent::init();
		$this->_schema = "public";
	}									
								
}
