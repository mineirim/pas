<?php

class Model_ParceriaTipos extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_order = 'id';
	protected $_name = 'parceria_tipos';
	protected $_referenceMap = array (
	                     		'Tipos' => array ( 'columns' => 'tipo_parceria_id', 
	                     							  'refTableClass' => 'Model_TiposParcerias', 
	                     							  'refColumns' => 'id' ),
								'Parcerias' => array ( 'columns' => 'parceria_id', 
	                     							  'refTableClass' => 'Model_Parcerias', 
	                     							  'refColumns' => 'id' ) 							
	
								);	

	
	public function insert($dados){
		$auth = Zend_Auth::getInstance();
		$dados['inclusao_usuario_id']= $auth->getIdentity()->id;
		return parent::insert($dados);
	}

}

