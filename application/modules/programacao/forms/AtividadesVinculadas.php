<?php 

class Programacao_Form_AtividadesVinculadas extends Zend_Form
{

	public function __construct($options = null,$name='atividades_vinculadas' )
	{
            parent::__construct($options);
            $translate = Zend_Registry::get('translate');
            $this->setTranslator($translate);
            $this->setName('frmatividadesvinculadas');
            $atividade_id= new Zend_Form_Element_Hidden('atividade_id');
            $atividade_id->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml'))));

            
            $depende_atividade_id = new Zend_Form_Element_Select('depende_atividade_id');
            $depende_atividade_id->addMultiOption("","Selecione...");
            
            $depende_atividade_id->setLabel('Atividades');
            $model_atividades = new Model_Atividades();
            $atividades = $model_atividades->fetchAll('situacao_id=1'); 
            foreach ($atividades as $atividade)
                $depende_atividade_id->addMultiOption($atividade->id,$atividade->descricao);
             $depende_atividade_id->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formselect.phtml'))));
            
            
            

            $justificativa = new Zend_Form_Element_Textarea('justificativa');
            $justificativa->setLabel('Justificativa')
                    ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty')
                    ->setAttrib('rows',4)
                    ->setAttrib('class', 'ui-widget ui-widget-content ui-corner-all')
                    ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml'))));;

            $this->addElements(array($atividade_id,$depende_atividade_id,$justificativa));

            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setAttrib('id', 'submitbutton')
                            ->setLabel('Salvar')->setAttrib('class', 'by-ajax');

            $close = new Zend_Form_Element_Button('cancelar');
            $close->setAttrib('class', 'dialog-form-close')
              ->setDecorators(array('ViewHelper', 'Errors'));        
        
        $this->addElements(array($submit, $close));
		
	}


}