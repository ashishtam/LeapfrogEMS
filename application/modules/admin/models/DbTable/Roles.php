<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model_DbTable_Roles extends Zend_Db_Table_Abstract
{
    public $_name = "Roles";
    
    public function getRoles()
    {
        try
        {
            $result = $this->fetchAll($this->select()->where("name != 'Super Admin'"))->toArray();
            
            return $result;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function getRoleNameById($id)
    {
         $query = $this->fetchRow($this->select()
                        ->where('id = '.$id))->toArray();
                        
        return $query['name'];
    }
}
