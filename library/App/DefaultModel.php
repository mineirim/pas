<?php

/**
 * DefaultModel
 *  
 * @author marcone
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class App_DefaultModel extends Zend_Db_Table_Abstract {

	public function init(){
		parent::init();
		$this->_schema = Zend_Registry::get('schema');
	}
	public function update($data, $where)
	{
		$retorno = parent::update($data,$where);
		$log = new Model_Log();
		$data_log = array();
		$data_log['session_id']= session_id();  
  		$data_log['tabela'] = $this->_name;
  		$dados = "<dados>";
  		foreach ($data as $k=>$v)
  		{
  			$dados .= "<$k>$v</$k>";
  		}
  		
  		$dados .= "</dados>";
  		$data_log['dados'] = $dados;
  		$data_log['acao'] = 'update';
  
  		$log->insert($data_log);
  		return $retorno;
	}
	public function insert($data)
	{
		$retorno = parent::insert($data);
		$log = new Model_Log();
		$data_log = array();
		$data_log['session_id']= session_id();  
  		$data_log['tabela'] = $this->_name;
  		$dados = "<dados>";
  		foreach ($data as $k=>$v)
  		{
  			$dados .= "<$k>$v</$k>";
  		}
  		
  		$dados .= "</dados>";
  		$data_log['dados'] = $dados;
  		$data_log['acao'] = 'insert';
  
  		$log->insert($data_log);
  		return $retorno;
	}
	public function delete($where)
	{
		
		
		$objs = $this->fetchAll($where);
		
		$log = new Model_Log();
		$data_log = array();
		$data_log['session_id']= session_id();  
  		$data_log['tabela'] = $this->_name;
  		$dados = "<dados>";
  		$dados .= "<where>$where</where>";
  		$dados .= "<afetados>";
  		
  		foreach($objs as $obj){
  			
  			$data = $obj->toArray();
	  		foreach ($data as $k=>$v)
	  		{
	  			$dados .= "<$k>$v</$k>";
	  		}
  		}
  		$dados .= "</afetados>";
  		$dados .= "</dados>";
  		$data_log['dados'] = $dados;
  		$data_log['acao'] = 'delete';
  
  		$log->insert($data_log);
  		
  		return parent::delete($where);
	}
}

