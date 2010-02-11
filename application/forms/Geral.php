<?php

class Form_Geral extends Zend_Form
{
	public function __construct($options = null,$name='programa' )
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$this->setName($name);
		$id = new Zend_Form_Element_Hidden('id');
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descrição')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',4);
		
		$menu = new Zend_Form_Element_Text('menu');
		$menu->setLabel('Descrição no menu')
			->addFilter('StripTags')	
			->addFilter('StringTrim')
			->setAttrib('size',20);

		$interfaces = new Zend_Form_Element_Textarea('interfaces');
		$interfaces->setLabel('Interfaces')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('rows',4);
		
			
			
			
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$this->addElements(array($id, $descricao, $menu, $interfaces, $this->getResponsaveis(), $submit));
	}
	public function getResponsaveis() {

		
		$usuarios = new Model_Usuarios();
		$form = new Zend_Form_Element_Select('responsavel_id');
		foreach($usuarios->fetchAll('1=1' ,array('nome')) as $p) 
			$form->addMultiOptions(array($p->id => " ".$p->nome));
		$form->setLabel ( "Responsável:" )
		->setRequired ( true );
		return $form;
	}

	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('descricao' 	=> $this->getValue('descricao'), 
					'menu' 				=> $this->getValue('menu'),
					'interfaces' 		=> $this->getValue('interfaces'), 
					'responsavel_id' 	=> $this->getValue('responsavel_id')
				);
		
		return $dados;
	}
}