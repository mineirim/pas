<?php

/**
 * AtividadesVinculadas
 *  
 * @author hugo
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_AtividadesVinculadas extends App_DefaultModel {

	
	/**
	 * The default table name 
	 */
	
	
	protected $_name = 'pas2011.atividades_vinculadas';
	
	protected $_referenceMap = array (
	                     		'Atividades' => array ( 'columns' => 'atividade_id', 
	                     							  'refTableClass' => 'Model_Atividades', 
	                     							  'refColumns' => 'id' ),
								'Referencias' => array ( 'columns' => 'depende_atividade_id', 
	                     							  'refTableClass' => 'Model_Atividades', 
	                     							  'refColumns' => 'id' )					
								);	
	
	public function update($dados, $where){
		
		$auth = Zend_Auth::getInstance();
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_data']=date('Y/m/d h:i:s', time());

		
		return parent::update($dados,$where);
		
	}
	public function insert($dados){
		
		$auth = Zend_Auth::getInstance();
		$dados['inclusao_usuario_id']= $auth->getIdentity()->id;
		$dados['inclusao_data']= date('Y/m/d h:i:s', time());

		return parent::insert($dados);
	}
	
}

?>