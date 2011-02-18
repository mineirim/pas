<?php

class Admin_Form_Usuario extends ZendX_JQuery_Form {

    public function __construct($options = null,$novo=null) {

        parent::__construct($options);

        $subform = new Zend_Form_SubForm('usuario');
		$subformSetor = new Zend_Form_SubForm('frmsetor');
		$subformCargo = new Zend_Form_SubForm('frmcargo');
        $this->removeDecorator("DtDdWrapper");

        $dateValidator = new Zend_Validate_Date();

        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
        $this->setName('frm-usuario');
        $id = new Zend_Form_Element_Hidden('id');
        $subform->addElement($id);

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome')
                ->setAttrib('size', 50)
                ->setRequired(true)
                ->addFilter('StripTags')
                ->removeDecorator("DtDdWrapper")
                ->addFilter('StringTrim')
                ->setDecorators(array('ViewHelper', 'Errors', 'Label'))
                ->addValidator('NotEmpty');
        $subform->addElement($nome);

        $email = new Zend_Form_Element_Text('email');
        $email_validate = new Zend_Validate_EmailAddress();
        $email_validate->setDomainCheck(false)->setValidateMx(false);
        $email->setLabel('E-mail')
                ->setRequired(true)
                ->setAttrib('size', 50)
                ->removeDecorator('DtDdWrapper')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator($email_validate)
                ->addValidator('NotEmpty');
        $email->setDecorators(array('ViewHelper', 'Errors', 'Label'));
        $subform->addElement($email);
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')->setAttrib('class', 'by-ajax')
                ->setDecorators(array('ViewHelper', 'Errors'))
                ->setValue("Salvar");


        if($novo){
            $username = new Zend_Form_Element_Text('username');
            $username->setLabel('Login')
                    ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->setDecorators(array('ViewHelper', 'Errors', 'Label'))
                    ->addValidator('NotEmpty');
            $subform->addElement($username);
            $password = new Zend_Form_Element_Password('password');
            $password->setLabel('Senha')
                    ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->setDecorators(array('ViewHelper', 'Errors', 'Label'))
                    ->addValidator('NotEmpty');
            $subform->addElement($password);
        }

        /*
         * cargo
         */
        
        $cargo_id = new Zend_Form_Element_Select('cargo_id');
        $cargo_id->setLabel('Cargo')
                ->setRequired(true)
                ->addValidator('NotEmpty');
        $model_cargos = new Model_Cargos();
        $cargo_id->addMultiOption('','Selecione o cargo');
        foreach ($model_cargos->fetchAll('situacao_id=1') as $cargo)
        	$cargo_id->addMultiOption($cargo->id,$cargo->nome);
		
        $subformCargo->addElement($cargo_id);	
        	
        /*
         * setor
         */
	$setor_id = new Zend_Form_Element_Select('setor_id');
        $setor_id->setLabel('Setor');
        $model_setores = new Model_Setores();
        $setor_id->addMultiOption(0,'Selecione o setor');
        foreach ($model_setores->fetchAll('situacao_id=1') as $setor)
        	$setor_id->addMultiOption($setor->id,$setor->nome.' - '.$setor->sigla);
		
        $subformSetor->addElement($setor_id);	
        $this->addSubForm($subform, 'usuario');
        $this->addSubForm($subformCargo, 'cargo');
        $this->addSubForm($subformSetor, 'setor');
        $this->addElements(array($this->getGrupos(), $submit));
    }

    public function getGrupos() {

        $acl = Zend_Registry::get('acl');
        $auth = Zend_Auth::getInstance()->getIdentity();

        /**
         * somente usuário administrador pode definir outros administradores(ou usuários de grupos reservados ao sistema)
         */
        $where = 'id>6';
        if ($acl->has('admin') && $acl->isAllowed($auth->username, 'admin'))
            $where = 'id<>6';

        $grupos = new Model_Grupos();

        $formGrupos = new Zend_Form_Element_MultiCheckbox('grupos');
        foreach ($grupos->fetchAll($where,'id') as $p)
            $formGrupos->addMultiOptions(array($p->id => " " . $p->descricao));
        $formGrupos->setDecorators(array('ViewHelper', 'Errors'))
                ->setRequired(true);
        return $formGrupos;
    }

}