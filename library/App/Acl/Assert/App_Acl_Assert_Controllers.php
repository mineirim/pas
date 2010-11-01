<?php

require_once ('Zend/Acl/Assert/Interface.php');

/** 
 * @author marcone
 * 
 * 
 */
class App_Acl_Assert_Controllers implements Zend_Acl_Assert_Interface {
	/**
	 * @param Zend_Acl $acl
	 * @param Zend_Acl_Role_Interface $role
	 * @param Zend_Acl_Resource_Interface $resource
	 * @param unknown_type $privilege
	 */
	public function assert(Zend_Acl $acl, 
							Zend_Acl_Role_Interface $user = null, 
							Zend_Acl_Resource_Interface $resource = null, 
							$privilege = null) 
	{
	    if (!$user instanceof Zend_Acl_Role_Interface) {
            throw new Exception(__CLASS__
                              . '::'
                              . __METHOD__
                              . ' expects the role to be'
                              . ' an instance of Usuario');
        }

        if (!$resource instanceof Zend_Controller_Action) {
            throw new Exception(__CLASS__
                              . '::'
                              . __METHOD__
                              . ' expects the resource to be'
                              . ' an instance of Zend_Controller_Action');
        }

        // if role is publisher, he can always modify a post
        
        /**
         * coisas que influenciam nas permissões do usuário
         * se é chefe imediato ou indireto
         * se é o responsável direto pelo objeto
         * se é do mesmo setor e a permissão foi explicitada(deverá ser criada uma função que explicíta que todos os usuários do setor podem fazer alterações)
         * se é administrador pode tudo 
         */
        
        if ($user->getRoleId() == 'publisher') {
            return true;
        }

        // check to ensure that everyone else is only modifying their own post
        if ($user->id != null && $blogPost->ownerUserId == $user->id) {
            return true;
        } else {
            return false;
        }		
	}

	

}

?>