<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->title = "POA 2010";
        
        		$this->view->headTitle($this->view->title, 'PREPEND');
        

    }

    public function projetosAction()
    {
        // action body
    }


}









