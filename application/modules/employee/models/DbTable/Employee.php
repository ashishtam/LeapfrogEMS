<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_Model_DbTable_Employee extends Zend_Db_Table_Abstract
{
    public $_name = "Employee";
    
    
    
    /**
     * Get all the records of the employee
     * @return array returns rows from database
     */
    
    public function getRecords()
    {
        $result = $this->fetchAll($this->select()->order('id ASC'))->toArray();
        return $result;
    }
    
    public function getName($id)
    {
        $name = $this->fetchRow('id='.$id)->toArray();
        
        return $name['full_name'];
    }
    
    
     public function getnamebyEid($idn)
    {
        try
        {
           $Objcv = new Employee_Model_DbTable_ProfileModel();
           $identity = Zend_Auth::getInstance()->getIdentity();
           
            $db = Zend_Db_Table::getDefaultAdapter();
            $select=$db->select() 
                    ->from($this->_name.' as user')
//                    ->joinInner($Objcv->_name.' as emp',"emp.emp_id= user.id", array('emp_id'));
                    ->from($Objcv->_name. ' as cv')
                    ->where("user.id=cv.emp_id")
                    ->where("user.id=$idn");
//            echo $select; die;
                    
            $action=$select->query();
            $result=$action->fetchAll();
            return $result;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
       
    /**
     * Add the records of new employee
     * @param $data-
     * Includes the fields of table employee
     * @return boolean true or false
     * 
     */
    public function addEmployee($data)
    {        
        try 
        {
            $data['password'] = md5($data['password']);
            $result = $this->insert($data);
        
        return $result;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    
    /**
     * 
     * @param type $data
     */
    public function updateEmployee($data)
    {
        
    }
    
    
    /**
     * deletes the employee record from the table
     * @param $id - Id of the employee
     * @return boolean, true or false
     */
    public function deleteEmployee($id)
    {
        try
        {
            $result = $this->delete('id='.$id);
            return $result;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
