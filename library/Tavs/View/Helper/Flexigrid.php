<?php

/**
 * @see Zend_View_Helper_HtmlElement
 */
require_once 'Zend/View/Helper/HtmlElement.php';

/**
 * @see Zend_Json
 */
require_once 'Zend/Json.php';

/**
 * Gera o HTML da tabela do flexgrid
 *
 * @author Tales Augusto <tales.augusto.santos@gmail.com>
 * 
 * @uses Zend_View_Helper_HtmlElement 
 * 
 * @filesource
 * 
 */
class Tavs_View_Helper_Flexigrid extends Zend_View_Helper_HtmlElement 
{
	/**
	 * Long desc
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 * 
	 * @param string $selector
	 * @param array $options
	 * @param array $tableAttribs
	 * 
	 * @uses Zend_Json
	 * 
	 * @return string $table
	 */
	public function flexigrid($selector, array $options, array $tableAttribs)
	{
		$onready_content = '$("'. $selector .'").flexigrid(' . Zend_Json::encode($options) . ')'; 
		$view = $this->view;
		$view->jQuery()->appendContent($onready_content);
		
		$table = '<table' . $this->_htmlAttribs($tableAttribs)  . '>' . PHP_EOL;
		$table .= '<tr><td class="hidden"><!--&nbsp;--></td></tr>' . PHP_EOL;
		$table .= '</table>' . PHP_EOL;

		return $table;
	}
}