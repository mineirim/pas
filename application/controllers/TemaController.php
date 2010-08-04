<?php

class TemaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
    }

    public function indexAction()
    {
        $temas = array('cupertino', 'flick','humanity','overcast','pepper-grinder', 'smoothness','swanky-purse','trontastic', 'ui-lightness');
        $selecionado=$this->_getParam ('temax', 'smoothness' );
        $session = new Zend_Session_Namespace('temas');
        $session->temax = $selecionado;
        $this->view->temas = $temas;
    }

}

