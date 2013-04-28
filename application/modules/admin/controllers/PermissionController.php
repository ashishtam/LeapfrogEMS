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

                
                $actionList = $objActionList->getActionsbyResourceId($info['resource']);
                
                $permittedActionId = $objPermissions->getActionId($info['resource'], $info['role_id']);

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
       
        print Zend_Json_Encoder::encode(array('actionList' => $actionList ,'actionName' => $permittedActionName, 'count' =>$count));
               
        
        
    }
    
      
    public function editPermissionAction()
    {
            $flag = 0;
            
            $info = $this->getRequest()->getPost();
            $this->_helper->layout->disableLayout();
            
            $resourceId =  $info['resourceId'];
            $roleId = $info['roleId'];
            
            if(!empty($info['actionList']))
            {
                foreach($info['actionList'] as $value)
                {
                    $actionList[] = $value;
                }
            }
            
            
            $objPermission = new Admin_Model_DbTable_Permissions();
            $objAction = new Admin_Model_DbTable_Actions();
            
            $actionId = $objPermission->getActionId($resourceId, $roleId);
            
            $queryAction = $objAction->getActionsbyResourceId($resourceId);
            
            if(!empty($queryAction))
            {
                foreach($queryAction as $value){
                    $actionIdTotal[] = $value['id'];
                }
            }
            
//            print_r($actionList);
//            print_r($actionId);
//            print_r($actionIdTotal);
            
             
            $permissionToDelete = array();
            
            
            if(!empty($actionList))
            {
                foreach($actionList as $value)
                {
                    if(!in_array($value,$actionId))
                    {
                        $data['role_id'] = $roleId;
                        $data['resource_id'] = $resourceId;
                        $data['action_id'] = $value;

                        $result = $objPermission->insert($data);
                        
                        if(!$result)
                        {
//                            echo "Error Inserting";
                            $flag = 1;
                        }
                    }

                }
                
                foreach($actionIdTotal as $value)
                {
                    if(!in_array($value,$actionList))
                    {
                        $permissionToDelete[] = $value;
                    }
                }
                
                foreach ($permissionToDelete as $value)
                {
                    $result = $objPermission->deletePermission($roleId, $resourceId, $value);
//                    if(!$result)
//                    {
//                        echo "Error Deleting";
//                        
//                    }
                }
            }
            
            
            
            
            print Zend_Json_Encoder::encode($flag);
          
    }
    
       
}

