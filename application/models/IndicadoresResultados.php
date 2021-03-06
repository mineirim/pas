<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_IndicadoresResultados extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_order = 'id';
	protected $_name = 'public.indicadores_resultados';
	protected $_referenceMap = array (
	                     		'IndicadoresConfiguracoes' => array ( 'columns' => 'indicador_configuracao_id', 
	                     							  'refTableClass' => 'Model_IndicadoresConfiguracoes', 
	                     							  'refColumns' => 'id' ,
	                     							  'onDelete' => self::CASCADE) 							
								);	
	public function init(){
		parent::init();
		$this->_schema = "public";
	}									
								
	public function update($dados, $where){
		$auth = Zend_Auth::getInstance();
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_data']=date('Y/m/d h:i:s', time());
		return parent::update($dados,$where);
		
	}
	public function insert($dados){
		$auth = Zend_Auth::getInstance();
		$dados['inclusao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;
		return parent::insert($dados);
	}

}


