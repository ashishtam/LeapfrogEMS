<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_Model_DbTable_Designation extends Zend_Db_Table_Abstract
{
    public $_name = 'Designation';
    
    
    public function getDesignation()
    {

        $result = $this->fetchAll()->toArray();

        return $result;
    }
    
    
    
    public function getDesignationNameById($id)
    {
        $query = $this->fetchRow($this->select()
                        ->where('id = '.$id))->toArray();
                        
        return $query['name'];
        
    }
}