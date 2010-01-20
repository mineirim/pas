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
	
	
	protected $_name = 'atividades_vinculadas';
	protected $_referenceMap = array (
	                     		'Atividades' => array ( 'columns' => 'atividade_id', 
	                     							  'refTableClass' => 'Model_Atividades', 
	                     							  'refColumns' => 'id' )					
								);	
	public function update($dados, $where){
		return parent::update($dados,$where);
	}
	public function insert($dados){
		return parent::insert($dados);
	}
	public function delete($id){
		return parent::delete("id=".$id);
	}

}

?>