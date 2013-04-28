<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_AttendanceController extends Zend_Controller_Action
{
    private $auth;
    private $empId;
    
    public function init()
    {
        $this->auth = Zend_Auth::getInstance();
        $this->empId = $this->auth->getIdentity()->id;
    }
    
    public function indexAction()
    {
    
    }
    
    public function historyAction()
    {
        $auth = Zend_Auth::getInstance();
        
        $objAttendance = new Employee_Model_DbTable_Attendance();
        
        
        $dataAttendance = $objAttendance->getAttendance($auth->getIdentity()->id);
        
//        print_r($dataAttendance);
        
        $this->view->data = $dataAttendance;
        
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
                
               $objAttendance->addAttendance($data, $this->empId);
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
                
                $attendanceId = $objAttendance->getAttendanceIdByDate($this->empId);
                $objAttendance->updateAttendance($data, $attendanceId, $this->empId);
                
          
            }
         } 
    }
    
    public function applyLeaveAction()
    {
   
        if($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();

            if($formData)
            {
                $auth = Zend_Auth::getInstance();
                $identity = $auth->getIdentity();
                
                $result = array(
                    'emp_id'=>$identity->id,
                    'from_date'=> $_POST['from_date'],
                    'to_date'=>$_POST['to_date'],
                    'reason'=>$_POST['reason']
                );
                //print_r($result);die;

                $savObj = new Employee_Model_DbTable_LeaveModel;
                $savObj->saveLeave($result);
        
            }
        }   
    }
    
}
