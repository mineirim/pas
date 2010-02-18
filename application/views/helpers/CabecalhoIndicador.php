<?php
/**
 *
 * @author marcone
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * LineToolbar helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_CabecalhoIndicador {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	private $_indicador;
	private $_model;
	
	/**
	 *  
	 */
	public function cabecalhoIndicador( Zend_Db_Table_Row_Abstract  $obj, $controller)
	{
		
		$this->_indicador = $obj;
		
		$acl = Zend_Registry::get('acl');
		
		$auth = Zend_Auth::getInstance();
		
		if ($auth->hasIdentity ()) {
			$role = $auth->getIdentity ()->username;
		} else {
			$role = 'guest';
		}
		
		$resource = 'indicadores';
		if (! $acl->has ( 'indicadores' )){		$resource=null;	}
		
		if (! $acl->has ( $controller )) {	$controller = null;}
		
		if($this->_indicador->tipo_indicador_id==1){
			$ret = $this->getQuantitativo();
		}else{
			
			$opcoes = new Model_OpcoesQualitativos();
			$indicadores_qualitativos = new Model_IndicadoresQualitativos();
			$indicadore_qualitativo = $indicadores_qualitativos->fetchRow('indicador_id='.$this->_indicador->id);
			/**
			 * se é permitido editar indicadores e editar o controller atual (ex: programas, projetos..)
			 */
			if(($acl->isAllowed($role,$resource,'editar')  || !$resource ) && ($acl->isAllowed($role,$controller,'editar')  || !$controller))
			{
				$this->categoria = new Zend_Form_Element_Select('categoria');
				$this->categoria->removeDecorator('Label')->removeDecorator('HtmlTag');
				$this->categoria->setAttrib('class','alterar-categoria');
				$this->categoria->addMultiOption('','');
				
				$this->url_categoria = new Zend_Form_Element_Hidden('url_categoria');
				$this->url_categoria->removeDecorator('Label')->removeDecorator('HtmlTag');
				$this->url_categoria->setValue($this->view->url(array('controller'=>'indicadores','action'=>'alterarcategoria')));
				foreach ($opcoes->fetchAll('indicador_id='.$this->_indicador->id) as $opcao){
					$this->categoria->addMultiOption($opcao->id, $opcao->descricao);
				}
				if($indicadore_qualitativo)
					$this->categoria->setValue($indicadore_qualitativo->opcao_qualitativo_id);
					
			}else{
				if($indicadore_qualitativo){
					$opcao = $opcoes->fetchRow('id='.$indicadore_qualitativo->opcao_qualitativo_id);
					$this->categoria ="=> <i>". $opcao->descricao ."</i>";
				}else{
					$this->categoria = "";
					
				}
				$this->url_categoria = "";
			}
			$ret = $this->getQualitativo();
		}
		
		return $ret; 
	}

	private function getQualitativo(){
		$ret = '<div style="float:right;width:99%;"><div style="float:left;position:relative">'.$this->_indicador->descricao.'</div>';
		$ret.= '<div style="float:left;position:relative;margin-left:15px">'.$this->categoria. $this->url_categoria.'</div></div>';
		return $ret; 
	}
				
	private function getQuantitativo(){
		$ret = '<a href='.$this->view->url(array('controller' =>'indicador','action' => 'show','id'=> $this->_indicador->id)).'>'.$this->_indicador->descricao.'</a>';
		return $ret; 
	}
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
