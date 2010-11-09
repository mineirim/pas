<?php

class Form_Usuario extends ZendX_JQuery_Form {

    public function __construct($options = null,$novo=null) {

        parent::__construct($options);

        $subform = new Zend_Form_SubForm('usuario');

        $this->removeDecorator("DtDdWrapper");

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



        $this->addSubForm($subform, 'usuario');
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
        foreach ($grupos->fetchAll($where) as $p)
            $formGrupos->addMultiOptions(array($p->id => " " . $p->descricao));
        $formGrupos->setDecorators(array('ViewHelper', 'Errors'))
                ->setRequired(true);
        return $formGrupos;
    }

}