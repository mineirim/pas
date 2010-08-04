<?php

class IndicadorController extends Zend_Controller_Action
{   
	private $arr_campos = array();

    /**
     * @var Model_Indicadores $indicadores Model_Indicadores()
     * 
     */
    private $indicadores = null;

    /**
     * @var Model_IndicadoresConfiguracoes $indicadores_configs Model_IndicadoresConfiguracoes()
     * 
     */
    private $indicadores_configs = null;
	
    public function init()
    {
        $this->indicadores = new Model_Indicadores ( );
        $this->arr_campos = array('n' =>'Numerador','d'=>'Denominador','r'=>'Resultado');
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
    }

    public function indexAction()
    {
        // action body
    }

    public function showAction()
    {
        $id = $this->_getParam ( 'id' );
        		if (! $id) {
        			$msg = "id não informado";
        			$this->_redirect ( '/error/notfound/msg/' . $msg );
        		}
        $this->view->indicador = $this->indicadores->find ( $id )->current ();
        $this->view->indicadores_configs = $this->view->indicador->findDependentRowset('Model_IndicadoresConfiguracoes');
		$this->view->arr_campos = $this->arr_campos;

        
    }
    
	public function graficoAction()
	{
		$indicador_configuracao_id = $this->_getParam('indicador_configuracao_id');
    	
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $resultados = new Model_IndicadoresResultados();
        
        $indicadores_resultados = new Model_IndicadoresResultados();
        
        $dados = array();
        foreach($indicadores_resultados->fetchAll('indicador_configuracao_id='.$indicador_configuracao_id, 'competencia') as $resultado){
        	$competencia = $resultado->competencia;
        	if(strlen($competencia)>4)
                $competencia =substr ( $competencia,4,2)."/".substr ( $competencia, 0, 4 );
        	
        	$dados[$competencia] = number_format($resultado->resultado,2);
        }
		
        
        $pathfont = $_SERVER['DOCUMENT_ROOT'].$this->view->baseUrl();
        
		$graph = new ezcGraphLineChart();
		$graph->driver = new ezcGraphGdDriver();
		$graph->options->font ="$pathfont/verdana.ttf";
		$graph->options->font->name ='verdana.ttf'; 
		$graph->driver->options->supersampling = 1;
		$graph->driver->options->jpegQuality = 100;
		$graph->driver->options->imageFormat = IMG_JPEG;
		
		 // Add data
		
		$graph->data[]= new ezcGraphArrayDataSet( $dados );
		
		echo $graph->renderToOutput( 400, 150 );

		
	}

}
