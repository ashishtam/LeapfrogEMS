<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model_DbTable_Permissions extends Zend_Db_Table_Abstract
{
    public $_name = "Permissions";
    
    public function getActionId($resourceId, $roleId)
    {
        $actionId = array();
        try
        {
            $query = $this->fetchAll('resource_id = '.$resourceId.' AND role_id='.$roleId)->toArray();
           
            foreach($query as $key=>$value)
            {
                $actionId[] = $value['action_id'];
            }
            
            return $actionId;
            
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    
    public function deletePermission($roleId, $resourceId, $actionId)
    {
        try 
        {
            $count = count($this->getActionId($resourceId, $roleId));
            
            if($count !=0)
            {   
                $result = $this->delete('role_id='.$roleId." and resource_id=".$resourceId." and action_id=".$actionId);
                return $result;
            }
            
        
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
}
