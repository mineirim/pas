<?php
/**
 *
 * @author hugo
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * LineProgressbar helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_LineProgressbar extends Zend_View_Helper_BaseUrl {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function lineProgressbar($nivel, $id)
	{
		$progressbar = ""; 
		$progressbar = $this->getLineProgressbar($nivel, $id); 
		return $progressbar; 
	}
	private function getLineProgressbar($nivel, $id)
	{
		$pesodenominador = 0;
		$pesototal = 0;
		$atividades = new Model_Atividades ();
		if ($nivel == 7){
			$resultado = $atividades->fetchRow("id=" . $id);
			$pesodenominador = 100; 
			if ($resultado->conclusao_data){
				$pesototal = 100; // atividade realizada
			} else {
				$pesototal = 0; // atividade não realizada	
			}	
		} else {
			if ($nivel == 6){
				$pesodenominador = 100; // operação sempre terá denominador 100
			} else {
				$pesodenominador = $atividades->calculovalor($nivel, $id, 2);
			}
			$pesototal = $atividades->calculovalor($nivel, $id, 1);
		}
	    if (($pesototal >= 0) && ($pesototal <= ((5*$pesodenominador)/100))){
	        $frente = 1;
	        $fundo = 34;
		}
	    if (($pesototal > ((5*$pesodenominador)/100)) && ($pesototal <= ((10*$pesodenominador)/100))){
	        $frente = 3;
	        $fundo = 32;
		}
	    if (($pesototal > ((10*$pesodenominador)/100)) && ($pesototal <= ((15*$pesodenominador)/100))){
	        $frente = 5;
	        $fundo = 30;
		}
	    if (($pesototal > ((15*$pesodenominador)/100)) && ($pesototal <= ((20*$pesodenominador)/100))){
	        $frente = 7;
	        $fundo = 28;
		}
	    if (($pesototal > ((20*$pesodenominador)/100)) && ($pesototal <= ((25*$pesodenominador)/100))){
	        $frente = 8;
	        $fundo = 27;
	    }
	    if (($pesototal > ((25*$pesodenominador)/100)) && ($pesototal <= ((30*$pesodenominador)/100))){
	        $frente = 10;
	        $fundo = 25;
	    }
	    if (($pesototal > ((30*$pesodenominador)/100)) && ($pesototal <= ((35*$pesodenominador)/100))){
	        $frente = 12;
	        $fundo = 23;
		}
	    if (($pesototal > ((35*$pesodenominador)/100)) && ($pesototal <= ((40*$pesodenominador)/100))){
	        $frente = 14;
	        $fundo = 21;
		}
	    if (($pesototal > ((40*$pesodenominador)/100)) && ($pesototal <= ((45*$pesodenominador)/100))){
	        $frente = 15;
	        $fundo = 20;
	    }
	    if (($pesototal > ((45*$pesodenominador)/100)) && ($pesototal <= ((50*$pesodenominador)/100))){
	        $frente = 17;
	        $fundo = 18;
		}
	    if (($pesototal > ((50*$pesodenominador)/100)) && ($pesototal <= ((55*$pesodenominador)/100))){
	        $frente = 19;
	        $fundo = 16;
		}
	    if (($pesototal > ((55*$pesodenominador)/100)) && ($pesototal <= ((60*$pesodenominador)/100))){
	        $frente = 21;
	        $fundo = 14;
		}
	    if (($pesototal > ((60*$pesodenominador)/100)) && ($pesototal <= ((65*$pesodenominador)/100))){
	        $frente = 22;
	        $fundo = 13;
		}
	    if (($pesototal > ((65*$pesodenominador)/100)) && ($pesototal <= ((70*$pesodenominador)/100))){
	        $frente = 24;
	        $fundo = 11;
		}
	    if (($pesototal > ((70*$pesodenominador)/100)) && ($pesototal <= ((75*$pesodenominador)/100))){
	        $frente = 26;
	        $fundo = 9;
		}
	    if (($pesototal > ((75*$pesodenominador)/100)) && ($pesototal <= ((80*$pesodenominador)/100))){
	        $frente = 28;
	        $fundo = 7;
		}
	    if (($pesototal > ((80*$pesodenominador)/100)) && ($pesototal <= ((85*$pesodenominador)/100))){
	        $frente = 29;
	        $fundo = 6;
		}
		if (($pesototal > ((85*$pesodenominador)/100)) && ($pesototal <= ((90*$pesodenominador)/100))){
	        $frente = 31;
	        $fundo = 4;
		}
	    if (($pesototal > ((90*$pesodenominador)/100)) && ($pesototal <= ((95*$pesodenominador)/100))){
	        $frente = 33;
	        $fundo = 2;
		}
	    if (($pesototal > ((95*$pesodenominador)/100)) && ($pesototal <= ((100*$pesodenominador)/100))){
	        $frente = 34;
	        $fundo = 1;
		}
		if ($pesodenominador > 0){
			$pesopercentual = ($pesototal / $pesodenominador) * 100;
		} else {
			$pesopercentual = 0;
		}
		$pesopercentual = number_format($pesopercentual, 2, ",", "");

		$progressbar = "";
		for ($i=1; $i<=$frente; $i++){
			$progressbar .= "<img src=\"" . $this->baseUrl () ."/images/degrade-verde$i.gif\" alt=\"" . $pesopercentual . "% realizado\" title=\"" . $pesopercentual . "% realizado\" width=\"1\" height=\"10\" border=\"0\">";
		}
	
		$progressbar .= "<img src=\"" . $this->baseUrl () ."/images/barrinhafundo.gif\" alt=\"" . $pesopercentual . "% realizado\" title=\"" . $pesopercentual . "% realizado\" height=\"10\" width=\"" . $fundo . "\" border=\"0\">";
		
		return $progressbar ;		
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
