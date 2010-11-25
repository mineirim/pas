<?php

class ReportsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	
    }

    public function indexAction()
    {
        // action body
    }
	public function checklistAction()
	{
		$trimestre = $this->_getParam('trimestre');
        if($trimestre)
        {
			$this->view->trimestre = $trimestre;
        	
        }
	}
    public function trimestralAction()
    {
    	$this->_helper->layout()->setLayout('layout_report');
        $trimestre = $this->_getParam('trimestre');
        if($trimestre)
        {
        	$schema = Zend_Registry::get('schema');
        	$where = "id in (SELECT DISTINCT programa_id FROM $schema.metas_trimestres where trimestre=$trimestre)";
        	$model_programas = new Model_Programas();
        	$programas = $model_programas->fetchAll($where,'ordem');
        	
        	$this->view->programas = $programas;
        	
        	
        	$db =Zend_Registry::get('db');
        	
        	
        	$db->setFetchMode(Zend_Db::FETCH_OBJ);
 			$results = $db->fetchAll("SELECT DISTINCT projeto_id id FROM $schema.metas_trimestres WHERE trimestre=?", $trimestre);
 			$projeto_ids = array();
 			foreach ($results as $o)
 			{
 				$projeto_ids[] = $o->id;
 			}
 			
 			//$select_projetos = $model_programas->select();
 			$model_projetos = new Model_Projetos();
 			$select_projetos = $model_projetos->select();
 			$select_projetos->order('ordem');
            $this->view->projeto_ids = $projeto_ids;
            
            
            
            $this->view->select_projetos = $select_projetos;
 			
        	$results = $db->fetchAll("SELECT DISTINCT objetivo_especifico_id id FROM $schema.metas_trimestres WHERE trimestre=?", $trimestre);
 			$objetivo_especifico_ids = array();
 			foreach ($results as $o)
 			{
 				$objetivo_especifico_ids[] = $o->id;
 			}
 			
 			$this->view->objetivo_especifico_ids=$objetivo_especifico_ids;
			$select_objetivos = $model_programas->select();
			$select_objetivos->order('ordem');
            $this->view->select_objetivos = $select_objetivos; 			

            $results = $db->fetchAll("SELECT DISTINCT meta_id id FROM $schema.metas_trimestres WHERE trimestre=?", $trimestre);
 			$meta_ids = array();
 			foreach ($results as $o)
 			{
 				$meta_ids[] = $o->id;
 			}
 			
			$select_metas = $model_programas->select();
			$select_metas->order('id');
            $this->view->select_metas = $select_metas;
            
            $this->view->meta_ids = $meta_ids;
            
            $select_trimestre = $model_programas->select();
            $this->view->select_trimestre = $select_trimestre;
            $this->view->trimestre = $trimestre;
        }
        
    }


}



