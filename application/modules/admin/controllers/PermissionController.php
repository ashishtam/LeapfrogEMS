<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_PermissionController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $objResources = new Admin_Model_DbTable_Resources();
        $objRoles = new Admin_Model_DbTable_Roles();
        
        $this->view->dataResources = $objResources->getResources();
        $this->view->dataRoles = $objRoles->getRoles();
        
    }
    
    public function getlistAction()
    {
        $info = $this->getRequest()->getPost();
        
        $this->_helper->layout->disableLayout();
        
        $objActionList = new Admin_Model_DbTable_Actions();
        $objPermissions = new Admin_Model_DbTable_Permissions();
        
        $actionList = array();
        $permittedActionId = array();
        $permittedActionName = array();
        $count = 0;
        
        try
        {
//                echo $info['resource'];
//                echo $info['role_id'];
                
                $actionList = $objActionList->getActionsbyResourceId($info['resource']);
//                $actionList = $objActionList->getActionsbyResourceId(5);
                
                $permittedActionId = $objPermissions->getActionId($info['resource'], $info['role_id']);
//                $permittedActionId = $objPermissions->getActionId(5,3);
//            
                if($permittedActionId != null)
                {
                    $permittedActionName = $objActionList->getActionNamebyId($permittedActionId);
                    $count = count($permittedActionName);
                }
                
       
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
       
//        print Zend_Json_Encoder::encode(array('actionList' => $actionList));
        print Zend_Json_Encoder::encode(array('actionList' => $actionList ,'actionName' => $permittedActionName, 'count' =>$count));
               
        
        
    }
    
      
    public function editPermissionAction()
    {
        
    }
    
       
}

