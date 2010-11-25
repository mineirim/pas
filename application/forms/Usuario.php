<?php
class Form_Usuario extends Zend_Form
{
	public function __construct($options = null)
	{
		
		parent::__construct($options);
		
		$this->removeDecorator("DtDdWrapper");
		
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$this->setName('usuario');
		$id = new Zend_Form_Element_Hidden('id');
		$nome = new Zend_Form_Element_Text('nome');
		$nome->setLabel('Nome')
			->setAttrib('size',50)
			->setRequired(true)
			->addFilter('StripTags')
			->removeDecorator("DtDdWrapper")
			->addFilter('StringTrim')
			->setDecorators(array( 'ViewHelper', 'Errors', 'Label'))
			->addValidator('NotEmpty');
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel('E-mail')
			->setRequired(true)
			->setAttrib('size',50)
			->removeDecorator('DtDdWrapper')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
		$email->setDecorators(array( 'ViewHelper', 'Errors', 'Label'));
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')->setDecorators(array( 'ViewHelper', 'Errors', 'Label'));
		
		
		
		$this->addElements(array($id, $nome, $email, $this->getGrupos() ,$submit));
	}
	public function getGrupos() {

		$acl = Zend_Registry::get('acl');
		$auth = Zend_Auth::getInstance()->getIdentity();
		
		/**
		 * somente usuário administrador pode definir outros administradores(ou usuários de grupos reservados ao sistema)
		 */
		$where = 'id>6';
		if($acl->has('admin') && $acl->isAllowed($auth->username,'admin'))
			$where = 'id<>6';
		
		$grupos = new Model_Grupos();
		
		$formGrupos = new Zend_Form_Element_MultiCheckbox('grupos');
		foreach($grupos->fetchAll($where) as $p) 
			$formGrupos->addMultiOptions(array($p->id => " ".$p->descricao));
		$formGrupos->setLabel ( "Grupos:" )
					->setDecorators(array( 'ViewHelper', 'Errors', 'Label'))
					->setRequired ( true );
		return $formGrupos;
	}
	public function addUsernameAndPassword(){
		$username = new Zend_Form_Element_Text('username');
		$username->setLabel('Login')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setDecorators(array( 'ViewHelper', 'Errors', 'Label'))
			->addValidator('NotEmpty');
		$password = new Zend_Form_Element_Password('password');	
		$password->setLabel('Senha')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setDecorators(array( 'ViewHelper', 'Errors', 'Label'))
			->addValidator('NotEmpty');
			
			$this->addElements(array($username,$password));
		
	}
}