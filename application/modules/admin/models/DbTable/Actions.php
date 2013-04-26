<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model_DbTable_Actions extends Zend_Db_Table_Abstract
{
    public $_name = "Actions";
    
    
    
    public function getActionsbyResourceId($resourceId)
    {
        $result = $this->fetchAll('resource_id='.$resourceId)->toArray();
        return $result;
    }
    
    
    /**
     * Inserts row in the table Actions
     * @param type $data Requires data as fields in table Actions
     */
    public function insertAction($data)
    {
        try
        {
            $this->insert($data);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    
    /**
     * Returns the Row from the Action table where resource_id and name is matched
     * @param type $data ResourceId and Name
     * @return type array
     */
    public function checkAction($data)
    {
        try 
        {
            $result = $this->fetchRow("resource_id = ".$data['resource_id']. " AND name ='".$data['name']."'");
//            print_r($result);
            return $result;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    
    }
    
    /**
     * Returns the ActionId from the query
     * @param type $resourceId Resource id
     * @param type $action Action name
     * @return type array
     */
     public function getActionId($resourceId, $action)
    {
        try 
        {
            $whereSql = "resource_id = " . $resourceId. " and name='".$action."'";
//            echo $whereSql." ".$resourceId." ".$action."<br>";
           $result = $this->fetchAll($whereSql)->toArray();
            return $result;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    
    public function getActionNamebyId($actionId)
    {
        try
        {
            foreach($actionId as $value)
            {

                $action = $this->fetchRow('id ='.$value)->toArray();
                $actionName[]['name'] = $action['name'];
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
        
        return $actionName;
    }
}
