<?php

class Programacao_SearchController extends Zend_Controller_Action
{
	public function init() {
		$ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('object', 'json')
        			->addActionContext('add',array('json','xml'))
        			->addActionContext('addobjetivo',array('json','xml'))
        			->addActionContext('addmeta',array('json','xml'))
                    ->initContext(); 
    
    
    }

    public function indexAction()
    {
        // action body
    }
    /**
     * Procura objeto pela classe e id 
     * @return json
     */
	public function objectAction()
	{
		$classe = $this->_getParam('classe');
		$id = $this->_getParam('id');
		
		$objects = new $classe();
		$object = $objects->fetchRow('id='.$id);
		$return = Zend_Json_Encoder::encode($object->toArray());
		if ($this->_request->isXmlHttpRequest()) {
	        $this->_helper->layout()->disableLayout();
	        $this->_helper->viewRenderer->setNoRender(true);
	        echo $return;
    	}else{
    		
    		echo "Este recurso não pode ser acessado diretamente pelo browser";
    		exit;
    	}		
	}

}

