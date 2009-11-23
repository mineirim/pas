<?php

/**
 * Projetos
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_IndicadoresConfiguracoes extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_order = 'id';
	protected $_name = 'public.indicador_configuracoes';
	protected $_referenceMap = array (
	                     		'Indicadores' => array ( 'columns' => 'indicador_id', 
	                     							  'refTableClass' => 'Model_Indicadores', 
	                     							  'refColumns' => 'id' ),
								'TiposPeriodos' => array ( 'columns' => 'tipo_periodo_id', 
	                     							  'refTableClass' => 'Model_TiposPeriodos', 
	                     							  'refColumns' => 'id' ) 							
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


