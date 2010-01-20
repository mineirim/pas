<?php

class Form_AtividadesVinculacao extends Zend_Form
{
	public function __construct($options = null,$name='atividade_vinculadas' )
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$this->setName($name);
		$id = new Zend_Form_Element_Hidden('id');
		$atividade_id = new Zend_Form_Element_Hidden('atividade_id');
		
		
		$observacoes = new Zend_Form_Element_Text('observacoes');
		$observacoes->setLabel('Observações')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('size','80');

		$depende_atividade_id = new Zend_Form_Element_Text('depende_atividade_id');
		$depende_atividade_id->setLabel('Código Atividade Vinculada')
			->addValidator('Digits')
			->setAttrib('size','10')
			->addValidator('NotEmpty')
			->setRequired(true)			
			->addErrorMessage('Código da Atividade Vinculada é obrigatório');
			

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
				->setLabel('Salvar');
		$this->addElements(array($id, $atividade_id, $depende_atividade_id, $observacoes, $submit));
	}

	
	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('depende_atividade_id' 	=> $this->getValue('depende_atividade_id'),
						'observacoes'	=>  $this->getValue('observacoes'),
						'atividade_id'	=> $this->getValue('atividade_id')
		);
		
		return $dados;
	}
}

?>