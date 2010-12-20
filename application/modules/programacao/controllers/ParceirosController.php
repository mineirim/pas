<?php

class Programacao_ParceirosController extends Zend_Controller_Action
{

    public function init()
    {
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addContext('js', array('suffix' => 'js'));
        $ajaxContext->setAutoJsonSerialization(false);
        $ajaxContext->addActionContext('index', array('json', 'xml', 'js'))
                ->addActionContext('create', array('html', 'json', 'xml'))
                ->addActionContext('update', array('html', 'json', 'xml'))
                ->addActionContext('delete', array('html', 'json', 'xml'))
                ->addActionContext('get', array('html', 'json', 'xml'))
                ->addActionContext('get2grid', array('html', 'json', 'xml'))
                ->addActionContext('autocomplete', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function indexAction()
    {
        // action body
    }

    public function createAction()
    {
        // action body
    }

    public function updateAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function getAction()
    {
        // action body
    }

    public function editAction()
    {
        // action body
    }

    public function saveAction()
    {
        // action body
    }

    public function autocompleteAction()
    {
        $term = $this->_getParam('term');
    	$model_parceiros = new Model_Parceiros();
    	$parceiros = $model_parceiros->fetchAll("nome ILIKE '%$term%' OR sigla ILIKE '%$term%'");
    	$arr = array();
    	foreach ($parceiros as $parceiro) {
    		$arr[]=array('id'=>$parceiro->id, 
    						'label'=>$parceiro->nome.' - '.$parceiro->sigla,
    						'value'=>$parceiro->nome.' - '.$parceiro->sigla 
    		);
    	}
    	if(count($arr)==0){
    		$arr[]=array('id'=>'new', 
    						'label'=>'adicionar novo com o termo "'.$term.'"',
    						'value'=>'add' 
    		);
    	}
    	$this->view->dados = $arr;
        
    }


}















