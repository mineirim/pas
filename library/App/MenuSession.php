<?php

class App_MenuSession {
	public static function getNavigation(){
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
		return $pages;		
	} 
}
