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
		Zend_Registry::set('schema','poa2010');
	
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
		$view->doctype ( 'XHTML1_STRICT' );
		$view->headMeta ()->appendHttpEquiv ( 'Content-Type', 'text/html;charset=utf-8' );
		$view->headTitle ()->setSeparator ( ' - ' );
		$view->headTitle ( 'Sistema de Monitoramento da Programação Anual de Saúde do Estado de São Paulo' );
		
		
		
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
		            'ViewRenderer'
		);
		
		
		
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
		$pages = array(
					array(
					'label' => 'Home',
					'title' => 'Início',
					'module' => 'default',
					'controller' => 'index',
					'action' => 'index',
					'order' => -100 // make sure home is the first page,
					
					),
					array(
					'label' => 'Administração',
					'module' => 'default',
					'controller' => 'index',
					'action' => 'index',
					'class'=>'',
					'pages' => array(
									array(
										'label' => 'Alterar senha',
										'module' => 'default',
										'controller' => 'usuarios',
										'action' => 'changepassword',
										'class'=>'bt-menu-tree'
									),
									array(
										'label' => 'Usuários',
										'module' => 'default',
										'controller' => 'usuarios',
										'action' => 'index',
										'class'=>'',
										'pages' => array(
														array(
															'label' => 'Listar',
															'module' => 'default',
															'controller' => 'usuarios',
															'action' => 'index',
															'class'=>'bt-menu-tree'
														),
														array(
															'label' => 'Adicionar',
															'module' => 'default',
															'controller' => 'usuarios',
															'action' => 'add',
															'class'=>'bt-menu-tree'
														)
														
													)
									),
									array(
										'label' => 'Grupos',
										'module' => 'default',
										'controller' => 'grupos',
										'action' => 'index',
										'class'=>'bt-menu-tree',
										'pages' => array(
														array(
															'label' => 'Listar',
															'module' => 'default',
															'controller' => 'grupos',
															'action' => 'index',
															'class'=>'bt-menu-tree'
														),
														array(
															'label' => 'Adicionar',
															'module' => 'default',
															'controller' => 'grupos',
															'action' => 'add',
															'class'=>'bt-menu-tree'
														)
												   )
									)
								)
					)
					
		);
		$programas = new Model_Programas();
		$projetos = new Model_Projetos();
		$objetivos_especificos = new Model_ObjetivosEspecificos();
		$metas = new Model_Metas();
		$operacoes = new Model_Operacoes();
		$atividades = new Model_Atividades();
		
		
		$pages_din = array(
							'label' => 'Plano',
							'title' => 'Plano',
							'module' => 'default',
							'controller' => 'plano',
							'action' => 'programas',
							'class'=>'bt-menu-tree'
						);
					
		$pages_din['pages']=array();
		        					
		foreach($programas->fetchAll('situacao_id=1','id') as $programa)
		{
			$arr =array('label'=>$programa->menu,
							'module'=>'default',
							'controller'=>'plano',
							'action'=>'programa',
							'params'=>array('programa_id'=>$programa->id),
							'class'=>'bt-menu-tree'
							);
							
			/**
			 * navegação dos projetos
			 */				
			foreach($projetos->fetchAll('situacao_id=1 and projeto_id is null and programa_id='.$programa->id,'id') as $projeto)
			{
				$pgs = array('label'=>$projeto->menu,
							'module'=>'default',
							'controller'=>'plano',
							'action'=>'projeto',
							'params'=>array('projeto_id'=>$projeto->id),
							'class'=>'bt-menu-tree'
							);	
				
				/**
				 * navegação em objetivos específicos 
				 */
							
				foreach($objetivos_especificos->fetchAll('situacao_id=1 and projeto_id='.$projeto->id) as $objetivo){
					$objesp = array(
								'label'=>$objetivo->menu,
								'module'=>'default',
								'controller'=>'plano',
								'action'=>'objetivos-especificos',
								'params'=>array('objetivo_especifico_id'=>$objetivo->id),
								'class'=>'bt-menu-tree'
								);
					/**
					 * navegação em metas
					 */
					foreach($metas->fetchAll('situacao_id=1 and objetivo_especifico_id='.$objetivo->id) as $meta){
						$metaarray  = array(
								'label'=>substr($meta->descricao,0,15)."...",
								'module'=>'default',
								'controller'=>'plano',
								'action'=>'meta',
								'params'=>array('meta_id'=>$meta->id),
								'class'=>'bt-menu-tree'
								);
						/**
						 * navegação em operações
						 */
						foreach($operacoes->fetchAll('situacao_id=1 and meta_id='.$meta->id) as $operacao){
							$arr_operacao = array(
											'label'=>'operacao',
											'module'=>'default',
											'controller'=>'plano',
											'action'=>'operacao',
											'params'=>array('operacao_id'=>$operacao->id),
											'class'=>'bt-menu-tree'
											);
							/**
							 * navegação em atividades
							 */
											
							foreach($atividades->fetchAll('situacao_id=1 and operacao_id='.$operacao->id) as $atividade){
							$arr_atividades = array(
											'label'=>'atividade',
											'module'=>'default',
											'controller'=>'plano',
											'action'=>'atividade',
											'params'=>array('atividade_id'=>$atividade->id),
											'class'=>'bt-menu-tree'
											);
							$arr_operacao['pages'][]=$arr_atividades;			
							}
							$metaarray['pages'][]=$arr_operacao;
						}		
						$objesp['pages'][] = $metaarray;
					}			
					$pgs['pages'][]=$objesp;
				}
				
				$arr['pages'][] = $pgs;							
			}
			$pages_din['pages'][]=$arr;
		}
		$indicadores = array('label'=>'Indicadores',
							 'title'=>'Indicadores',
							 'module'=>'default',
							 'controller'=>'indicadores',
							 'action'=>'index',
							 'class'=>'bt-menu-tree');
		$relatorios = array('label'=>'Relatórios',
							 'title'=>'Relatórios',
							 'module'=>'default',
							 'controller'=>'relatorios',
							 'action'=>'index',
							 'class'=>'bt-menu-tree'
												
		);
		


		
		$pages[]=$pages_din;
		$pages[]=$indicadores;
		$pages[]=$relatorios;
		
		$container = new Zend_Navigation($pages);
		$this->bootstrap ( 'layout' );
		$layout = $this->getResource ( 'layout' );
		$view = $layout->getView ();
		$view->getHelper('navigation')->setContainer($container);
	
	}

}

