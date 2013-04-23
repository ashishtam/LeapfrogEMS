<?php 
Class Front_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initRoutes()
    {
        $config = new Zend_Config_Ini(dirname(__FILE__).'/configs/routes.ini');
        $router = Zend_Controller_Front::getInstance()->getRouter();
        // print_r($router);die;
        $router->addConfig($config, 'routes');
    }
    
}