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
        
        try
        {
                $actionList = $objActionList->getActionsbyResourceId($info['resource']);
                
                $permittedActionId = $objPermissions->getActionId($info['resource'], $info['role_id']);
            
                $permittedActionName = $objActionList->getActionNamebyId($permittedActionId);
                
       
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
       
        print Zend_Json_Encoder::encode(array('actionList' => $actionList, 'actionName' => $permittedActionName));
               
        
        
    }
    
    public function addPermissionAction()
    {
        
    }
    
    public function editPermissionAction()
    {
        
    }
    
    public function deletePermissionAction()
    {
        
    }
    
}

