<?php
class App_Controller_AclPlugin extends Zend_Controller_Plugin_Abstract {
	private $_auth;
	private $_acl;
	
	private $_noauth = array ('module' => 'default', 'controller' => 'auth', 'action' => 'index' );
	
	private $_noacl = array ('module' => 'default', 'controller' => 'error', 'action' => 'privileges' );
	
	public function __construct($auth, $acl) {
		$this->_auth = $auth;
		$this->_acl = $acl;
		
	}
	
	public function preDispatch(Zend_Controller_Request_Http $request) {
		
		
		
		$mysession = new Zend_Session_Namespace('mysession');
		$this->_auth = Zend_Auth::getInstance();
		$this->_acl = $mysession->acl;
		
		
		
		if ($this->_auth->hasIdentity ()) {
			$role = $this->_auth->getIdentity ()->username;
		} else {
			$role = 'guest';
		}
		
		$controller = $request->controller;
		$action = $request->action;
		$module = $request->module;
		$resource = $controller;
		$params =$request->getParams();
		
		
		if (! $this->_acl->has ( $resource )) {
			$resource = null;
		}elseif (! $this->_acl->isAllowed ( $role, $resource, $action )) {
			if (! $this->_auth->hasIdentity ()) {
				/**
				 * armazena o destino original
				 */
				$goto = new Zend_Session_Namespace('goto');
				$goto->module = $module;
				$goto->controller= $controller;
				$goto->action=$action;
				$goto->params = $params;
				
				$module = $this->_noauth ['module'];
				$controller = $this->_noauth ['controller'];
				$action = $this->_noauth ['action'];
				
			} else {
				$module = $this->_noacl ['module'];
				$controller = $this->_noacl ['controller'];
				$action = $this->_noacl ['action'];
			}
		}
		
		$request->setModuleName ( $module );
		$request->setControllerName ( $controller );
		$request->setActionName ( $action );
		
	}

	
}
