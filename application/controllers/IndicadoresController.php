<?php

class IndicadoresController extends Zend_Controller_Action
{

    /**
     * @var Model_Indicadores $indicadores Model_Indicadores()
     * 
     */
    private $indicadores = null;

    /**
     * @var Model_IndicadoresConfiguracoes $indicadores_configs
     * Model_IndicadoresConfiguracoes()
     * 
     */
    private $indicadores_configs = null;
    private $arr_campos = array();

    public function init()
    {
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('localizar', 'json')
                	->addActionContext('add',array('json','xml'))
                	->addActionContext('addObjetivo',array('json','xml'))
                            ->initContext();  
        /* Initialize action controller here */
        $this->indicadores = new Model_Indicadores ( );
        $this->arr_campos = array('n' =>'Numerador','d'=>'Denominador','r'=>'Resultado');
    }

    public function indexAction()
    {
        $this->view->indicadores = $this->indicadores->fetchAll ( null, 'id' );
    }

    public function editAction()
    {
        $id = $this->_getParam ( 'id' );
        if (! $id) {
        	$msg = "id não informado";
        	$this->_redirect ( '/error/notfound/msg/' . $msg );
        }
        $indicador_configuracao_id = $this->_getParam('indicador_configuracao_id');
    	if (! $indicador_configuracao_id) {
        	$msg = "indicador_configuracao_id não informado";
        	$this->_redirect ( '/error/notfound/msg/' . $msg );
        }
        $this->view->indicador = $this->indicadores->find ( $id )->current ();
        $this->view->indicador_configuracao_id = $indicador_configuracao_id;
        $indicadores_configuracoes = new Model_IndicadoresConfiguracoes();
        $indicador_configuracao = $indicadores_configuracoes->fetchRow("id=$indicador_configuracao_id");

        
        $this->view->campos = array();
        $this->view->colnames = "";
        $this->view->colmodels = "";
        $campos =explode(",",$indicador_configuracao->campos);
        foreach ($campos as $k)
        {
            $nomecampo = strtolower($this->arr_campos[$k]);
        	$this->view->campos[$k] = $this->arr_campos[$k];
            $this->view->colnames .=",'".ucfirst($nomecampo)."'";
            $model = ",{name:'".$nomecampo."',index:'".$nomecampo."', width:80, align:'right', editable:true, editrules:{number:true}}";
            $this->view->colmodels .=$model;
        }
        if(!in_array('r',$campos) && in_array('d',$campos)){
        	$this->view->colnames .=",'Resultado'";
        	$model = ",{name:'resultado',index:'resultado', width:80, align:'right', editable:false}";
            $this->view->colmodels .=$model;
        }
        $this->view->indicador_configuracao = $indicador_configuracao;
        
        
        
        
    }

    public function deleteAction()
    {
        
    }

    public function localizarAction()
    {
    	$indicador_configuracao_id = $this->_getParam('indicador_configuracao_id');
    	
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $resultados = new Model_IndicadoresResultados();
        
        $indicadores_configuracoes = new Model_IndicadoresConfiguracoes();
        $indicador_configuracao = $indicadores_configuracoes->fetchRow('id='.$indicador_configuracao_id);
        
        $response = array();
        $response['page'] = 1; 
        $response['total'] = 1; 
        $response['records'] = 10;
        
        $campos = explode(",",$indicador_configuracao->campos);
        $i=0; 
        foreach ($resultados->fetchAll('indicador_configuracao_id='.$indicador_configuracao_id,'competencia') as $row) 
        { 
        		
        	$response['rows'][$i]['id']=$row->id;
        	
        	if($indicador_configuracao->tipo_periodo_id==1){
        		$competencia =substr ( $row->competencia,4,2)."/".substr ( $row->competencia, 0, 4 );
        		
        	}else{
        		$competencia = $row->competencia;
        	}
        	
		 
        	$cell =  array($row->id,$competencia);
        	foreach ($campos as $k)
        	{
        		$nomecampo = strtolower($this->arr_campos[$k]);
        		$cell[]=$row->$nomecampo;
        	}

	        if(!in_array('r',$campos) && in_array('d',$campos)){
                $cell[]=$row->resultado;
	        }
        	
        	$response['rows'][$i]['cell']=$cell; 
        	$i++; 
        	
        } 		
        
        $this->_helper->json($response);
    }

