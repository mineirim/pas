<?php

class Form_Indicador extends Zend_Form
{
	public function __construct($options = null )
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$this->setDisableLoadDefaultDecorators(true);
		$this->removeDecorator('label');
		$this->getDecorator('HtmlTag')->clearOptions();
		$this->getDecorator('fieldset')->setOption('style','padding:0;border:none;margin:0;');
		$id = new Zend_Form_Element_Hidden('id');
		$id->removeDecorator('label');
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->removeDecorator('label');
		$descricao->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('cols',70)
			->setAttrib('rows',2);
		
		$tipo_indicador_id = new Zend_Form_Element_Radio('tipo_indicador_id');
		
		$tipo_indicador_id ->setLabel('Tipo');
		$tiposIndicadores = new Model_TiposIndicadores();
		
		foreach ($tiposIndicadores->fetchAll(null,'id') as $tipoIndicador){
			$tipo_indicador_id->addMultiOption($tipoIndicador->id,$tipoIndicador->descricao);
		}
		$tipo_indicador_id->addDecorator ('HtmlTag',array('tag'=>'div','style'=>'padding:0;border:none;margin:0;float:left;'));

		

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_descritivo')
				->setLabel('Adicionar')
				->setAttrib('class','submit_descritivo');
		
		
		$this->addElements(array($id, $descricao, $tipo_indicador_id,$submit ));
		 /*
		 $this->setDecorators(array('ViewHelper','FormElements',
                    array('HtmlTag',array('tag'=>'div', 'style'=>'width:50%;'))
        ));*/
	
	}
	

	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('descricao' 	=> $this->getValue('descricao')	, 'tipo_indicador_id'=>	$this->getValue('tipo_indicador_id')		);
		
		return $dados;
	}
}