<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $objEmployee = new Employee_Model_DbTable_Employee();
        $objDesignation = new Employee_Model_DbTable_Designation();
        
        $employeeData = $objEmployee->getRecords();
        //echo '<pre>';        print_r($employeeData);die;
        $count = 0;
       foreach($employeeData as $value)
       {
          $employeeData[$count++]['designation'] = $objDesignation->getDesignationNameById($value['designation_id']);
          
       }
               
        $this->view->employeeRecords = $employeeData;
        
    }
    
    public function profileAction()
    {
        
    }
    
}
