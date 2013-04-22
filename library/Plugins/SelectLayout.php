<?php

Class Plugins_SelectLayout extends Zend_Controller_Plugin_Abstract{
    
    function preDispatch(Zend_Controller_Request_Abstract $request) {
        parent::preDispatch($request);
        //echo 'ads'; die;
        $module = $request->getModuleName();
        $layout = Zend_Layout::getMvcInstance();
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $options = $bootstrap->getOptions();
//        echo '<pre>';
//        print_r($options);die;
        $layoutpath = $options['resources']['layout']['layoutPath'].$module;
        
        $layout->setLayoutPath($layoutpath);
        $layout->setLayout('layout');
        
//        echo '<pre>';
//        echo $layoutpath;
    }
}
