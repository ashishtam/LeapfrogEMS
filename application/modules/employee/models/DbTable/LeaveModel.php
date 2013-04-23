<?php

class Employee_Model_DbTable_LeaveModel extends Zend_Db_Table_Abstract{
    public $_name = "Leave";
    
    public function saveLeave($data)
    {
        try{
            $result = $this->insert($data);
            return $result;
            
        }
        catch(Exception $excep){
            echo $excep->getMessage();
        }
    }
}
