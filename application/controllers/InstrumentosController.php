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
		$model_operacoes = new Model_Operacoes ();
		$model_atividades = new Model_Atividades ();
		
		$model_atividades_historico = new Model_AtividadesHistorico();
		if ($this->_hasParam ( 'operacao_id' )) {
			$operacao_id = $this->_getParam ( 'operacao_id', 0 );
			$this->view->operacao = $model_operacoes->fetchRow ( 'id=' . $operacao_id, 'id' );
			$this->view->atividades = $model_atividades->fetchAll ( 'operacao_id=' . $operacao_id . ' and situacao_id=1', 'id' );
			$this->view->select_historico = $model_atividades_historico->select();
			$this->view->select_historico->where('situacao_id=1');
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
		$model_operacoes = new Model_Operacoes ();
		$model_atividades = new Model_Atividades ();
		$model_atividades_historico = new Model_AtividadesHistorico();
		$model_atividadesvinculadas = new Model_AtividadesVinculadas ();
		if ($this->_hasParam ( 'atividade_id' )) {
			$atividade_id = $this->_getParam ( 'atividade_id', 0 );
			$this->view->atividade 			= $model_atividades->fetchRow ( 'id=' . $atividade_id, 'id' );
			$this->view->atividade_historico= $model_atividades_historico->fetchAll ( 'atividade_id=' . $atividade_id, 'id ASC' );
			$this->view->atividadevinculada = $model_atividadesvinculadas->fetchAll ( 'situacao_id=1 and atividade_id=' . $atividade_id, 'id ASC' );
			$situacao_atual = $model_atividades_historico->fetchCurrentRow($atividade_id);
			$this->view->situacao_atual		= $situacao_atual;
			$this->view->operacao 			= $this->view->atividade->findParentRow ( 'Model_Operacoes' );
			$this->view->meta 				= $this->view->operacao->findParentRow ( 'Model_Metas' );
			$this->view->objetivo_especifico= $this->view->meta->findParentRow ( 'Model_ObjetivosEspecificos' );
			$this->view->projeto 			= $this->view->objetivo_especifico->findParentRow ( 'Model_Projetos' );
			$this->view->programa 			= $this->view->projeto->findParentRow ( 'Model_Programas' );
			$this->view->nivel 				= 'Atividade';
			$this->view->tableheader 		= 'Atividades';
			$this->view->resource 			= "atividades";

			$mysession = new Zend_Session_Namespace ( 'mysession' );
			$acl = $mysession->acl;
			$auth = Zend_Auth::getInstance();
			if ($auth->hasIdentity ()) {
				$role = $auth->getIdentity ()->username;
			} else {
				$role = 'guest';
			}
			$this->view->toolbar = "barr";
                        $resource = 'concluir';
                        if (! $acl->has ( $resource ))
                                $resource = null;

                        if($acl->isAllowed($role,$resource) ||
                                        !$resource){
                                $this->view->mybar = "<a href='".$this->view->url(array('controller'=>'atividades','action'=>'update', 'module'=>'programacao', 'id'=>$this->view->atividade->id))."'
                                                title='Editar'
                                                class='fg-button ui-state-default fg-button-icon-left ui-corner-all ajax-form-load'>
                                                <span class='ui-icon ui-icon-check'>Editar</span>Editar</a>";
                        }

			
			/**	
		// *** só é possível adicionar prazos quando a atividade ainda não foi concluida.
			if (!$this->situacao_atual->data_conclusao){
				?>
				<tr>
				<td colspan="2">
				<?php 
				// verificando se usuário pode adicionar prazo.
				$resource = 'addprazo';
				if (! $acl->has ( $resource )) 
					$resource = null;
					
				if($acl->isAllowed($role,$resource) ||
						!$resource){ 
					echo "<a href='".$this->url(array('controller'=>'atividades','action'=>'addprazo', 'id'=>$this->atividade->id))."'
							title='Adicionar Prazo' 
							class='fg-button ui-state-default fg-button-icon-left ui-corner-all'>
							<span class='ui-icon ui-icon-plus'>Adicionar Prazo</span>Adicionar Prazo</a>";
				} // if do acl.
				?>
				</td>
				</tr>
				<?php 
			} // if
			
				// verificando se usuário pode adicionar vinculação.
				$resource = 'addvinculacao';
				if (! $acl->has ( $resource )) 
					$resource = null;
					
				if($acl->isAllowed($role,$resource) ||
						!$resource){ 
						echo "<a href='".$this->url(array('controller'=>'atividades','action'=>'addvinculacao', 'id'=>$this->atividade->id))."'
							title='Adicionar Vinculação' 
							class='fg-button ui-state-default fg-button-icon-left ui-corner-all'>
							<span class='ui-icon ui-icon-plus'>Adicionar Vinculação</span>Adicionar Vinculação</a>";
				}
						
			*/
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
            $model_atividades = new Model_Atividades();
            $model_atividades_historico = new Model_AtividadesHistorico();
            $model_atividades_vinculadas = new Model_AtividadesVinculadas();
            
            //$select_atividades = $model_atividades->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
            
            
            $operacoes = $model_operacoes->fetchAll("meta_id=$meta_id and situacao_id=1");
            
            $xmlString = '<project>';
            $task = '';
            foreach ($operacoes as $operacao) {
                $opid = (int)$operacao->id +600000;
                $task .= '<task>';
                $task .= "<pID>$opid</pID>";
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
                $select_atividades = $model_atividades->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
				$select_atividades->setIntegrityCheck(false)
			       ->where('atividades.situacao_id = 1')
			       ->join(Zend_Registry::get('schema').'.atividades_historico', 'atividades_historico.atividade_id = atividades.id', 'data_inicio')
			       ->where('atividades_historico.situacao_id=1')
			       ->order('atividades_historico.data_inicio');
                 
                foreach ($operacao->findModel_Atividades($select_atividades) as $atividade){
                	if($atividade->situacao_id !==1)
                		continue;
					$select_historico = $model_atividades_historico->select();
            		$select_vinculadas = $model_atividades_vinculadas->select();                		
					$select_historico->reset('where');
					$select_historico->where('situacao_id=1');
                	$historico = $atividade->findModel_AtividadesHistorico($select_historico)->current();	
                	
                    $data_inicio = $historico->data_inicio();
                    $data_final = $historico->data_prazo();
                    
                    $select_vinculadas->reset('where');
                    $select_vinculadas->where('situacao_id=1');
                    $vinculadas = $model_atividades_vinculadas->fetchAll('situacao_id=1 and atividade_id='.$atividade->id);
                    $str_vinculadas =array();
                    foreach ($vinculadas as $vinculo){
                    	$str_vinculadas[] = $vinculo->depende_atividade_id;
                    }
                    $str_vinculadas = implode(',', $str_vinculadas);
                    
                    $task .= '<task>';
                    $task .= "<pID>$atividade->id</pID>";
                    $task .= "<pName>$atividade->id - $atividade->descricao </pName>";
                    $task .= "<pStart>$data_inicio</pStart>";
                    $task .= "<pEnd>$data_final</pEnd>";
                    $task .= "<pColor>ff00ff</pColor>";
                    $task .= "<pLink>/xx</pLink>";
                    $task .= "<pMile>0</pMile>";
                    $task .= "<pRes/>";
                    $task .= "<pComp>$historico->percentual</pComp>";
                    $task .= "<pGroup>0</pGroup>";
                    $task .= "<pParent>$opid</pParent>";
                    $task .= "<pOpen>1</pOpen>";
                    $task .= "<pDepend>$str_vinculadas</pDepend>";
                    $task .= '</task>';
                    
                }
            }
            
            $xmlString .= $task."</project>";
            //echo trim("<project> <task> <pID>10</pID> <pName>WCF Changes</pName> <pStart></pStart> <pEnd></pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes></pRes> <pComp>0</pComp> <pGroup>1</pGroup> <pParent>0</pParent> <pOpen>1</pOpen> <pDepend /> </task> <task> <pID>20</pID> <pName>Move to WCF from remoting</pName> <pStart>8/11/2008</pStart> <pEnd>8/15/2008</pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes>Rich</pRes> <pComp>10</pComp> <pGroup>0</pGroup> <pParent>10</pParent> <pOpen>1</pOpen> <pDepend></pDepend> </task> <task> <pID>30</pID> <pName>add Auditing</pName> <pStart>8/19/2008</pStart> <pEnd>8/21/2008</pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes>Mal</pRes> <pComp>50</pComp> <pGroup>0</pGroup> <pParent>10</pParent> <pOpen>1</pOpen> <pDepend>20</pDepend> </task> </project>");
            //$ret= "<project> <task> <pID>10</pID> <pName>WCF Changes</pName> <pStart></pStart> <pEnd></pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes></pRes> <pComp>0</pComp> <pGroup>1</pGroup> <pParent>0</pParent> <pOpen>1</pOpen> <pDepend /> </task> <task> <pID>20</pID> <pName>Move to WCF from remoting</pName> <pStart>8/11/2008</pStart> <pEnd>8/15/2008</pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes>Rich</pRes> <pComp>10</pComp> <pGroup>0</pGroup> <pParent>10</pParent> <pOpen>1</pOpen> <pDepend></pDepend> </task> <task> <pID>30</pID> <pName>add Auditing</pName> <pStart>8/19/2008</pStart> <pEnd>8/21/2008</pEnd> <pColor>0000ff</pColor> <pLink></pLink> <pMile>0</pMile> <pRes>Mal</pRes> <pComp>50</pComp> <pGroup>0</pGroup> <pParent>10</pParent> <pOpen>1</pOpen> <pDepend>20</pDepend> </task> </project>";

            $this->view->myxml = trim($xmlString);
	}
}