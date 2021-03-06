<?php

class RelatoriosController extends Zend_Controller_Action {
	private $form;	
	public function init() {
        /* Initialize action controller here */		
    	$this->form = new Form_Relatoriosgestao();
		if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
	}
	
	public function indexAction() {
		
	}

	/*
	 * editgestao
	 * 
	 * edição do relatório de gestão.
	 */
	public function editgestaoAction() {
		$this->form = new Form_Relatoriosgestao();
    	$this->view->form = $this->form;
    	$this->view->programa = new Model_Programas();
    	$this->view->projeto = new Model_Projetos();
		$this->view->subprojeto = new Model_Projetos();
		$this->view->objetivoespecifico = new Model_ObjetivosEspecificos();
		$this->view->meta = new Model_Metas();
	}

	/*
	 * Salvando relatório de Gestão
	 */
	public function savegestaoAction()
    {	
    	$this->view->form = $this->form;
    	
		if ($this->getRequest ()->isPost ()) {
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) 
			{
				$metas = new Model_Metas();
				foreach($formData as $key => $val){
					if (substr($key,0,5)=="metar"){
						$meta_id = str_replace("metar", "", $key);
						$indice_realizado = $key;
						$indice_texto = str_replace("metar", "metat", $key);
						$dados = array("realizado" => $formData[$indice_realizado], "justificativa" => $formData[$indice_texto]);
						$metas->update($dados, "id=" . $meta_id);
					}
				}
	    		$this->_redirect('relatorios/editgestao');
			}else{
				$this->form->populate ( $formData );
			}			
		}
	}
	

	/*
	 * relatoriogestao
	 * 
	 * impressão do relatório de gestão.
	 */
	public function relatoriogestaoAction() {
		$this->view->imprimir = "não";
		$this->view->programa = new Model_Programas();
    	$this->view->projeto = new Model_Projetos();
		$this->view->subprojeto = new Model_Projetos();
		$this->view->objetivoespecifico = new Model_ObjetivosEspecificos();
		$this->view->meta = new Model_Metas();
		$this->render('relatoriogestao');
	}
	
	public function relatoriogestaoprintAction(){
		$this->view->imprimir = "sim";
		$this->_helper->layout()->disableLayout();
		$this->view->programa = new Model_Programas();
    	$this->view->projeto = new Model_Projetos();
		$this->view->subprojeto = new Model_Projetos();
		$this->view->objetivoespecifico = new Model_ObjetivosEspecificos();
		$this->view->meta = new Model_Metas();
		$this->render('relatoriogestao');
	}
	
	
	
	/*
	 * Relatório do plano
	 */
	public function relatorioplanoAction() {
		$this->form = new Form_Relatoriosplano();

		$this->view->imprimir = "não";
		$this->view->programa = new Model_Programas();
		$this->view->responsavel = new Model_Usuarios();
		$this->view->objetivoprograma = new Model_ObjetivosPrograma();
		$this->view->metaprograma = new Model_MetasPrograma();		
		$this->view->indicadorprograma = new Model_IndicadoresPrograma();
		$this->view->projeto = new Model_Projetos();
		$this->view->objetivoprojeto = new Model_ObjetivosProjeto();
		$this->view->metaprojeto = new Model_MetasProjeto();
		$this->view->indicadorprojeto = new Model_IndicadoresProjeto();
		$this->view->subprojeto = new Model_Projetos();		
		$this->view->objetivosubprojeto = new Model_ObjetivosProjeto();
		$this->view->metasubprojeto = new Model_MetasProjeto();
		$this->view->indicadorsubprojeto = new Model_IndicadoresProjeto();
		$this->view->objetivoespecifico = new Model_ObjetivosEspecificos();
		$this->view->atividade = new Model_Atividades();
		$this->view->atividadeprazo = new Model_AtividadesPrazo();
		$this->view->form = $this->form;		
	}

	public function relatorioplanoprintAction() {
		$this->form = new Form_Relatoriosplano();

		$this->view->imprimir = "sim";
		$this->_helper->layout()->disableLayout();
		$this->view->programa = new Model_Programas();
		$this->view->responsavel = new Model_Usuarios();
		$this->view->objetivoprograma = new Model_ObjetivosPrograma();
		$this->view->metaprograma = new Model_MetasPrograma();		
		$this->view->indicadorprograma = new Model_IndicadoresPrograma();
		$this->view->projeto = new Model_Projetos();
		$this->view->objetivoprojeto = new Model_ObjetivosProjeto();
		$this->view->metaprojeto = new Model_MetasProjeto();
		$this->view->indicadorprojeto = new Model_IndicadoresProjeto();
		$this->view->subprojeto = new Model_Projetos();		
		$this->view->objetivosubprojeto = new Model_ObjetivosProjeto();
		$this->view->metasubprojeto = new Model_MetasProjeto();
		$this->view->indicadorsubprojeto = new Model_IndicadoresProjeto();
		$this->view->objetivoespecifico = new Model_ObjetivosEspecificos();
		$this->view->atividade = new Model_Atividades();
		$this->view->atividadeprazo = new Model_AtividadesPrazo();
		$this->view->form = $this->form;
		$this->render('relatorioplano');
	}
	
	
	
	/*
	 * Relatório de Atividades com Responsável
	 */
	public function relatorioatividaderesponsavelAction() {

    	$this->form = new Form_Relatoriosatividaderesponsavel();
		$this->view->imprimir = "não";
    	$this->view->programa = new Model_Programas();
		$this->view->responsavel = new Model_Usuarios();
		$this->view->objetivoprograma = new Model_ObjetivosPrograma();
		$this->view->metaprograma = new Model_MetasPrograma();		
		$this->view->indicadorprograma = new Model_IndicadoresPrograma();
		$this->view->projeto = new Model_Projetos();
		$this->view->objetivoprojeto = new Model_ObjetivosProjeto();
		$this->view->metaprojeto = new Model_MetasProjeto();
		$this->view->indicadorprojeto = new Model_IndicadoresProjeto();
		$this->view->subprojeto = new Model_Projetos();		
		$this->view->objetivosubprojeto = new Model_ObjetivosProjeto();
		$this->view->metasubprojeto = new Model_MetasProjeto();
		$this->view->indicadorsubprojeto = new Model_IndicadoresProjeto();
		$this->view->objetivoespecifico = new Model_ObjetivosEspecificos();
		$this->view->atividade = new Model_Atividades();
		$this->view->atividadeprazo = new Model_AtividadesPrazo();
		$this->view->form = $this->form;		
   	}

	public function relatorioatividaderesponsavelprintAction() {

    	$this->form = new Form_Relatoriosatividaderesponsavel();
		$this->view->imprimir = "sim";
		$this->_helper->layout()->disableLayout();
    	$this->view->programa = new Model_Programas();
		$this->view->responsavel = new Model_Usuarios();
		$this->view->objetivoprograma = new Model_ObjetivosPrograma();
		$this->view->metaprograma = new Model_MetasPrograma();		
		$this->view->indicadorprograma = new Model_IndicadoresPrograma();
		$this->view->projeto = new Model_Projetos();
		$this->view->objetivoprojeto = new Model_ObjetivosProjeto();
		$this->view->metaprojeto = new Model_MetasProjeto();
		$this->view->indicadorprojeto = new Model_IndicadoresProjeto();
		$this->view->subprojeto = new Model_Projetos();		
		$this->view->objetivosubprojeto = new Model_ObjetivosProjeto();
		$this->view->metasubprojeto = new Model_MetasProjeto();
		$this->view->indicadorsubprojeto = new Model_IndicadoresProjeto();
		$this->view->objetivoespecifico = new Model_ObjetivosEspecificos();
		$this->view->atividade = new Model_Atividades();
		$this->view->atividadeprazo = new Model_AtividadesPrazo();
		$this->view->form = $this->form;		
		$this->render('relatorioatividaderesponsavel');
		
	}
   	

}
?>