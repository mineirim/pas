<?php

class Programacao_ChangestatusController extends Zend_Controller_Action
{

	public function init()
	{
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('delete', array('html', 'json','xml'))
        			->addActionContext('restore',array('html', 'json','xml'))
                    ->initContext();    	
		$this->_helper->layout()->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);		
	}
	public function indexAction() {
		
	}
	public function deleteAction()
	{
		$objetos = new stdClass();
		$model = $this->_getParam('model');
		$id = $this->_getParam('id');
		
		eval("\$objetos = new $model();");
		
		$objeto = $objetos->fetchRow("id=".$id);
		
		if($objeto->offsetExists('situacao_id'))
		{
			$objeto->situacao_id=2;
			$status = $objeto->save();
		}else{
			$status = $objetos->delete("id=".$id);
		}
		$returns = array();
		$returns['obj'] = $objeto->toArray(); 
		$returns['status'] = $status;
    	$return = Zend_Json_Encoder::encode($returns);
    	
    	echo $return;
    	
	}
	


}

