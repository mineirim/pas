
<?php

class InstrumentosController extends Zend_Controller_Action {

	public function init() {
            $ajaxContext = $this->_helper->ajaxContext;
            $ajaxContext->setAutoJsonSerialization(false);
            $ajaxContext->addActionContext('xxgantt', array('xml','html'))
                    ->initContext();
            if ($this->_request->isXmlHttpRequest ())
                    $this->_helper->layout ()->disableLayout ();
	}

	/**
	 * Lista todos os programas
	 *
	 */
	public function indexAction() {
		$programas = new Model_Programas ();
		$this->view->programas = $programas->fetchAll ( "situacao_id=1", 'ordem' );
		$this->view->nivel = 'Programas';
	}

	public function programaAction() {
		$projetos = new Model_Projetos ();
		if ($this->_hasParam ( 'programa_id' )) {
			$programas = new Model_Programas ();
			$programa_id = $this->_getParam ( 'programa_id', 0 );
			$this->view->projetos = $projetos->fetchAll ( 'programa_id=' . $programa_id . 'and situacao_id=1 and projeto_id is null', 'ordem' );
			$this->view->programa = $programas->fetchRow ( "id=" . $programa_id );
			$this->view->nivel = 'Programa';
			$this->view->tableheader = 'Projetos';
		}
		$this->view->parent_id = $programa_id;
		$this->view->nivel_id = 2;
	}

	public function projetoAction() {
		$projetos = new Model_Projetos ();
		$objetivos_especificos = new Model_ObjetivosEspecificos ();
		if ($this->_hasParam ( 'projeto_id' )) {
			$projeto_id = $this->_getParam ( 'projeto_id', 0 );
			$this->view->projeto = $projetos->fetchRow ( 'id=' . $projeto_id, 'id' );
			$this->view->projetos = $projetos->fetchAll ( 'projeto_id=' . $projeto_id . 'and situacao_id=1', 'id' );
			$this->view->objetivos_especificos = $objetivos_especificos->fetchAll ( 'projeto_id=' . $projeto_id . 'and situacao_id=1', 'id' );
			$this->view->programa = $this->view->projeto->findParentRow ( 'Model_Programas' );
			$this->view->nivel = 'Projeto';
			$this->view->tableheader = 'Subprojetos';
		}
		$this->view->parent_id = $projeto_id;
		$this->view->nivel_id = 4;
		$this->render ( 'programa' );
	}
	public function objetivoEspecificoAction() {
		$metas = new Model_Metas ();
		$objetivosEspecificos = new Model_ObjetivosEspecificos ();
		if ($this->_hasParam ( 'objetivo_especifico_id' )) {
			$objetivo_especifico_id = $this->_getParam ( 'objetivo_especifico_id', 0 );
			$this->view->objetivo_especifico = $objetivosEspecificos->fetchRow ( 'id=' . $objetivo_especifico_id, 'ordem' );
			$this->view->metas = $metas->fetchAll ( 'objetivo_especifico_id=' . $objetivo_especifico_id . 'and situacao_id=1', 'id' );
			$this->view->projeto = $this->view->objetivo_especifico->findParentRow ( 'Model_Projetos' );
			$this->view->programa = $this->view->projeto->findParentRow ( 'Model_Programas' );
			$this->view->nivel = 'ObjetivoEspecifico';
			$this->view->tableheader = 'Objetivos Especificos';
			$this->view->parent_id = $objetivo_especifico_id;
			$this->view->nivel_id = 5;
		} else
			echo $this->dispatch ( 'programasAction' );

	}

	public function metaAction() {
		$metas = new Model_Metas ();
		$operacoes = new Model_Operacoes ();
		if ($this->_hasParam ( 'meta_id' )) {
			$meta_id = $this->_getParam ( 'meta_id', 0 );
			$this->view->meta = $metas->fetchRow ( 'id=' . $meta_id, 'id' );
			$this->view->operacoes = $operacoes->fetchAll ( 'meta_id=' . $meta_id . ' and situacao_id=1', 'id' );

			$this->view->objetivo_especifico = $this->view->meta->findParentRow ( 'Model_ObjetivosEspecificos' );
			$this->view->projeto = $this->view->objetivo_especifico->findParentRow ( 'Model_Projetos' );
			$this->view->programa = $this->view->projeto->findParentRow ( 'Model_Programas' );
			$this->view->nivel = 'Meta';
			$this->view->tableheader = 'Metas';
			$this->view->parent_id = $meta_id;
			$this->view->nivel_id = 6;
		} else
			echo $this->dispatch ( 'programasAction' );
	}

