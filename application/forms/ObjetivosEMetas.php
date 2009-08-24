<?php

class Form_ObjetivosEMetas {
	private $_request;
	function __construct($request) {
		$this->_request = $request;
	}
	
	/**
	 * Grava os dados dos subformulários de metas e objetivos
	 * @param Objeto $modelo 
	 * @return unknown_type
	 */
	public function gravaObjetivos_e_Metas($modelo, $formData){
		$model_objetivo='';
		$model_meta='';
		$id = $modelo->id;
		$classe = explode("_", $modelo->getTableClass());
		$model = substr($classe[count($classe)-1],0,strlen($classe[count($classe)-1])-1);
		eval('$model_objetivo = new Model_Objetivos'.$model.'();');
		eval('$model_meta = new Model_Metas'.$model.'();');
		
		$f = new Form_Descritivo();
		
		foreach ($formData as $key=>$value){
			
			if(substr($key,0,8)=='objetivo'){
				$subpost = $this->_request->getPost($key, false);
				if($f->isValid($subpost) || $subpost['remover']){
					$dados = $f->getDados();
					// define o campo de model_id do relacionamento
					$dados[strtolower($model).'_id']=$id;
					if($f->getValue("id") && $subpost['remover'] ){
						$model_objetivo->delete('id='.$f->getValue("id"));
					}elseif($f->getValue("id")){
						$model_objetivo->update($dados,'id='.$f->getValue("id"));
					}elseif($f->isValid($subpost)){
						$model_objetivo->insert($dados);
					}
					
				}
			}elseif(substr($key,0,5)=='meta_'){
				$subpost =$this->_request->getPost($key, false);
				if($f->isValid($subpost) || $subpost['remover']){
					$dados = $f->getDados();
					// define o campo de model_id do relacionamento
					$dados[strtolower($model).'_id']=$id;
					if($f->getValue("id") && $subpost['remover'] ){
						$model_meta->delete('id='.$f->getValue("id"));
					}elseif($f->getValue("id")){
						$model_meta->update($dados,'id='.$f->getValue("id"));
					}elseif($f->isValid($subpost)){
						$model_meta->insert($dados);
					}
					
				}else{
					echo "Erro";
				}				
			}
		}		
	}
		/**
	 * Adiciona os subformulários de metas e objetivos no formulário principal
	 * @param $programa
	 * @return subforms
	 */
	public function getSubForms($objetivos=array(), $metas=array()){
		$subforms = array();
		//$classe = explode("_", $obj->getTableClass());
		//$model = substr($classe[count($classe)-1],0,strlen($classe[count($classe)-1])-1);
		
		//$objetivos = $obj->findDependentRowset('Model_Objetivos'.$model);
		
		$i=1;
		foreach ($objetivos  as $objetivo){
			$subform= new Form_Descritivo();
			$subform->populate($objetivo->toArray());
			$subform->removeDecorator('label');
			$subforms["objetivo_$i"] = $subform;
			$i++;
		}
		
		$this->view->objetivos = $objetivos;
		$subform= new Form_Descritivo();
		$subforms["objetivo_0"] = $subform;
		
		
		//$metas = $obj->findDependentRowset('Model_Metas'.$model);
		
		$i=1;
		foreach ($metas  as $meta){
			
			$subform= new Form_Descritivo();
			$subform->populate($meta->toArray());
			$subform->removeDecorator('label');
			$subforms["meta_$i"] = $subform;
			$i++;
		}
		$this->view->metas = $metas;
		
		$subform= new Form_Descritivo();
		$subforms["meta_0"] = $subform;
		
		return $subforms;
	}

	
	
}

?>