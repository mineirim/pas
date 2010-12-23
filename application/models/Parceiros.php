<?php
/**
 * Parceiros
 *  
 * @author marcone
 * @version 
 */
class Model_Parceiros extends App_DefaultModel 
{
	protected $_name = 'parceiros';
	protected $_dependentTables = array('Model_Parcerias');
	
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
		return parent::insert($dados);
	}			
}