	public function operacaoAction() {
		$operacoes = new Model_Operacoes ();
		$atividades = new Model_Atividades ();
		$atividadesprazo = new Model_AtividadesPrazo ();
		if ($this->_hasParam ( 'operacao_id' )) {
			$operacao_id = $this->_getParam ( 'operacao_id', 0 );
			$this->view->operacao = $operacoes->fetchRow ( 'id=' . $operacao_id, 'id' );
			$this->view->atividades = $atividades->fetchAll ( 'operacao_id=' . $operacao_id . ' and situacao_id=1', 'id' );
			$this->view->atividadeprazo = $atividadesprazo;

			$this->view->meta = $this->view->operacao->findParentRow ( 'Model_Metas' );

			$this->view->objetivo_especifico = $this->view->meta->findParentRow ( 'Model_ObjetivosEspecificos' );
			$this->view->projeto = $this->view->objetivo_especifico->findParentRow ( 'Model_Projetos' );
			$this->view->programa = $this->view->projeto->findParentRow ( 'Model_Programas' );
			$this->view->nivel = 'Operação';
			$this->view->tableheader = 'Operacoes';
			$this->view->parent_id = $operacao_id;
			$this->view->nivel_id = 7;
		} else
			echo "erro";
	}

	public function atividadeAction() {
		$operacoes = new Model_Operacoes ();
		$atividades = new Model_Atividades ();
		$atividadesprazo = new Model_AtividadesPrazo ();
		$atividadesvinculadas = new Model_AtividadesVinculadas ();
		if ($this->_hasParam ( 'atividade_id' )) {
			$atividade_id = $this->_getParam ( 'atividade_id', 0 );
			$this->view->atividades = $atividades;
			$this->view->atividade = $atividades->fetchRow ( 'id=' . $atividade_id, 'id' );
			$this->view->atividadeprazo = $atividadesprazo->fetchAll ( 'atividade_id=' . $atividade_id, 'id ASC' );
			$this->view->atividadevinculada = $atividadesvinculadas->fetchAll ( 'atividade_id=' . $atividade_id, 'id ASC' );
			$inicio = new Zend_Date ( $this->view->atividade->inicio_data, Zend_Date::ISO_8601 );

			$prazo = new Zend_Date ( $this->view->atividade->prazo_data, Zend_Date::ISO_8601 );

			$this->view->atividade->inicio_data = $inicio->toString ( 'dd/MM/yyyy' );
			$this->view->atividade->prazo_data = $prazo->toString ( 'dd/MM/yyyy' );

			$this->view->operacao = $this->view->atividade->findParentRow ( 'Model_Operacoes' );
			$this->view->meta = $this->view->operacao->findParentRow ( 'Model_Metas' );
			$this->view->objetivo_especifico = $this->view->meta->findParentRow ( 'Model_ObjetivosEspecificos' );
			$this->view->projeto = $this->view->objetivo_especifico->findParentRow ( 'Model_Projetos' );
			$this->view->programa = $this->view->projeto->findParentRow ( 'Model_Programas' );
			$this->view->nivel = 'Atividade';
			$this->view->tableheader = 'Atividades';
			$this->view->resource = "atividades";

		} else {

			echo $this->dispatch ( 'programasAction' );

		}
	}
	public function ganttAction()
	{
            $this->getResponse()
                ->setHeader('Content-type', 'text/xml');
            $this->_helper->layout ()->disableLayout ();
            //$this->_helper->viewRenderer->setNoRender(true);
            $meta_id = $this->_getParam('meta_id');
            $model_operacoes = new Model_Operacoes();
            $operacoes = $model_operacoes->fetchAll("meta_id=$meta_id and situacao_id=1");
            
            $xmlString = '<project>';
            $task = '';
            foreach ($operacoes as $operacao) {
                
                $task .= '<task>';
                $task .= "<pID>$operacao->id</pID>";
                $task .= "<pName>$operacao->descricao</pName>";
                $task .= "<pStart> </pStart>";
                $task .= "<pEnd> </pEnd>";
                $task .= "<pColor>0000ff</pColor>";
                $task .= "<pLink>/xx</pLink>";
                $task .= "<pMile>0</pMile>";
                $task .= "<pRes>Setor Responsável</pRes>";
                $task .= "<pComp>0</pComp>";
                $task .= "<pGroup>1</pGroup>";
                $task .= "<pParent>0</pParent>";
                $task .= "<pOpen>1</pOpen>";
                $task .= "<pDepend/>";
                $task .= '</task>';
                $lst='';
                foreach ($operacao->findModel_Atividades() as $atividade){
                    $data_inicio = new Zend_Date($atividade->inicio_data, Zend_Date::ISO_8601);
                    
                    $data_final = new Zend_Date($atividade->prazo_data, Zend_Date::ISO_8601);
                    
                    $task .= '<task>';
                    $task .= "<pID>$atividade->id</pID>";
                    $task .= "<pName>$atividade->descricao </pName>";
                    $task .= "<pStart>$data_inicio</pStart>";
                    $task .= "<pEnd>$data_final</pEnd>";
                    $task .= "<pColor>ff00ff</pColor>";
                    $task .= "<pLink>/xx</pLink>";
                    $task .= "<pMile>0</pMile>";
                    $task .= "<pRes/>";
                    $task .= "<pComp>80</pComp>";
                    $task .= "<pGroup>0</pGroup>";
                    $task .= "<pParent>$operacao->id</pParent>";
                    $task .= "<pOpen>1</pOpen>";
                    $task .= "<pDepend></pDepend>";
                    $task .= '</task>';
                    
                }
            }
            
            $xmlString .= $task."</project>";
            //echo trim("<project> <task> <pID>10</pID> <pName>WCF Changes</pName> <pStart></pStart> <pEnd></pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes></pRes> <pComp>0</pComp> <pGroup>1</pGroup> <pParent>0</pParent> <pOpen>1</pOpen> <pDepend /> </task> <task> <pID>20</pID> <pName>Move to WCF from remoting</pName> <pStart>8/11/2008</pStart> <pEnd>8/15/2008</pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes>Rich</pRes> <pComp>10</pComp> <pGroup>0</pGroup> <pParent>10</pParent> <pOpen>1</pOpen> <pDepend></pDepend> </task> <task> <pID>30</pID> <pName>add Auditing</pName> <pStart>8/19/2008</pStart> <pEnd>8/21/2008</pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes>Mal</pRes> <pComp>50</pComp> <pGroup>0</pGroup> <pParent>10</pParent> <pOpen>1</pOpen> <pDepend>20</pDepend> </task> </project>");
            //$ret= "<project> <task> <pID>10</pID> <pName>WCF Changes</pName> <pStart></pStart> <pEnd></pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes></pRes> <pComp>0</pComp> <pGroup>1</pGroup> <pParent>0</pParent> <pOpen>1</pOpen> <pDepend /> </task> <task> <pID>20</pID> <pName>Move to WCF from remoting</pName> <pStart>8/11/2008</pStart> <pEnd>8/15/2008</pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes>Rich</pRes> <pComp>10</pComp> <pGroup>0</pGroup> <pParent>10</pParent> <pOpen>1</pOpen> <pDepend></pDepend> </task> <task> <pID>30</pID> <pName>add Auditing</pName> <pStart>8/19/2008</pStart> <pEnd>8/21/2008</pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes>Mal</pRes> <pComp>50</pComp> <pGroup>0</pGroup> <pParent>10</pParent> <pOpen>1</pOpen> <pDepend>20</pDepend> </task> </project>";

            $this->view->myxml = trim($xmlString);
	}
}