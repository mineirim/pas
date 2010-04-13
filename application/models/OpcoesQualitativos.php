<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_OpcoesQualitativos extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_order = 'id';
	protected $_name = 'public.opcoes_qualitativos';
	protected $_dependentTables = array('Model_OpcoesQualitativos');
	protected $_referenceMap = array (
	                     		'Indicadores' => array ( 'columns' => 'indicador_id', 
	                     							  'refTableClass' => 'Model_Indicadores', 
	                     							  'refColumns' => 'id',
	                     							  'onDelete' => self::CASCADE 
	)
								);	
	public function init(){
		parent::init();
		$this->_schema = "public";
	}									
								


}


