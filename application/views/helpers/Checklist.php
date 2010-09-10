<?php
/**
 *
 * @author marcone
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Checklist helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Checklist {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function checklist($trimestre) {
		$model_projetos = new Model_Projetos();
		$model_objetivos_especificos = new Model_ObjetivosEspecificos();
		$model_metas =  new Model_Metas();
	    $schema = Zend_Registry::get('schema');
	    
        $where = "id in (SELECT DISTINCT programa_id FROM $schema.metas_trimestres where trimestre=$trimestre AND (not percentual>0 or avaliacao_descritiva is null))";
        $model_programas = new Model_Programas();
       
        $programas = $model_programas->fetchAll($where,array('ordem','id'));
        
        
        $db = Zend_Registry::get('db');
        $html = array();
        foreach ($programas as $programa)
        {
		    $html[] = "<li id='programa_$programa->id'><span class=''>";
		    $html[] = $programa->menu . PHP_EOL."</span>";
		    $select = $model_projetos->select();
		    $where = "id in (SELECT DISTINCT projeto_id FROM $schema.metas_trimestres where trimestre=$trimestre AND (not percentual>0 or avaliacao_descritiva is null))";
		    $select->reset('where');
		    $select->where($where);
		    
		    $projetos =$programa->findModel_Projetos($select) ;
		    
	    	$html[] = "<ul  id='grp_programa_$programa->id'>";
		    foreach ($projetos as $projeto)
		    {
			    $html[] = "<li id='projeto_$projeto->id'><span class='' >";
	            $html[] = $projeto->menu."</span>" . PHP_EOL;
	            
	            $select = $model_objetivos_especificos->select();
			    $where = "id in (SELECT DISTINCT objetivo_especifico_id FROM $schema.metas_trimestres where trimestre=$trimestre AND (not percentual>0 or avaliacao_descritiva is null))";
			    $select->reset('where');
			    $select->where($where);
			    
		        $objetivos = $projeto->findModel_ObjetivosEspecificos($select);    
	            $html[] = "<ul  id='grp_projeto_$projeto->id'>";
	            foreach ($objetivos as $objetivo)
	            {
	            	$html[] = "<li id='objetivoespecifico_$objetivo->id'><span class='' >";
	            	$html[] = $objetivo->menu."</span>" . PHP_EOL;
	            	
	            	$select = $model_metas->select();
				    $where = "id in (SELECT DISTINCT meta_id FROM $schema.metas_trimestres where trimestre=$trimestre AND (not percentual>0 or avaliacao_descritiva is null))";
				    $select->reset('where');
				    $select->where($where);
			        $metas = $objetivo->findModel_Metas($select);
			        
			        $html[] = "<ul  id='grp_objetivo_$objetivo->id'>";
		            foreach ($metas as $meta)
		            {
		            	$html[] = "<li id='objetivoespecifico_$objetivo->id'><span class='' >";
	            		$html[] = $meta->descricao."</span>" . PHP_EOL;
	            		$html[] = "</li>";
		            }
		            $html[]="</ul>";
		            $html[] = "</li>";
	            }
	            $html[]="</ul>";
	        	$html[] = "</li>";
		    }
	    	
	    	$html[]="</ul>";
		    $html[] = "</li>";
        }
        	
		if(count($programas)==0)
			$html[]='<li>Não existem pendências</li>';
		
		return join(PHP_EOL, $html);;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

