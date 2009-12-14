<?php

/**
 * @see Zend_View_Helper_Abstract
 */
require_once 'Zend/View/Helper/HeadScript.php';

/**
 * Gera o script que sera executado no carregamento da página
 *
 * @author Tales Augusto <tales.augusto.santos@gmail.com>
 * 
 * @filesource
 * 
 */
class Tavs_View_Helper_JQuery extends Zend_View_Helper_Abstract
{
	/**
	 * Guarda o conteudo que sera executado ao carregar o body
	 *
	 * @var string
	 */
	private $_onReadyContent;

	/**
	 * Retorna o objeto Tavs_View_Helper_JQuery_
	 *
	 * @return Tavs_View_Helper_JQuery_
	 */
	public function jQuery()
	{
		return $this;
	}

	/**
	 * Adiciona conteudo ao script
	 *
	 * @param string $content Conteudo a ser adicionado
	 * 
	 * @return Tavs_View_Helper_JQuery_
	 */
	public function appendContent($content)
	{
		$this->_onReadyContent .= (string) $content;
		return $this;
	}

	/**
	 * Cria o script que e executado quando a pagina for carregada
	 *
	 * @param string $content
	 * 
	 * @return Tavs_View_Helper_JQuery_
	 */
	private function _getjQueryStart($content)
	{
		$content = '$(function() {' . PHP_EOL . $content . PHP_EOL . '});';
		return $content;
	}

	/**
	 * Gera a tag script
	 *
	 * @return string
	 */
	public function render()
	{
		$script = '';

		if ( !empty($this->_onReadyContent) )
		{
			$content = $this->_getjQueryStart($this->_onReadyContent);
			$script .= '<script type="text/javascript">' . PHP_EOL;
			$script .=  $this->_escapeContent($content);
			$script .= '</script>';
		}

		return $script;
	}

	/**
	 * Escapa o conteudo HTML
	 *
	 * @param string $content Conteudo a ser escapado
	 * 
	 * @return string
	 */
	private function _escapeContent($content)
	{
		$script  = '//<![CDATA[' . PHP_EOL;
		$script .= $content . PHP_EOL;
		$script .= '//]]>' . PHP_EOL;
		
		return $script;
	}
	
	/**
	 * Atalho para Tavs_View_Helper_JQuery_::render
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
	
}