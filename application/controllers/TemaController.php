<?php

class TemaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $temas = array('cupertino', 'flick','humanity','overcast','pepper-grinder','smoothness','ui-lightness');
        $selecionado=$this->_getParam ('temax', 'smoothness' );
        $session = new Zend_Session_Namespace('temas');
        $session->temax = $selecionado;
        $this->view->temas = $temas;
    }

}

