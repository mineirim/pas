<?php
class App_Myacl extends Zend_Acl {
	protected $_context = array ();
	private $_user = "guest";
	private $_grupos = array();
	private $_paginas;
	public function __construct(Zend_Auth $auth) {
		
		
		$assert = new App_Acl_Assert_Controllers();
		/**
		 * verifica se existe usuário autenticado e aplica as regras
		 */
		
		
		if($auth->getIdentity()){
			$users = new Model_Usuarios();
			$this->_user = $users->fetchRow("id=".$auth->getIdentity()->id);
			
			$userrole = new Zend_Acl_Role ( $this->_user->username );
			$this->addRole ( $userrole );
			$usuariosgrupos = $this->_user->findManyToManyRowset('Model_Grupos','Model_UsuariosGrupos');
			foreach( $usuariosgrupos as $grp ){
				$this->_grupos[]=$grp->id;
				//se pertence ao grupo de administradores então tem permissão para qualquer função do sistema
				if($grp->id==1){
					$this->add(new Zend_Acl_Resource('admin'));
					$this->allow($userrole,'admin');
					return;
				}
			}
		}else{
			$this->addRole (new Zend_Acl_Role ( 'guest'));
			$grupos = new Model_Grupos();
			$grupo = $grupos->fetchRow("grupo='anonimo'");
			$this->_grupos[]=$grupo->id;
		}
			
			

	/**
	 * 
	 * adiciona todas as páginas com alguma restrição
	 */	
		
		$db = Zend_Registry::get('db');
		$select = $db->select()->distinct();
		$select->from('paginas',array('pagina'));
	    $select->order(array('pagina'));
	    
	    
	    $stmt = $db->query($select);
	    $stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		$paginas = $stmt->fetchAll();		
		
		foreach($paginas as $pagina) {
			$this->add ( new Zend_Acl_Resource($pagina->pagina) );
		}
		$paginas = null;
			
		
		
		$select = $db->select()->distinct();
		
		$select->from(array('gp'=> 'grupos_permissoes'), array('pagina_id'))
					  ->joinLeft(array('p'=>'paginas'), 'gp.pagina_id=p.id', array('id','pagina','acao'));
	    $select->where('"gp".grupo_id in ('.implode(",",$this->_grupos).')');
	    $select->order(array('pagina','acao'));
	    
	    
	    $stmt = $db->query($select);
	    
	    $stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		$paginas = $stmt->fetchAll();
		
		foreach($paginas as $pagina){
			
			$pg=strlen($pagina->pagina)>1 ? $pagina->pagina : null;
			
			
			$ac = strlen($pagina->acao)>0? $pagina->acao:null;
			$this->allow ( $userrole, $pg, $ac, $assert);
			
		
			/**
			 * pega todos as funções da ação atual
			 * ex: o privilégio de editar tem as seguintes funções no sistema: edit, addmeta... etc
			 */
			
				
			$select = $db->select();
			$select->from(array('af'=> 'acao_funcoes'), array('funcao_id'))
					  ->joinLeft(array('f'=>'funcoes'), 'af.funcao_id=f.id', array('funcao'));
			$select->where('"af".pagina_id in ('.$pagina->id.')');
		    $stmt = $db->query($select);
		    $stmt->setFetchMode(Zend_Db::FETCH_OBJ);
			$funcoes = $stmt->fetchAll();
			foreach ($funcoes as $funcao){
				$ac=strlen($funcao->funcao)>1 ? $funcao->funcao : null;
				$this->allow ( $userrole, $pg, $ac, $assert);
			}
			
			
		}
		
	}
	
	public function setContextArray($context = array()) {
		$this->_context = $context;
	}
	public function getContextArray() {
		return $this->_context;
	}
	public function setContextValue($key, $value = null) {
		$this->_context [$key] = $value;
	}
	public function getContextValue($key) {
		if (isset ( $this->_context [$key] )) {
			return $this->_context [$key];
		} else {
			throw new Zend_Acl_Exception ( 'Context value [' . $key . '] not set' );
		}
	}	
	
	public function issetContextValue($key) {
		if (isset ( $this->_context [$key] )) {
			return true;
		} else {
			return false;
		}
	}		
	
}

