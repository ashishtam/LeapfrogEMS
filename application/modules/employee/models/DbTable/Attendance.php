<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_Model_DbTable_Attendance extends Zend_Db_Table_Abstract
{
    public $_name = "Attendance";
    
    public function getAttendance($empId)
    {
        try
        {
            $result = $this->fetchAll($this->select()
                                            ->where('emp_id='.$empId)
                                            ->order('date DESC'))->toArray();
            return $result;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    
    public function addAttendance($data , $empId)
    {
        try
        {
            $data['emp_id'] = $empId;
            $result = $this->insert($data);
            return $result;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function updateAttendance($data, $id, $emp_id)
    {
        try
        {
//            echo "<pre>";
//            print_r($data);
//            echo "</pre>";
            
            $this->update($data, 'id='. $id . ' and emp_id ='. $emp_id);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    } 
    
    
    public function getAttendanceIdByDate($empId)
    {
        $today = new Zend_Date();
        $currentDate = $today->get('Y-MM-d');
     
        try
        {
            $result = $this->fetchRow("date='".$currentDate."' AND emp_id=".$empId);
            $count = count($result);
    
            if($count != 0)   
            {
                $result = $result->toArray();
                return $result;
            }
            else
            {
                return 0;

            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
