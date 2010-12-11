<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	protected function _initAutoload() {
		
		$moduleloader = new Zend_Application_Module_Autoloader ( array ('namespace' => '', 'basePath' => APPLICATION_PATH ) );
		$autoloader = Zend_Loader_Autoloader::getInstance ();
		$autoloader->registerNamespace ( array ('App_' ) );
		
		
        // Configurando o autoloader do EzComponents
        require_once 'ezc/Base/src/base.php';
        $autoloader->pushAutoloader(array('ezcBase', 'autoload'), 'ezc');
		
		
		return $moduleloader;
	}

	
	function _initSession() {
		
		Zend_Session::start ();
		Zend_Registry::set('schema','pas2011');
	
	}
	protected function _initLanguage() {
		$portugues='';
		require_once 'Languages/pt-br/pt_BR.php';
		$translate = new Zend_Translate ( 'array', $portugues, 'pt_BR' );
		Zend_Registry::set('translate',$translate);
		Zend_Validate_Abstract::setDefaultTranslator($translate);
		$locale = new Zend_Locale('pt_BR');
		Zend_Locale::setDefault($locale);
		Zend_Registry::set('locale',$locale);
		
	}	
	function _initLocale(){
		
		Zend_Locale::setCache(
		Zend_Cache::factory(
			'Core',
			'File',
			array(),
			array('cache_dir' => APPLICATION_PATH . '/../tmp_zend')
			)
		);
		$locale = new Zend_Locale('pt_BR');
		Zend_Registry::set('Zend_Locale', $locale);
	}
	public function _initDbAdapter() {
		$this->bootstrap ( 'db' );
		$dbAdapter = $this->getResource ( 'db' );
		
		Zend_Registry::set ( 'db', $dbAdapter );
	
	}	
	function _initViewHelpers() {
		$this->bootstrap ( 'layout' );
		
		$layout = $this->getResource ( 'layout' );
		$view = $layout->getView ();
		$view->doctype ('XHTML1_TRANSITIONAL' );
		$view->headMeta ()->appendHttpEquiv ( 'Content-Type', 'text/html;charset=utf-8' );
		$view->headTitle ()->setSeparator ( ' - ' );
		$view->headTitle ( 'Sistema de Monitoramento da Programação Anual de Saúde do Estado de São Paulo' );
	
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
		            'ViewRenderer'
		);
		
		$viewRenderer->view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'My_View_Helper');
		
		$viewRenderer->setView($view); 		
	}

	function _initAcl() {
		$front = Zend_Controller_Front::getInstance ();
		$front->throwExceptions ( true );
		$auth = Zend_Auth::getInstance ();
		$mysession = new Zend_Session_Namespace ( 'mysession' );
		if (! isset ( $mysession->acl )) {
			$acl = new App_Myacl ( $auth );
			$mysession->acl = $acl;
		}
		$acl = $mysession->acl;
		
		Zend_Registry::set('acl',$acl);
		$front->registerPlugin ( new App_Controller_AclPlugin ( $auth, $acl ) );
		$front->registerPlugin ( new App_Controller_AjudaPlugin () );
		
	
	}
	
	/*
	protected function _initMenu() {
		if (Zend_Auth::getInstance ()->hasIdentity ()) {
			$this->bootstrap ( 'view' );
			$view = $this->getResource ( 'view' );
			$config = new Zend_Config_Xml ( APPLICATION_PATH . '/configs/navigation.xml', 'nav' );
			$navigation = new Zend_Navigation ( $config );
			$view->navigation ( $navigation );
		}
	
	}
	*/
	protected function _initMenu() {
		            
            $mysession = new Zend_Session_Namespace ( 'menu' );
            if (! isset ( $mysession->navigation )) {
                $mysession->navigation = App_MenuSession::getNavigation();
            }
            $container = new Zend_Navigation($mysession->navigation);
            $this->bootstrap ( 'layout' );
            $layout = $this->getResource ( 'layout' );
            $view = $layout->getView ();
            $view->getHelper('navigation')->setContainer($container);

	}

}

