<?php

class Form_Ajudas extends Zend_Form
{
	public function __construct($options = null,$name='ajudas' )
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$this->setName($name);
		$id = new Zend_Form_Element_Hidden('id');
		$pagina = new Zend_Form_Element_Hidden('pagina');
		
		
		$textoajuda = new Zend_Form_Element_Textarea('textoajuda');
		$textoajuda->removeDecorator('label')
			->setAttrib('rows',10)
			->setAttrib('cols',90);
			
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
				->setLabel('Salvar');
				
		$this->addElements(array($id, $pagina, $textoajuda, $submit));
	}

	
	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('textoajuda' 	=> $this->getValue('textoajuda'),
						'pagina' => $this->getValue('pagina')
							);
		
		return $dados;
	}
}

?>
