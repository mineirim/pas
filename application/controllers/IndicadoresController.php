<?php

class IndicadoresController extends Zend_Controller_Action {
	
	/**
	 * @var Model_Indicadores $indicadores Model_Indicadores()
	 */
	private $indicadores = null;
	
	/**
	 * @var Model_IndicadoresConfiguracoes $indicadores_configs Model_IndicadoresConfiguracoes()
	 */
	
	private $indicadores_configs = null;
	
	public function init() {
		/* Initialize action controller here */
		$this->indicadores = new Model_Indicadores ( );
	}
	
	public function indexAction() {
		$this->view->indicadores = $this->indicadores->fetchAll ( null, 'id' );
	}
	
	public function editAction() {
		$id = $this->_getParam ( 'id' );
		if (! $id) {
			$msg = "id não informado";
			$this->_redirect ( '/error/notfound/msg/' . $msg );
		}
		$this->view->indicador = $this->indicadores->find ( $id )->current ();
	}
	
	public function deleteAction() {
	
	}
	
	public function configurarAction() 
	{
		$this->indicadores_configs = new Model_IndicadoresConfiguracoes();
		$form = new Form_IndicadorConfig();
		$id = $this->_getParam ( 'id',null );
		$indicador_id = $this->_getParam('indicador_id',null);
		
		if ($this->getRequest()->isPost ()) 
		{
			$formData = $this->getRequest ()->getPost ();
			if ($form->isValid ( $formData )) 
			{
				$id = $form->getValue('id');
				$dados = $form->getDados ();
			
				if($form->getValue('id')==''){
					$id = $this->indicadores_configs->insert ( $dados );
				}else{
					$this->indicadores_configs->update($dados, 'id='.$id );
				}
				$indicador_config = $this->indicadores_configs->fetchRow('id='.$id );
				$this->view->indicador_config = $indicador_config;
				$form->submit->setAttrib('class','byajax');
							
			}else{
				
				$form->populate ( $formData );
			} 
			$this->view->indicador = $this->indicadores->find($form->getValue('indicador_id'))->current();
    	}elseif ($id) 
    	{
    		$indicador_config = $this->indicadores_configs->fetchRow('id='.$id );
    		$form->submit->setAttrib('class','byajax');
			$form->populate ( $indicador_config->toArray() );
			$this->view->indicador = $indicador_config->findParentRow('Model_Indicadores');
    		
    	}elseif ($indicador_id)
    	{
    		$this->view->indicador = $this->indicadores->find ( $indicador_id )->current ();
    		$form->indicador_id->setValue($this->view->indicador->id);
    		$form->submit->setAttrib('class','byajax');

    	}else
    	{
			$msg = "id não informado";
			$this->_redirect ( '/error/notfound/msg/' . $msg );
		}
		$this->form->indicador_id = $this->view->indicador->id;
		$this->view->form = $form;
		
	}
	public function removerconfiguracaoAction()
	{
		$id = $this->_getParam('id');
		if($id){
			$this->indicadores_configs = new Model_IndicadoresConfiguracoes();
			$ic = $this->indicadores_configs->find($id)->current();
			$ic->situacao_id=2; 
		}
	}

}

