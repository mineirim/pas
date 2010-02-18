<?php

class Form_OpcoesQualitativos extends Zend_Form_SubForm
{
	public function __construct($options = null )
	{
		parent::__construct($options);
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$id = new Zend_Form_Element_Hidden('id');
		$id->removeDecorator('label');
		
		$indicador_id = new Zend_Form_Element_Hidden('indicador_id');
		$indicador_id->removeDecorator('label');
		
		$descricao = new Zend_Form_Element_Text('descricao');
		$descricao->setLabel('Categoria');
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_descritivo')
				->setLabel('Adicionar');
		
		
		$this->addElements(array($id, $indicador_id, $descricao,$submit ));
	
	}

	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array (
		              'indicador_id'=>$this->getValue('indicador_id'),
				      'descricao'=>$this->getValue('descricao')
		              );
		
		return $dados;
	}
}