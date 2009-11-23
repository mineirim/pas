<?php

class Form_Metas extends Zend_Form_SubForm
{
	public function __construct($options = null )
	{
		parent::__construct($options);
		
		$this->setDisableLoadDefaultDecorators(true);
		$this->removeDecorator('label');
		$this->getDecorator('HtmlTag')->clearOptions();
		$this->getDecorator('fieldset')->setOption('style','padding:0;border:none;margin:0;');
		$id = new Zend_Form_Element_Hidden('id');
		$id->removeDecorator('label');
		
		$objetivo_especifico_id = new Zend_Form_Element_Hidden('objetivo_especifico_id');
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descrição da meta');
		$descricao->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',2);
		

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_descritivo')
				->setLabel('Salvar');
		
		
		$this->addElements(array($id, $descricao, $objetivo_especifico_id,$submit ));
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
		
		$dados = array ('descricao' 	=> $this->getValue('descricao')	,
						'objetivo_especifico_id'=> $this->getValue('objetivo_especifico_id'));
		
		return $dados;
	}
}