<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAutoload()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Plugins_');
        $autoloader->registerNamespace('Helper_');
    }
    
    protected function _initPlugins()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Plugins_SelectLayout());
        $front->registerPlugin(new Plugins_Auth());
    }
    
    protected function _initRoutes()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/routes.ini');
        $router = Zend_Controller_Front::getInstance()->getRouter();
        // print_r($router);die;
        $router->addConfig($config, 'routes');
    }
    
     protected function _initActionHelper()
    {
        Zend_Controller_Action_HelperBroker::addHelper(new Helper_Asset());
    }
    

    protected function _initTimeZone() {
        date_default_timezone_set('Asia/kathmandu');
    }

      
}