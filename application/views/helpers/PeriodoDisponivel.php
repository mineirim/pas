<?php
/**
 *
 * @author marcone
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * PeriodoDisponivel helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_PeriodoDisponivel {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function periodoDisponivel($inicial, $tipo) {
		$mi = substr ( $inicial, 4, 2 );
		$Yi = substr ( $inicial, 0, 4 );
		 
		$mf = date('m');
		$Yf = date('Y');
		
		$dt_inicial = mktime ( 0, 0, 0, $mi, 1, $Yi );
		$dt_final = mktime ( 0, 0, 0, $mf, 1, $Yf );
		$meses_disponiveis = array ();
		$anos_disponiveis = array ();
		while ( $dt_inicial <= $dt_final ) {
			
			$anos_disponiveis [date ( "Y", $dt_inicial )] = date ( "Y", $dt_inicial );
			$meses_disponiveis [date ( "Ym", $dt_inicial )] = date ( "m/Y", $dt_inicial );
                        if ($tipo == 1) {
                            $dt_inicial = strtotime ( "+1 month", $dt_inicial );
                        } elseif($tipo == 3){
                            $dt_inicial = strtotime ( "+3 month", $dt_inicial );
                        } elseif($tipo == 4){
                            $dt_inicial = strtotime ( "+6 month", $dt_inicial );
                        }
		}

		
		$ret="";
		if($tipo==2){
			foreach ($anos_disponiveis as $k=>$v)
				$ret.="$k:$v;";
                }else {//}elseif ($tipo==1){
			foreach ($meses_disponiveis as $k=>$v)
				$ret.="$k:$v;";
		}
		
		return $ret;
	}

		
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

