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
		
		//echo ' == Checking the assertion ==' . PHP_EOL; // only here for the purposes of article
		
		

		if (! $user instanceof Zend_Acl_Role_Interface) {
			throw new Exception ( __CLASS__ . '::' . __METHOD__ . ' expects the role to be' . ' an instance of Usuario' );
		}
		
		if (! $resource instanceof Zend_Acl_Resource_Interface) {
			throw new Exception ( __CLASS__ . '::' . __METHOD__ . ' expects the resource to be' . ' an instance of Zend_Controller_Action' );
		}
		
		
		// if role is publisher, he can always modify a post
		

		/**
		 * coisas que influenciam nas permissões do usuário
		 * se é chefe imediato ou indireto
		 * se é o responsável direto pelo objeto
		 * se é do mesmo setor e a permissão foi explicitada(deverá ser criada uma função que explicíta que todos os usuários do setor podem fazer alterações)
		 * se é administrador pode tudo 
		 */

		$this->_auth = Zend_Auth::getInstance ();
		$this->_acl = Zend_Registry::get ( 'acl' );
		$this->_aclassertrules = Zend_Registry::get ( 'aclAssetRules' );
		
		if (! $this->_auth->hasIdentity ()) {
			return false;
		}
		return $this->verificaPermissoes();
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
	
	public function verificaPermissoes() 
	{
		$controller = $this->_acl->getContextValue('action');
		$return = false;
		switch ($controller) {
			case 'programa' :
				$return = $this->verificaPermissao(null,'programa');
				break;
			case 'projeto' :
				$return = $this->verificaPermissao(null,'projeto');
				break;
			case 'objetivo-especifico' :
				$return = $this->verificaPermissao(null,'objetivo-especifico');
				break;				
			case 'meta' :
				$return = $this->verificaPermissao(null,'meta');
				break;				
			case 'operacao' :
				$return = $this->verificaPermissao(null,'operacao');
				break;
			case 'atividade' :
				$return = $this->verificaAtividade();
				break;				
			default :
				return false;
				break;
		}
		return $return;
	}
	
	/**
	 * verifica Permissões de Projetos até Operação
	 * @return boolean
	 */
	
	public function verificaPermissao($id=null, $contexto) {
		$nivel_id = (!$id)?$this->_acl->getContextValue(str_replace('-','_',$contexto).'_id'):$id;
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
		} else {
			if ($nivel->inclusao_usuario_id  == $this->_auth->getIdentity()->id)
				return true;
			else
				return false;
				
		}						
			
	}

	
	
	/**
	 * verifica se é dono da Atividade
	 * @return boolean
	 */	
	public function verificaAtividade($id=null) {
		$atividade_id = (!$id)?$this->_acl->getContextValue('atividade_id'):$id;
		$atividades = new Model_Atividades();
		$atividade = $atividades->fetchRow("id =  $atividade");
		$atividadeHistorico = $atividade->findDependentRowset( 'Model_AtividadesHistorico' );
		echo "passou aki";exit;
		if ($atividadeHistorico->responsavel_id == $this->_auth->getIdentity()->id)
			return true;
		else
			return false;		
	}	
	


}
