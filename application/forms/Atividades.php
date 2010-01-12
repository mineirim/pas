<?php

class Form_Atividades extends Zend_Form
{
	public function __construct($options = null,$name='atividade' )
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$this->setName($name);
		$id = new Zend_Form_Element_Hidden('id');
		$operacao_id = new Zend_Form_Element_Hidden('operacao_id');
		
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descrição')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',4);
			
		$responsavel = new Zend_Form_Element_Text('responsavel');
		$responsavel->setLabel('Responsável')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('size','80');
			
		$intersecao = new Zend_Form_Element_Text('intersecao');
		$intersecao->setLabel('Interseção')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('size','80');
			
		$valor = new Zend_Form_Element_Text('valor');
		$valor->setLabel('Valor')->addValidator('Digits')
			->setAttrib('size','10')
			->addValidator('Between', true, array(0, 100))
			->addErrorMessage('Valor deve ser entre 0 e 100');
			
		
		
		$dateValidator = new Zend_Validate_Date();
				
		$inicio_data = new Zend_Form_Element_Text('inicio_data');
		$inicio_data->setLabel('Data de Início')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator($dateValidator)
			->setAttrib('class','datepick')
			->setAttrib('size','12');
			
		$prazo_data = new Zend_Form_Element_Text('prazo_data');
		$prazo_data->setLabel('Data de Término')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator($dateValidator)
			->setAttrib('class','datepick')
			->setAttrib('size','12');

		$andamento = new Zend_Form_Element_Textarea('andamento');
		$andamento->setLabel('Andamento da Execução')
			->setRequired(false)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('rows',4);
		
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
				->setLabel('Salvar');
				
		$this->addElements(array($id, $descricao, $responsavel, $intersecao, $valor, $inicio_data, $prazo_data, $operacao_id, $andamento, $submit));
	}

	
	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('descricao' 	=> $this->getValue('descricao'),
						'responsavel'	=> $this->getValue('responsavel'), 
						'intersecao'	=> $this->getValue('intersecao'), 
						'valor'			=> $this->getValue('valor'),
						'inicio_data'	=>  $this->getValue('inicio_data'),
						'prazo_data'	=>  $this->getValue('prazo_data'),
						'andamento'		=>  $this->getValue('andamento'),
						'operacao_id'	=> $this->getValue('operacao_id')
		);
		
		return $dados;
	}
}