    public function salvarAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $resultados = new Model_IndicadoresResultados();
        
        $dados = array(  "competencia"=> $this->_getParam('competencia') );
        try{
        	if($this->getRequest()->isPost ()){
        		
	        	$id =$this->_getParam('id');
	        	
	        	if($id != '_empty')
	        	{
	        		$resultado = $resultados->find($id)->current();
	        		$indicador_configuracao_id = $resultado->indicador_configuracao_id;
	        	}else{
	        		$indicador_configuracao_id  = $this->_getParam('indicador_configuracao_id');
	        	}
	        	
	        	$indicadores_configuracoes = new Model_IndicadoresConfiguracoes();
	        	$indicador_configuracao = $indicadores_configuracoes->find($indicador_configuracao_id)->current();
	            $campos = explode(",",$indicador_configuracao->campos);
	        	foreach ($campos as $k)
                {
                	$nomecampo = strtolower($this->arr_campos[$k]);
                	$dados[$nomecampo] = $this->_getParam($nomecampo);
                }
	        	if(!in_array('r',$campos))
	        	{
	        		$dados['resultado']=($dados['numerador']/$dados['denominador'])*$indicador_configuracao->base;
	        	}
	        	
	        	if($id=='_empty')
	            {
	                $dados['indicador_configuracao_id'] = $this->_getParam('indicador_configuracao_id');
	                $id = $resultados->insert($dados);
	            }else{
	                $resultados->update($dados, "id=".$id);
	            }// action body
	            $dados['id']= $id;
	            $ret = array('status'=>'Ok', $dados);	
        	}
        	
        }catch (Zend_Db_Statement_Exception  $e){
        	
        	
        	$ret = array('status'=>'error','message'=>$e->getMessage(),
        				'file'=>$e->getFile(), 'code'=>$e->getCode());
        	
        }
        echo $this->_helper->json($ret);
    }

    public function configurarAction()
    {
        $this->indicadores_configs = new Model_IndicadoresConfiguracoes();
        $form = new Form_IndicadorConfig();
        $id = $this->_getParam ( 'id',null );
        $indicador_id = $this->_getParam('indicador_id',null);
        
        if ($this->getRequest()->isPost ()) 
        {
        	$formData = $this->getRequest ()->getPost ();
        	if ($form->isValid ( $formData )) 
        	{
        		$id = $form->getValue('id');
        		
        		$dados = $form->getDados ();
        	
        		if($form->getValue('id')==''){
        			$id =$this->indicadores_configs->insert ( $dados );
        		}else{
        			$this->indicadores_configs->update($dados, 'id='.$id );
        		}
        		$indicador_config = $this->indicadores_configs->fetchRow('id='.$id );
        		$indicador_id = $indicador_config->indicador_id;
        		$this->view->indicador_config = $indicador_config;
        		$form->submit->setAttrib('class','byajax');
        					
        	}else{
        		
        		$form->populate ( $formData );
        	}
        }else{ 
        	
            if ($id && !$indicador_id) 
            {
	            $indicador_config = $this->indicadores_configs->fetchRow('id='.$id );
	            $form->submit->setAttrib('class','byajax');
	            
	            $dados = array ('base'     => $indicador_config ->base, 
                      'indicador_id'=>$indicador_config->indicador_id,
                      'tipo_periodo_id'=>$indicador_config->tipo_periodo_id,
                      'campos'=> explode(',', $indicador_config->campos),
                      'ano'=> $indicador_config->ano,
	                  'mes'=> $indicador_config->mes                
                      );
	        	$form->alterarcategoriapopulate ( $dados );
	        	$this->view->indicador = $indicador_config->findParentRow('Model_Indicadores');
            
            }elseif ($indicador_id)
            {
	            $this->view->indicador = $this->indicadores->find ( $indicador_id )->current ();
	            $form->indicador_id->setValue($this->view->indicador->id);
	            $form->submit->setAttrib('class','byajax');
        
            }else
            {
	        	$msg = "id não informado";
	        	$this->_redirect ( '/error/notfound/msg/' . $msg );
            }
        }
        $this->view->indicador = $this->indicadores->find($indicador_id)->current();
        $form->indicador_id->setValue($indicador_id);
        $this->view->form = $form;
        $session = new Zend_Session_Namespace('back_indicador');
        $this->view->uralterarcategorialback = $session->url;
    }

    public function removerconfiguracaoAction()
    {
        $id = $this->_getParam('id');
        		if($id){
        			$this->indicadores_configs = new Model_IndicadoresConfiguracoes();
        			$ic = $this->indicadores_configs->find($id)->current();
        			$ic->situacao_id=2;
    	}
    }


    
    
    public function configurarqualitativosAction()
    {
        $this->opcoes_qualitativos = new Model_OpcoesQualitativos();
        $form = new Form_OpcoesQualitativos();
        $id = $this->_getParam ( 'id',null );
        $indicador_id = $this->_getParam('indicador_id',null);
        
        if ($this->getRequest()->isPost ()) 
        {
        	$formData = $this->getRequest ()->getPost ();
        	if ($form->isValid ( $formData )) 
        	{
        		$id = $form->getValue('id');
        		
        		$dados = $form->getDados ();
        	
        		if($form->getValue('id')==''){
        			$id =$this->opcoes_qualitativos->insert ( $dados );
        		}else{
        			$this->opcoes_qualitativos->update($dados, 'id='.$id );
        		}
        		$opcao_qualitativo = $this->opcoes_qualitativos->fetchRow('id='.$id );
        		$indicador_id = $opcao_qualitativo->indicador_id;
        		$this->view->opcao_qualitativo = $opcao_qualitativo;
        		$form = new Form_OpcoesQualitativos();
        	}else{
        		
        		$form->populate ( $formData );
        	}
        }else{ 
        	
            if ($id && !$indicador_id) 
            {
	            $opcao_qualitativo = $this->indicadores_configs->fetchRow('id='.$id );
	            
	            
	        	$form->populate ( $opcao_qualitativo->toArray() );
	        	$this->view->indicador = $opcao_qualitativo->findParentRow('Model_Indicadores');
            
            }elseif ($indicador_id)
            {
	            $this->view->indicador = $this->indicadores->find ( $indicador_id )->current ();
	            $form->indicador_id->setValue($this->view->indicador->id);
            }else
            {
	        	$msg = "id não informado";
	        	$this->_redirect ( '/error/notfound/msg/' . $msg );
            }
        }
        $this->view->indicador = $this->indicadores->find($indicador_id)->current();
        $form->indicador_id->setValue($indicador_id);
        $this->view->form = $form;
        
        $session = new Zend_Session_Namespace('back_indicador');
        $this->view->urlback = $session->url;
    }  
    public function alterarcategoriaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $opcoes_qualitativos = new Model_OpcoesQualitativos();
        $indicadores_qualitativos = new Model_IndicadoresQualitativos();
        
        $categoria_id = $this->_getParam('categoria_id');
        
        $opcao_qualitativo = $opcoes_qualitativos->fetchRow('id='.$categoria_id);
        
        $indicador_qualitativo = $indicadores_qualitativos->fetchRow('indicador_id='.$opcao_qualitativo->indicador_id);
        
        if($indicador_qualitativo){
        	$indicador_qualitativo->opcao_qualitativo_id = $opcao_qualitativo->id;
        }else{
        	$data = array('indicador_id'=>$opcao_qualitativo->indicador_id,'opcao_qualitativo_id'=>$opcao_qualitativo->id );
        	$indicadores_qualitativos->insert($data);
        }
        $response = array('id'=>$opcao_qualitativo->id,'categoria'=>$opcao_qualitativo->descricao);
        $this->_helper->json($response);    	
    }  
    
}



