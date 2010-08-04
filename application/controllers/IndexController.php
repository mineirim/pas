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
        $this->view->title = "POA 2010";
        
        		$this->view->headTitle($this->view->title, 'PREPEND');
	  $this->_redirect('/auth');
        

    }

    public function projetosAction()
    {
        // action body
    }


}









