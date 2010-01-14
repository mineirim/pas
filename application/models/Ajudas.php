<?php

/**
 * Grupos
 *  
 * @author Marcone Costa
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Ajudas extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'public.ajudas';
	protected $_primary='id';
	

	public function init(){
		parent::init();
		$this->_schema = "public";
	}									
	
	
	
    public function insert(array $dados, array $grupos) {
		
		$auth = Zend_Auth::getInstance();
		$dados['inclusao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;
	    $id = parent::insert($dados);
    }
    
    public function update(array $dados, array $grupos, $where) {
		$auth = Zend_Auth::getInstance();
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_data']=date('Y/m/d h:i:s', time());
    	
    	parent::update($dados, $where);
    	   	   	    	
    }		

}
