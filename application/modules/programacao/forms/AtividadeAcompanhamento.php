<?php

class Programacao_Form_AtividadeAcompanhamento extends Zend_Form {

    /**
     *  @var Zend_Form_SubForm subform
     */
    public $frmHistorico, $frmVinculo;

    public function __construct($options = null, $name='atividade') {
        parent::__construct($options);
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
        $this->setName('frmatividade');

        $this->frmHistorico = new Zend_Form_SubForm('frmHistorico');
        $this->frmVinculo = new Zend_Form_SubForm('frmVinculo');

        $atividade_id = new Zend_Form_Element_Hidden('atividade_id');
        $operacao_id = new Zend_Form_Element_Hidden('operacao_id');



        $dateValidator = new Zend_Validate_Date();

        $data_inicio = new Zend_Form_Element_Text('data_inicio');
        $data_inicio->setLabel('Data de Início')
                ->addFilter('StripTags')->addFilter('StringTrim')
                ->addValidator($dateValidator)->setAttrib('class', 'datepick')
                ->setAttrib('size', '12');

        $data_prazo = new Zend_Form_Element_Text('data_prazo');
        $data_prazo->setLabel('Prazo')
                ->addFilter('StripTags')->addFilter('StringTrim')
                ->addValidator($dateValidator)->setAttrib('class', 'datepick')
                ->setAttrib('size', '12');

        $data_conclusao = new Zend_Form_Element_Text('data_conclusao');
        $data_conclusao->setLabel('Data de Conclusão')
                ->addFilter('StripTags')->addFilter('StringTrim')
                ->addValidator($dateValidator)->setAttrib('class', 'datepick')
                ->setAttrib('size', '12');

        $andamento_id = new Zend_Form_Element_Select('andamento_id');
        $andamento_id->setLabel('Andamento')
                ->setRequired(true);
        $model_andamentos = new Model_Andamentos();
        foreach ($model_andamentos->fetchAll('id>1') as $andamento)
            $andamento_id->addMultiOption($andamento->id,$andamento->descricao);

        $avaliacao = new Zend_Form_Element_Textarea('avaliacao');
        $avaliacao->setLabel('Avaliação do andamento')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('rows', 4)
                ->setAttrib('cols', 60);

        $percentual = new Zend_Form_Element_Text('percentual');
    	$percentual->setAttrib('size',2)
    				->setAttrib('maxlength',3)
    				->setAttrib('readonly','true')
    				->setLabel('% execução')
    				->setValue(0);
        $percentual->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_slider.phtml')))
                    );
        $this->frmHistorico->addElements(array($atividade_id, 
            $data_inicio, $data_prazo, $data_conclusao,
            $andamento_id, $avaliacao, $percentual));
        
        $this->addSubForm($this->frmHistorico, 'historico');


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
                ->setLabel('Salvar')->setAttrib('class', 'by-ajax');

        $close = new Zend_Form_Element_Button('cancelar');
        $close->setAttrib('class', 'dialog-form-close')
                ->setDecorators(array('ViewHelper', 'Errors'));

        $this->addElements(array($submit, $close));
    }

}