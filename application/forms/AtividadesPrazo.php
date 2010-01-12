<?php

class Form_AtividadesPrazo extends Zend_Form
{
	public function __construct($options = null,$name='atividade_prazo' )
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$this->setName($name);
		$id = new Zend_Form_Element_Hidden('id');
		$atividade_id = new Zend_Form_Element_Hidden('atividade_id');
		
		
		$motivopostergacao = new Zend_Form_Element_Text('motivopostergacao');
		$motivopostergacao->setLabel('Motivo da Postergação')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('size','80');

		$dateValidator = new Zend_Validate_Date();
				
		$prazo_data = new Zend_Form_Element_Text('prazo_data');
		$prazo_data->setLabel('Nova Data de Término')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator($dateValidator);
		$prazo_data->setAttrib('class','datepick');

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
				->setLabel('Salvar');
		$this->addElements(array($id, $atividade_id, $motivopostergacao, $prazo_data, $submit));
	}

	
	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('motivopostergacao' 	=> $this->getValue('motivopostergacao'),
						'prazo_data'	=>  $this->getValue('prazo_data'),
						'atividade_id'	=> $this->getValue('atividade_id')
		);
		
		return $dados;
	}
}