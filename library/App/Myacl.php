<?php
class App_Myacl extends Zend_Acl {
	
	private $_user = "guest";
	private $_grupos = array();
	private $_paginas;
	public function __construct(Zend_Auth $auth) {
		
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
			}
		}else{
			$this->addRole (new Zend_Acl_Role ( 'guest'));
			$grupos = new Model_Grupos();
			$grupo = $grupos->fetchRow("grupo='anonimo'");
			$this->_grupos[]=$grupo->id;
		}
			
			
		
		$select = $db->select()->distinct();
		
		$select->from(array('gp'=> 'grupos_permissoes'), array('id'))
					  ->joinLeft(array('p'=>'paginas'), 'gp.pagina_id=p.id', array('pagina','acao'));
	    $select->where('"gp".grupo_id in ('.implode(",",$this->_grupos).')');
	    $select->order(array('pagina','acao'));
	    
	    
	    $stmt = $db->query($select);
	    $stmt->setFetchMode(Zend_Db::FETCH_OBJ);
		$paginas = $stmt->fetchAll();
	    
		
		foreach($paginas as $pagina){
			$pg=strlen($pagina->pagina)>1 ? $pagina->pagina : null;
			$ac=strlen($pagina->acao)>1 ? $pagina->acao : null;
			$this->allow ( $userrole, $pg, $ac);
		}
		
		
		
	}
}

