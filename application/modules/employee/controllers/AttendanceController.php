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
        
    }
    
    public function checkOutAction()
    {
        
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
