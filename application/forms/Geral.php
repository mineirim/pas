<?php

class Form_Geral extends Zend_Form
{
	public function __construct($options = null )
	{
		parent::__construct($options);
		
		$this->setName('programa');
		$id = new Zend_Form_Element_Hidden('id');
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descricao')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',4);
		
		$desc_menu = new Zend_Form_Element_Text('desc_menu');
		$desc_menu->setLabel('Descrição no menu')
			->addFilter('StripTags')	
			->addFilter('StringTrim')
			->setAttrib('size',20);
		$objetivo = new Zend_Form_Element_Textarea('objetivos_x');
		$objetivo->setLabel('Objetivo')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('rows',4);
		
		$meta = new Zend_Form_Element_Textarea('meta');
		$meta->setLabel('Meta')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('rows',6);

		$interfaces = new Zend_Form_Element_Textarea('interfaces');
		$interfaces->setLabel('Interfaces')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('rows',4);
		
			
			
			
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$this->addElements(array($id, $descricao, $desc_menu, $objetivo,$meta,$interfaces, $this->getResponsaveis(), $submit));
	}
	public function getResponsaveis() {

		
		$usuarios = new Model_Usuarios();
		
		$form = new Zend_Form_Element_Select('responsavel_id');
		foreach($usuarios->fetchAll() as $p) 
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
					'desc_menu' 				=> $this->getValue('desc_menu'),
					'interfaces' 		=> $this->getValue('interfaces'), 
					'responsavel_id' 	=> $this->getValue('responsavel_id')
				);
		
		return $dados;
		/*
		$usuario_id = Zend_Auth::getInstance ()->getIdentity ()->id;
		$descricao = $form->getValue ( 'descricao' );
		$objetivo = $form->getValue ( 'objetivo' );
		$meta = $form->getValue ( 'meta' );
		$interfaces = $form->getValue ( 'interfaces' );
		$responsavel_id = $form->getValue ( 'responsavel_id' );
		$inclusao_usuario_id = $usuario_id;
		$alteracao_usuario_id = $usuario_id;
		*/
	}
}