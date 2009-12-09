<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	protected function _initAutoload() {
		
		$moduleloader = new Zend_Application_Module_Autoloader ( array ('namespace' => '', 'basePath' => APPLICATION_PATH ) );
		$autoloader = Zend_Loader_Autoloader::getInstance ();
		$autoloader->registerNamespace ( array ('App_' ) );
		return $moduleloader;
	}
	function _initSession() {
		/**
		 * como usar o zend _session
		 * 
		 */
		
		Zend_Session::start ();
		$mysession = new Zend_Session_Namespace ( 'temas' );
		
		if (! isset ( $mysession->temax )) {
			$mysession->temax = 'custom-theme';
		}
		Zend_Registry::set('schema','poa2010');
	
	}
	function _initLocale(){
		$locale = new Zend_Locale('pt_BR');
		Zend_Registry::set('Zend_Locale', $locale);
	}
	function _initViewHelpers() {
		$this->bootstrap ( 'layout' );
		$layout = $this->getResource ( 'layout' );
		$view = $layout->getView ();
		$view->doctype ( 'XHTML1_STRICT' );
		$view->headMeta ()->appendHttpEquiv ( 'Content-Type', 'text/html;charset=utf-8' );
		$view->headTitle ()->setSeparator ( ' - ' );
		$view->headTitle ( 'Sistema de Monitoramento do Plano Municipal de Saúde' );
		
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
		            'ViewRenderer'
		);
		$viewRenderer->setView($view); 		
	}
	public function _initDbAdapter() {
		$this->bootstrap ( 'db' );
		$dbAdapter = $this->getResource ( 'db' );
		
		Zend_Registry::set ( 'db', $dbAdapter );
	
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
		$front->registerPlugin ( new App_Controller_AclPlugin ( $auth, $acl ) );
	
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
		$pages = array(
					array(
					'label' => 'Home',
					'title' => 'Início',
					'module' => 'default',
					'controller' => 'index',
					'action' => 'index',
					'order' => -100, // make sure home is the first page,
					'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu'
					),
					array(
					'label' => 'Administração',
					'module' => 'default',
					'controller' => 'index',
					'action' => 'index',
					'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu',
					'pages' => array(
									array(
										'label' => 'Usuários',
										'module' => 'default',
										'controller' => 'usuarios',
										'action' => 'index',
										'class'=>'ui-widget ui-widget-header ui-state-default ui-corner-all bt-menu',
										'pages' => array(
														array(
															'label' => 'Listar',
															'module' => 'default',
															'controller' => 'usuarios',
															'action' => 'index',
															'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu'
														),
														array(
															'label' => 'Adicionar',
															'module' => 'default',
															'controller' => 'usuarios',
															'action' => 'add',
															'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu'
														)
														
													)
									),
									array(
										'label' => 'Grupos',
										'module' => 'default',
										'controller' => 'grupos',
										'action' => 'index',
										'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu',
										'pages' => array(
														array(
															'label' => 'Listar',
															'module' => 'default',
															'controller' => 'grupos',
															'action' => 'index',
															'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu'
														),
														array(
															'label' => 'Adicionar',
															'module' => 'default',
															'controller' => 'grupos',
															'action' => 'add',
															'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu'
														)
												   )
									),
									array(
										'label' => 'Temas',
										'module' => 'default',
										'controller' => 'tema',
										'action' => 'index',
										'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu'
									)
								)
					)
					
		);
		$programas = new Model_Programas();
		$projetos = new Model_Projetos();
		
		
		$pages_din = array(
							'label' => 'Plano',
							'title' => 'Plano',
							'module' => 'default',
							'controller' => 'plano',
							'action' => 'programas',
							'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu'
						);
					
		$pages_din['pages']=array();
		        					
		foreach($programas->fetchAll('situacao_id=1','id') as $programa)
		{
			$arr =array('label'=>$programa->menu,
							'module'=>'default',
							'controller'=>'plano',
							'action'=>'programa',
							'params'=>array('programa_id'=>$programa->id),
							'class'=>'ui-widget ui-widget-header ui-state-default ui-corner-all bt-menu'
							);
			foreach($projetos->fetchAll('situacao_id=1 and projeto_id is null and programa_id='.$programa->id,'id') as $projeto)
			{
				$pgs = array('label'=>$projeto->menu,
							'module'=>'default',
							'controller'=>'plano',
							'action'=>'projeto',
							'params'=>array('projeto_id'=>$projeto->id),
							'class'=>'ui-widget ui-widget-header ui-state-default ui-corner-all bt-menu'
							);	
				$arr['pages'][] = $pgs;
			}
			$pages_din['pages'][]=$arr;
		}
		$indicadores = array('label'=>'Indicadores',
							 'title'=>'Indicadores',
							 'module'=>'default',
							 'controller'=>'indicadores',
							 'action'=>'index',
							 'class'=>'ui-widget ui-widget-header  ui-state-default ui-corner-all bt-menu');
		
		$pages[]=$pages_din;
		$pages[]=$indicadores;
		$container = new Zend_Navigation($pages);
		$this->bootstrap ( 'layout' );
		$layout = $this->getResource ( 'layout' );
		$view = $layout->getView ();
		$view->getHelper('navigation')->setContainer($container);
	
	}

}

