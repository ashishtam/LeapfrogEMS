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
}
