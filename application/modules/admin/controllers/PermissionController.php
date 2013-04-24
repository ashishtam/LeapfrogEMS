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

