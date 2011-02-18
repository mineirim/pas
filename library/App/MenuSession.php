<?php

class App_MenuSession {
	public static function getNavigation(){
		$pages = array(
					array(
					'label' => 'Administração',
					'module' => 'default',
					'controller' => 'index',
					'action' => 'index',
					'class'=>'',
					'pages' => array(
									array(
										'label' => 'Usuários',
										'module' => 'admin',
										'controller' => 'usuarios',
										'action' => 'index',
										'class'=>''
									),
									array(
										'label' => 'Grupos',
										'module' => 'admin',
										'controller' => 'grupos',
										'action' => 'index',
										'class'=>'bt-menu-tree'
									),
									array(
										'label' => 'Cargos',
										'module' => 'admin',
										'controller' => 'cargos',
										'action' => 'index',
										'class'=>'bt-menu-tree'
									),
									array(
										'label' => 'Setores',
										'module' => 'admin',
										'controller' => 'setores',
										'action' => 'index',
										'class'=>'bt-menu-tree'
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
							'controller' => 'instrumentos',
							'action' => 'index',
							'class'=>'bt-menu-tree'
						);
					
		$pages_din['pages']=array();
		        					
		foreach($programas->fetchAll('situacao_id=1','id') as $programa)
		{
			$arr =array('label'=>$programa->menu,
							'module'=>'default',
							'controller' => 'instrumentos',
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
							'controller' => 'instrumentos',
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
								'controller' => 'instrumentos',
								'action'=>'objetivo-especifico',
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
								'controller' => 'instrumentos',
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
											'controller' => 'instrumentos',
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
											'controller' => 'instrumentos',
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
