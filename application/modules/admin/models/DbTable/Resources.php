<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_Model_DbTable_Resources extends Zend_Db_Table_Abstract
{
    public $_name = "Resources";
    
    public function getAllResourcesName()
    {
        $result = $this->fetchAll()->toArray();
        
        foreach($result as $key=>$value)
        {
          $name[] = $value['name'];  
        }
   
        
        return $name;
        
    }
    
    public function getResources()
    {
        try
        {
            $result = $this->fetchAll()->toArray();
            return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
          
        }
       
    }
    
    
    public function getResourceId($name)
    {
        try 
        {
           $id = $this->fetchRow($this->select()->where("name = '".$name."'"))->toArray();
           return $id['id'];
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
}