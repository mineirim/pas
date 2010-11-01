<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
	protected function _initAppAutoload()
	{
		$autoloader = new Zend_Application_Module_Autoloader(array(
			'namespace' => '',
			'basePath' => dirname(__FILE__),
		));
		return $autoloader;
	}
	protected function _initRestRoute() {
	    $this->bootstrap('frontController');
	    $frontController = Zend_Controller_Front::getInstance();
	    $restRoute = new Zend_Rest_Route($frontController, 
	    					array(), 
	    					array('admin')
	    					);
	    $frontController->getRouter()->addRoute('rest', $restRoute);
	}
}