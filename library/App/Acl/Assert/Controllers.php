<?php

require_once ('Zend/Acl/Assert/Interface.php');

/** 
 * @author marcone
 * 
 * 
 */

class App_Acl_Assert_Controllers implements Zend_Acl_Assert_Interface {
	public $_acl;
	public $_auth;
	public $_aclassertrules;
	public $_grupos;
	public $_gruposPrograma = array(1,10);
	public $_contextos = array ('programa' => array('modelo'=>'Programas', 'parent'=>null),
								'projeto' => array('modelo'=>'Projetos', 'parent'=>'programa'),
								'objetivo-especifico' => array('modelo'=>'ObjetivosEspecificos','parent'=>'projeto'),
								'meta' => array('modelo'=>'Metas', 'parent'=>'objetivo-especifico'), 
								'operacao' => array('modelo'=>'Operacoes',  'parent'=>'meta'));
	
	/**
	 * @param Zend_Acl $acl
	 * @param Zend_Acl_Role_Interface $role
	 * @param Zend_Acl_Resource_Interface $resource
	 * @param unknown_type $privilege
	 */
	public function assert(	Zend_Acl $acl, 
							Zend_Acl_Role_Interface $user = null, 
							Zend_Acl_Resource_Interface $resource = null, 
							$privilege = null) {
		
		

		if (! $user instanceof Zend_Acl_Role_Interface) {
			throw new Exception ( __CLASS__ . '::' . __METHOD__ . ' expects the role to be' . ' an instance of Usuario' );
		}
		
		if (! $resource instanceof Zend_Acl_Resource_Interface) {
			throw new Exception ( __CLASS__ . '::' . __METHOD__ . ' expects the resource to be' . ' an instance of Zend_Controller_Action' );
		}
		


		/**
		 * coisas que influenciam nas permissões do usuário
		 * se é chefe imediato ou indireto
		 * se é o responsável direto pelo objeto
		 * se é do mesmo setor e a permissão foi explicitada(deverá ser criada uma função que explicíta que todos os usuários do setor podem fazer alterações)
		 * se é administrador pode tudo 
		 */

		$mysession = new Zend_Session_Namespace ( 'mysession' );
		$this->_grupos = $mysession->__get('grupos');
		
		
		$this->_auth = Zend_Auth::getInstance ();
		$this->_acl = $acl;
		$this->_aclassertrules = Zend_Registry::get ( 'aclAssetRules' );
		
		if (! $this->_auth->hasIdentity ()) {
			return false;
		}
		return $this->verificaPermissoes($resource);
	}
	/**
	 * 
	 * Verifica Permissões do usuário logado baseado na action
	 * do contexto.
	 * 1 - programa
	 * 2 - projeto
	 * 3 - objetivo-especifico
	 * 4 - meta
	 * 5 - operacao
	 * 6 - atividade
	 */
	
	public function verificaPermissoes($resource = NULL) 
	{
		if ($this->_acl->getContextValue('controller') == 'instrumentos') {
			$resource = $this->_acl->getContextValue('action');
			if ($resource == 'index'){
				foreach ($this->_grupos as $grupo) {
					if (in_array($grupo, $this->_gruposPrograma))
						return true;
				} 
				return  false;
			} else {
				$id = $this->_acl->getContextValue(str_replace('-','_',$resource).'_id');
				if ($resource == 'atividade'):
					$return = $this->verificaAtividade($id,$resource);
				else:
					$return = $this->verificaPermissao($id,$resource);	
				endif;
			
			};
		} else {
			return  true;
		}
		return $return;
	}
	
	/**
	 * verifica Permissões de Projetos até Operação
	 * @return boolean
	 */
	
	public function verificaPermissao($id=null, $contexto) {
		$nivel_id = $id;
		$modelo = $this->_contextos[$contexto]['modelo'];
		eval("\$niveis = new Model_$modelo();");
		$nivel = $niveis->fetchRow("id =  $nivel_id");
		
		if ($contexto !== 'programa'){
			$parentNome = $this->_contextos[$contexto]['parent'];
			$parentModelo = $this->_contextos[$parentNome]['modelo'];
			eval("\$parent =\$nivel->findParentRow('Model_$parentModelo');");
			if ($this->verificaPermissao($parent->id,$parentNome))
				return true;
		}

		if ($contexto !== 'meta'){
		
			if ($this->_aclassertrules->_chefe)
				if (isset($this->_aclassertrules->_chefe[$nivel->setor_id]) && $this->_aclassertrules->_chefe[$nivel->setor_id] == $this->_auth->getIdentity()->id)
					return true;
			if (isset($this->_aclassertrules->_setorChefia) &&
				array_key_exists($nivel->setor_id, $this->_aclassertrules->_setorChefia)
				&& $this->_aclassertrules->_setorChefia[$nivel->setor_id] == $this->_auth->getIdentity()->id)
				return true;
			else
				return false;
		} 					
			
	}

	
	
	/**
	 * Verifica se é dono da Atividade
	 * @return boolean
	 */	
	public function verificaAtividade($id=null) {

		$atividade = new Model_AtividadesHistorico();
		$atividadeHistorico = $atividade->fetchCurrentRow ( $id);
		if (!$atividadeHistorico)
			return false;
		if ($atividadeHistorico->responsavel_id == $this->_auth->getIdentity()->id)
			return true;
		else
			return false;		
	}	



}
