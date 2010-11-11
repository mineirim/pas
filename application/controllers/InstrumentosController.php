<?php

class InstrumentosController extends Zend_Controller_Action
{

    public function init()
    {
        if ($this->_request->isXmlHttpRequest()) 
                               		$this->_helper->layout()->disableLayout();
    }

    /**
     * Lista todos os programas
     * 
     */
    public function indexAction()
    {
        $programas = new Model_Programas ( );
                $this->view->programas = $programas->fetchAll( "situacao_id=1", 'ordem'  );
                $this->view->nivel = 'Programas';
    }

    public function programaAction()
    {
        // action body
    }

    public function projetoAction()
    {
        // action body
    }


}







