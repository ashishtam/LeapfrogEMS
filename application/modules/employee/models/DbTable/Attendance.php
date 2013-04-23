<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_Model_DbTable_Attendance extends Zend_Db_Table_Abstract
{
    public $_name = "Attendance";
    
    public function addAttendance($data)
    {
        try
        {
            $data['emp_id'] = '1';
            $result = $this->insert($data);
            return $result;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
