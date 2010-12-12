<?php

class Programacao_Form_Atividade extends Zend_Form
{
	 /**
	  *  @var Zend_Form_SubForm subform
	 */
	public $subform, $frmHistorico;

	public function __construct($options = null,$name='atividade' )
	{
            parent::__construct($options);
            $translate = Zend_Registry::get('translate');
            $this->setTranslator($translate);
            $this->subform = new Zend_Form_SubForm('atividade');
            $this->frmHistorico = new Zend_Form_SubForm('historico');
            $this->setName('frmatividade');
            $id = new Zend_Form_Element_Hidden('id');
            $operacao_id = new Zend_Form_Element_Hidden('operacao_id');


            $descricao = new Zend_Form_Element_Textarea('descricao');
            $descricao->setLabel('Descrição')
                    ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty')
                    ->setAttrib('rows',4);

            $peso = new Zend_Form_Element_Text('peso');
            $peso->setLabel('Peso')
                    ->setAttrib('size',2)
                    ->setAttrib('maxlength',3)
                    ->setAttrib('readonly','true')
                    ->setValue(0)
                    ->setDescription("O peso da atividade no conjunto do objetivo específico.")
                    ->addValidator('Digits')
                    ->addValidator('Between', true, array(0, 100))
                    ->addErrorMessage('Valor deve ser entre 0 e 100')
                    ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_slider.phtml')))
                    );
            $this->subform->addElements(array($operacao_id,$descricao,$peso));


            $responsavel_id = new Zend_Form_Element_Select('responsavel_id');
            $responsavel_id->setLabel('Responsável');
            $model_usuarios = new Model_Usuarios();
            /**
             * TODO implementar filtro de usuários vinculados ao objetivo específico e
             * adicionar o usuário responsável atual caso este seja excluido
             */
            foreach ($model_usuarios->fetchAll('situacao_id=1') as $usuario)
                $responsavel_id->addMultiOption($usuario->id,$usuario->nome);


            $dateValidator = new Zend_Validate_Date();

            $data_inicio = new Zend_Form_Element_Text('data_inicio');
            $data_inicio->setLabel('Data de Início')
                    ->addFilter('StripTags')->addFilter('StringTrim')
                    ->addValidator($dateValidator)
                    ->setAttrib('class','datepick')->setAttrib('size','12');

            $data_prazo = new Zend_Form_Element_Text('data_prazo');
            $data_prazo->setLabel('Prazo')
                    ->addFilter('StripTags')->addFilter('StringTrim')
                    ->addValidator($dateValidator)
                    ->setAttrib('class','datepick')->setAttrib('size','12');


            $this->frmHistorico->addElements(array($responsavel_id, $data_inicio, $data_prazo));
            
            $this->addSubForm($this->subform, 'atividade');
            $this->addSubForm($this->frmHistorico, 'historico');


            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setAttrib('id', 'submitbutton')
                            ->setLabel('Salvar')->setAttrib('class', 'by-ajax');

            $close = new Zend_Form_Element_Button('cancelar');
            $close->setAttrib('class', 'dialog-form-close')
              ->setDecorators(array('ViewHelper', 'Errors'));        
        
        $this->addElements(array($id,$submit, $close));
		
	}


}