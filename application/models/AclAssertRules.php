<?php

/**
 * AclAssertRules
 * 
 * @author Elan
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_AclAssertRules extends Zend_Db_Table_Abstract {
	
	protected $_auth = null;
	protected $_db = null;
	public $_setorChefia = array ();
	public $_cargo;
	public $_chefe = false;
	
	public function __construct($config) {
		
		$this->_auth = Zend_Auth::getInstance ();
		$this->_db = Zend_Registry::get ( 'db' );
		if ($this->_auth->hasIdentity ()) {
			$id = $this->_auth->getIdentity ()->id;
			$this->_cargo = $this->setCargo ( $id );
			$this->setSetor ( $id );
			$this->setChefia ( $this->_setorChefia );
		}
	
	}
	public function setCargo($id = 0) {
		$select = $this->_db->select ();
		$select->from ( 'cargo_usuarios' )->where ( 'usuario_id = ' . $id );
		$stmt = $this->_db->query ( $select );
		$stmt->setFetchMode ( Zend_Db::FETCH_OBJ );
		$cargo = $stmt->fetch ();
		return ($cargo) ? $cargo->cargo_id : 0;
	}
	
	
	public function setSetor($id = 0) {
		$select = $this->_db->select ();
		$select->from ( 'setor_usuarios' )->where ( 'situacao_id = 1' )->where ( 'usuario_id = ' . $id );
		$stmt = $this->_db->query ( $select );
		$stmt->setFetchMode ( Zend_Db::FETCH_OBJ );
		$setor = $stmt->fetch ();
		$setor_id = ($setor) ? $setor->setor_id : 0;
		/*
		 * pega os setores filhos
		 * 
		 */
		if ($setor_id != 0) {
			$this->_setorChefia[] = $setor_id;
			
			$sql = "WITH RECURSIVE setores_fihos(id) AS (
					SELECT id, nome, setor_id FROM setores WHERE id = ? and situacao_id = 1
					UNION
					SELECT fs.id, fs.nome, fs.setor_id FROM setores fs, setores_fihos
					WHERE setores_fihos.id = fs.setor_id)
					SELECT * FROM setores_fihos" ;
			$stmt = $this->_db->query($sql,$setor_id);
			$stmt->setFetchMode ( Zend_Db::FETCH_OBJ );
			while ($setor = $stmt->fetch()){
				$this->_setorChefia[] = $setor->id;
			}
		}
	}
	
	public function setChefia($setores) {
		$aux = array();
		if (is_array ( $setores )) {
			foreach ( $setores as $setor ) {
				$select = $this->_db->select ();
				$select->from ( 'setor_chefias' )->where ( 'situacao_id = 1' )->where ( 'setor_id = ' . $setor );
				$stmt = $this->_db->query ( $select );
				$stmt->setFetchMode ( Zend_Db::FETCH_OBJ );
				$chefia = $stmt->fetch ();
				$aux = array();
				if ($chefia) {
					if ($chefia->usuario_id == $this->_auth->getIdentity ()->id)
						$this->_chefe = array($setor=> $chefia->usuario_id);
					$aux [$setor] = $chefia->usuario_id;
				}
			
			}
		
		}
		$this->_setorChefia = $aux;
	}

}
