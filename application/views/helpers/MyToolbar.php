<?php
/**
 *
 * @author marcone
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * MyToolbar helper
 * 
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_MyToolbar{
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * Retorna uma toolbar com operações disponíveis para o registro
	 * @param $controller
	 * @param $type top ou line
	 * @return String $toolbar
	 */
	public function myToolbar($controller='programas', $type='top', $id = false) {
		$this->_controller = substr($controller,strpos($controller, ":")+1);
		$this->_id = $id;
		$toolbar = ""; 
		$mysession = new Zend_Session_Namespace ( 'mysession' );
		$this->acl = $mysession->acl;
		$auth = Zend_Auth::getInstance();
		
		if ($id) 
			$this->acl->setContextValue('id', $id);
		
		
		if ($auth->hasIdentity ()) {
			$this->role = $auth->getIdentity ()->username;
		} else {
			$this->role = 'guest';
		}
		$resource = $controller;
		
		if (! $this->acl->has ( $resource )) 
			$resource = null;
		
		$this->res = $resource;	

		if($this->role=='guest' && !$this->acl->hasRole('guest'))
			$this->acl->addRole('guest');
		
		
		if($this->_id && !$this->acl->has('admin') && ($this->_controller=='programas' || $this->_controller=='projetos')){
			$objs = new stdClass();
			eval('$objs = new Model_'.ucfirst($this->_controller).'();');
			
			
			$obj = $objs->fetchRow('id='.$this->_id);
			
			if(isset($obj->responsavel_id)){
                            if($obj->responsavel_id!==$auth->getIdentity ()->id){
                                    return;
                            }
			}
		}				

		$a = new Zend_Acl();
		if($this->acl->isAllowed($this->role,$resource,'editar') ||
					!$resource ){ 

						
			if($type=='top'){
				$toolbar= $this->getTopBar();
			}
			elseif($type=='toptable')
			{
//				if($this->acl->isAllowed($this->role,$resource,'create') ||
	//								!$resource ){ 				
					$toolbar = $this->getTopTableBar();
		//							}
			}
			else{
				$toolbar= $this->getLineBar();
			}
		}
		return $toolbar;
	}
	
	private function getTopBar(){
		
		$divsini = '	<div class="fg-toolbar ui-widget ui-widget-header ui-corner-all ui-helper-clearfix">
							<div class="fg-buttonset ui-helper-clearfix">';
		$divsfim ='			</div>
						</div>';
		$toolbar = '';
		
		
		if($this->_controller=='programas'){
			$toolbar .= "<a href='".$this->view->url(array('controller'=>'projetos','action'=>'create','module'=>'programacao' ),null,true)."'
					title='Adicionar Projeto' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all ajax-form-load'>
					<span class='ui-icon ui-icon-plus'>Adicionar Projeto</span>Adicionar Projeto</a>";
			
		}elseif($this->_controller=='projetos'){
			$toolbar .= "<a href='".$this->view->url(array('controller'=>'objetivos-especificos','action'=>'create', 'module'=>'programacao' ))."'
					title='Adicionar Objetivo' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all ajax-form-load'>
					<span class='ui-icon ui-icon-plus'>Adicionar Objetivo</span>Adicionar Objetivo</a>";
			$toolbar .= "<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'create', 'module'=>'programacao', 'projeto_id'=>$this->_id ))."'
					title='Adicionar Subprojeto' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all ajax-form-load'>
					<span class='ui-icon ui-icon-plus'>Adicionar Subprojeto</span>Adicionar Subprojeto</a>";
		}elseif($this->_controller=='objetivos-especificos'){

			$toolbar .= "<a href='".$this->view->url(array('controller'=>'metas','action'=>'create', 'module'=>'programacao' ))."'
					title='Adicionar Meta' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all ajax-form-load'>
					<span class='ui-icon ui-icon-plus'>Adicionar Meta</span>Adicionar Meta</a>";
			
		}elseif($this->_controller=='metas'){
			$url = $this->view->url(array('controller'=>'metas','action'=>'addindicador', 'module'=>'programacao' ));
			$toolbar .= "<a href='$url'
					title='Vincular Indicadores' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all ajax-form-load'>
					<span class='ui-icon ui-icon-pencil'>Preencher relatório</span>Indicadores</a>";
			$url = $this->view->url(array('controller'=>'metas','action'=>'preencherelatorio',  'module'=>'programacao'));
			$toolbar .= "<a href='$url'
					title='Preencher relatório trimestral' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all ajax-form-load'>
					<span class='ui-icon ui-icon-pencil'>Preencher relatório</span>Preencher relatório</a>";
		}
		
		$ret = $divsini.$toolbar.$divsfim;
		return $ret;
	}
	private function getTopTableBar(){
		$toolbar = "<button value='".$this->view->url(array('controller'=>$this->_controller,'action'=>'create','module'=>'programacao'))."'
					title='Novo'
                                        alt='ui-icon-document'
					class='my-jq-button button-ajax ajax-form-load'>Novo</a>";
		return $toolbar;
	}
	
	private function getLineBar(){
		$trimestral='';
		
		$width = 65;
		if($this->_controller=='metas'){
			$width = 80;
			$trimestral="<a href='".$this->view->url(array('module'=>'programacao', 'controller'=>$this->_controller,'action'=>'settrimestral','meta_id'=>$this->_id),null,true)."'
						class='my-button ajax-form-load '
						title='Configurar meta para relatório trimestral'>
						<span class='ui-icon ui-icon-calendar '></span>
						</a>";
		}
		
		$toolbar = "
		<div style='width:".$width."px;'>
		<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'edit', 'module'=>'programacao', 'id'=>$this->_id),null,true)."'
					class='my-button ajax-form-load'
					title='Editar' 
					
					>
					<span class='ui-icon ui-icon-pencil '></span>
					</a>
		<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'delete','module'=>'programacao', 'id'=>$this->_id),null,true)."'
		class='my-button ajax-form-load'
		title='Excluir' >
		<span class='ui-icon ui-icon-trash '></span>
		</a>
                <a href='".$this->view->url(array('controller'=>'impressora','action'=>$this->_controller,'module'=>'relatorios', 'id'=>$this->_id),null,true)."'
		class='my-button '
		title='Relatório' >
		<span class='ui-icon ui-icon-print '></span>
		</a>
		$trimestral
		</div>
		";


		return $toolbar ;
		
	}
	private function getBarProjetos(){
		
	}
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
