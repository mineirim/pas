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
class Zend_View_Helper_MyToolbar {
	
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
		$this->_controller = $controller;
		$this->_id = $id;
		$toolbar = ""; 
		$mysession = new Zend_Session_Namespace ( 'mysession' );
		$this->acl = $mysession->acl;
		$auth = Zend_Auth::getInstance();
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
			
			eval('$objs = new Model_'.ucfirst($this->_controller).'();');
			
			
			$obj = $objs->fetchRow('id='.$this->_id);
			
			if(isset($obj->responsavel_id)){
				if($obj->responsavel_id!==$auth->getIdentity ()->id){
					return;
				}
			}
		}				
			
		
		if($this->acl->isAllowed($this->role,$resource,'editar') ||
					!$resource ){ 

						
			if($type=='top'){
				$toolbar= $this->getTopBar();
			}
			elseif($type=='toptable')
			{
				$toolbar = $this->getTopTableBar();
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
			$toolbar .= "<a href='".$this->view->url(array('controller'=>'projetos','action'=>'add'))."'
					title='Adicionar Projeto' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all'>
					<span class='ui-icon ui-icon-plus'>Adicionar Projeto</span>Adicionar Projeto</a>";
			
		}elseif($this->_controller=='projetos'){
			$toolbar .= "<a href='".$this->view->url(array('controller'=>'objetivos-especificos','action'=>'add'))."'
					title='Adicionar Objetivo' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all'>
					<span class='ui-icon ui-icon-plus'>Adicionar Objetivo</span>Adicionar Objetivo</a>";
			$toolbar .= "<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'add', 'projeto_id'=>$this->_id ))."'
					title='Adicionar Subprojeto' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all'>
					<span class='ui-icon ui-icon-plus'>Adicionar Subprojeto</span>Adicionar Subprojeto</a>";
		}elseif($this->_controller=='objetivos-especificos'){

			$toolbar .= "<a href='".$this->view->url(array('controller'=>'metas','action'=>'add'))."'
					title='Adicionar Meta' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all'>
					<span class='ui-icon ui-icon-plus'>Adicionar Meta</span>Adicionar Meta</a>";
			
		}elseif($this->_controller=='metas'){
			$url = $this->view->url(array('controller'=>'metas','action'=>'preencherelatorio'));
			$toolbar .= "<a href='$url'
					title='Preencher relatório trimestral' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all by-ajax'>
					<span class='ui-icon ui-icon-pencil'>Preencher relatório</span>Preencher relatório</a>";
			
		}
		
		$ret = $divsini.$toolbar.$divsfim;
		return $ret;
	}
	private function getTopTableBar(){
		$divsini = '<div class="fg-toolbar fg-buttonset ui-widget-content ui-corner-all  ui-helper-clearfix" style="text-align:center">';
		$divsfim ='	</div>';
		$toolbar = "<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'add'))."'
					title='Novo' 
					class='fg-button ui-state-default fg-button-icon-left ui-corner-all'>
					<span class='ui-icon ui-icon-document'>Novo</span>Novo</a>";
		
		
		
		$ret = $divsini.$toolbar.$divsfim;
		return $ret;
	}
	
	private function getLineBar(){
		$trimestral='';
		
		$width = 55;
		if($this->_controller=='metas'){
			$width = 80;
			$trimestral="<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'settrimestral','meta_id'=>$this->_id))."'
						class='my-button ui-state-default ui-corner-all by-ajax '
						title='Configurar meta para relatório trimestral'>
						<span class='ui-icon ui-icon-calendar '></span>
						</a>";
		}
		
		$toolbar = "
		<div style='width:".$width."px;'>
		<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'edit','id'=>$this->_id))."'
					class='my-button ui-state-default ui-corner-all '
					title='Editar' 
					
					>
					<span class='ui-icon ui-icon-pencil '></span>
					</a>
		<a href='".$this->view->url(array('controller'=>$this->_controller,'action'=>'delete','id'=>$this->_id))."'
		class='my-button ui-state-default ui-corner-all '
		title='Excluir' 
		
		>
		<span class='ui-icon ui-icon-trash '></span>
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
