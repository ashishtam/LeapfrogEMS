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

       $attendanceData = $objAttendance->getAttendanceIdByDate($this->empId);
       
        if($attendanceData !=0)
        {    
            $this->view->data = $attendanceData;
            $this->view->status = 'checkin';
        }   
        else
        {
            $this->view->status = 'none';
        }

        if ($this->getRequest()->isPost()) {
           if ($form->isValid($_POST)) {
                $data = $form->getValues();
//                print_r($data);
                
                    $objAttendance->addAttendance($data, $this->empId);
                    
                    $this->_redirect('/employee/attendance/check-in');
               
           }
         } 
    }
    
    public function checkOutAction()
    {
        $objAttendance = new Employee_Model_DbTable_Attendance();
        
        $form = new Employee_Form_Attendance();
        $form->checkOut();
        
        $this->view->form = $form;
         
        $attendanceData = $objAttendance->getAttendanceIdByDate($this->empId);
       
        if($attendanceData['checkout_status'] != null)
        {    
            $this->view->data = $attendanceData;
            $this->view->status = 'checkout';
        }   
        else
        {
            $this->view->status = 'none';
        }

         if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $data = $form->getValues();
                
                $attendanceId = $objAttendance->getAttendanceIdByDate($this->empId);
                $objAttendance->updateAttendance($data, $attendanceId['id'], $this->empId);
                
                $this->_redirect('/employee/attendance/check-out');
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
        
                $this->_redirect('/employee/attendance/history');
            }
        }   
    }
    
}
