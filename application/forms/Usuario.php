<?php
class Form_Usuario extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
		$this->setName('usuario');
		$id = new Zend_Form_Element_Hidden('id');
		$nome = new Zend_Form_Element_Text('nome');
		$nome->setLabel('Nome')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
		$username = new Zend_Form_Element_Text('username');
		$username->setLabel('Login')
			->addFilter('StripTags')
			->addFilter('StringTrim');
		$password = new Zend_Form_Element_Password('password');	
		$password->setLabel('Senha')
			->addFilter('StripTags')
			->addFilter('StringTrim');
		$email = new Zend_Form_Element_Text('email');	
		$email->setLabel('E-mail')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$this->addElements(array($id, $nome, $username,$password,$email, $this->getGrupos() ,$submit));
	}
	public function getGrupos() {

		
		$grupos = new Model_Grupos();
		
		$formGrupos = new Zend_Form_Element_MultiCheckbox('grupos');
		foreach($grupos->fetchAll() as $p) 
			$formGrupos->addMultiOptions(array($p->id => " ".$p->descricao));
		$formGrupos->setLabel ( "Grupos:" )
		->setRequired ( true );
		return $formGrupos;
	}
}