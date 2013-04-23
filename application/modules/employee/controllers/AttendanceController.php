<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_AttendanceController extends Zend_Controller_Action
{
    public function indexAction()
    {
        
    }
    
    public function checkInAction()
    {
        
        $objAttendance = new Employee_Model_DbTable_Attendance();
        
        $form = new Employee_Form_Attendance();
        $form->checkIn();
        
        $this->view->form = $form;
        
         if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $data = $form->getValues();
                
                $objAttendance->addAttendance($data, '1');
            }
         }
    }
    
    public function checkOutAction()
    {
        $objAttendance = new Employee_Model_DbTable_Attendance();
        
        $form = new Employee_Form_Attendance();
        $form->checkOut();
        
        $this->view->form = $form;
        
         if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $data = $form->getValues();
                
                $objAttendance->updateAttendance($data, '3', '1');
                
          
            }
         }
    }
    
    public function applyLeaveAction()
    {
        
    }
    
}
