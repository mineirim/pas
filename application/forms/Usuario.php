<?php
class Form_Usuario extends Zend_Form
{
	public function __construct($options = null)
	{
		
		parent::__construct($options);
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
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
		$email = new Zend_Form_Element_Text('email');
		$email_validate = new Zend_Validate_EmailAddress();
		$email_validate->setDomainCheck(false)->setValidateMx(false);	
		$email->setLabel('E-mail')
			->setRequired(true)
			->setAttrib('size',50)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator($email_validate )
			->addValidator('NotEmpty');
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
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
		->setRequired ( true );
		return $formGrupos;
	}
	public function addUsernameAndPassword(){
		$username = new Zend_Form_Element_Text('username');
		$username->setLabel('Login')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
		$password = new Zend_Form_Element_Password('password');	
		$password->setLabel('Senha')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
			
			$this->addElements(array($username,$password));
		
	}
}