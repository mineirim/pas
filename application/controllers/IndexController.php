<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       
        $this->view->headTitle($this->view->title, 'PREPEND');
	

    }

    public function projetosAction()
    {
        // action body
    }


}









