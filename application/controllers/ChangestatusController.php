<?php

/**
 * ChangestatusController
 * 
 * Classe utilizada para alterar o status/situação de qualquer objeto
 * 
 * @author Marcone
 *  
 */

require_once 'Zend/Controller/Action.php';


class ChangestatusController extends Zend_Controller_Action {
	
	
	public function init()
	{
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('delete', 'json')
        			->addActionContext('restore',array('json','xml'))
                    ->initContext();    	
		$this->_helper->layout()->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);		
	}
	public function indexAction() {
		// TODO Auto-generated ChangestatusController::indexAction() default action
	}
	public function deleteAction()
	{
		
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

