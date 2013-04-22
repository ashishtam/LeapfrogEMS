<?php
Class Front_IndexController extends Zend_Controller_Action
{
     
    public function indexAction()
    {
        //echo 'sdfdsf';  die;
        $test='Front controller data';
        $this->view->showdata = $test;
    }
    
    public function aboutAction()
    {
        
    }
   
}



