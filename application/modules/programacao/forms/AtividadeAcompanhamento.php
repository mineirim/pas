<?php

class Programacao_Form_AtividadeAcompanhamento extends Zend_Form {

    /**
     *  @var Zend_Form_SubForm subform
     */
    public $frmHistorico ;

    public function __construct($_atividade_id,$options = null, $name='atividade') {
        parent::__construct($options);
        
        /**
         * pega o andamento atual para validação do formulário
         */
        $model_historico = new Model_AtividadesHistorico();
        $andamento_corrente = $model_historico->fetchCurrentRow($_atividade_id);

        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
        $this->setName('frmatividade');
        

        $this->frmHistorico = new Zend_Form_SubForm('frmHistorico');
        $this->frmVinculo = new Zend_Form_SubForm('frmVinculo');

        $atividade_id = new Zend_Form_Element_Hidden('atividade_id');
        $atividade_id->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );
        $responsavel_id = new Zend_Form_Element_Hidden('responsavel_id');
        $atividade_id->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );

        $dateValidator = new Zend_Validate_Date();

        $data_inicio = new Zend_Form_Element_Text('data_inicio');
        $data_inicio->setLabel('Data de Início')
                ->addFilter('StripTags')->addFilter('StringTrim')
                ->addValidator($dateValidator)
                ->setAttrib('size', '12')->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );

        if($andamento_corrente->andamento_id >= ANDAMENTO_INICIADA){
            /**
             * TODO implementar um validate para o caso de passar uma data diferente via alterações de código javascript
             */
            $data_inicio->setAttrib('readonly', 'readonly');
        }else{
            $data_inicio->setAttrib('class', 'datepick');
        }


        $data_prazo = new Zend_Form_Element_Text('data_prazo');
        $data_prazo->setLabel('Prazo')
                ->addFilter('StripTags')->addFilter('StringTrim')
                ->addValidator($dateValidator)
                ->setAttrib('size', '12')->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );

        $data_conclusao = new Zend_Form_Element_Text('data_conclusao');
        $data_conclusao->setLabel('Data de Conclusão')
                ->addFilter('StripTags')->addFilter('StringTrim')
                ->addValidator($dateValidator)
                ->setAttrib('size', '12')->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );

        $andamento_id = new Zend_Form_Element_Select('andamento_id');
        $andamento_id->setLabel('Andamento')
                ->setRequired(true)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formselect.phtml')))
                    );

        $avaliacao = new Zend_Form_Element_Textarea('avaliacao');
        $avaliacao->setLabel('Avaliação do andamento')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('rows', 4)
                ->setAttrib('cols', 60)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );

        $percentual = new Zend_Form_Element_Text('percentual');
    	$percentual->setAttrib('size',2)
    				->setAttrib('maxlength',3)
    				->setAttrib('readonly','true')
    				->setLabel('Avaliação subjetiva do percentual de execução')
    				->setValue(0);
        $percentual->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_slider.phtml')))
                    );

        $model_andamentos = new Model_Andamentos();

        if($andamento_corrente->andamento_id >= ANDAMENTO_FINALIZADA){
            foreach ($model_andamentos->fetchAll('id in('.ANDAMENTO_FINALIZADA.','.ANDAMENTO_REABRIR.','.ANDAMENTO_CORRIGIR.')') as $andamento)
                $andamento_id->addMultiOption($andamento->id,$andamento->descricao);
            
            $data_prazo->setAttrib('readonly', 'readonly');
            $data_conclusao->setAttrib('readonly', 'readonly');
            $avaliacao->setAttrib('readonly', 'readonly');
        }else{
            foreach ($model_andamentos->fetchAll('id>1') as $andamento)
                $andamento_id->addMultiOption($andamento->id,$andamento->descricao);
            $data_prazo->setAttrib('class', 'datepick');
            $data_conclusao->setAttrib('class', 'datepick');
        }

        $this->frmHistorico->addElements(array($atividade_id,
            $data_inicio, $data_prazo, $data_conclusao,
            $andamento_id, $avaliacao, $percentual, $responsavel_id));
        
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