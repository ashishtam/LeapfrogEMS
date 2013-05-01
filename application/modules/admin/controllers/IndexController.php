<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->_redirect('/admin/index/get-users');
    }
    
    public function homeAction()
    {
        
    }
    
    public function addUserAction()
    {
        $objDesignation = new Employee_Model_DbTable_Designation();
        $dataDesignation = $objDesignation->getDesignation();
        
        $objEmployee = new Employee_Model_DbTable_Employee();
        
        $objRole = new Admin_Model_DbTable_Roles();
        
        $dataRole = $objRole->getRoles();
        
        $form = new Admin_Form_Employee();
        $form->employeeForm($dataDesignation, $dataRole);
        $this->view->form = $form;
        
          
        
        if($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            
            
            if($form->isValid($formData))
            {
                $dataEmployee = $form->getValues();
                
                $objEmployee->addEmployee($dataEmployee);
                
                $this->_redirect('admin/index');
                
            }
        }
        
    }
    
    public function getUsersAction()
    {
        $objEmployee = new Employee_Model_DbTable_Employee();
        $objDesignation = new Employee_Model_DbTable_Designation();
        $objRole = new Admin_Model_DbTable_Roles();

        
        $employeeData = $objEmployee->getRecords();
        
//        echo '<pre>';        print_r($employeeData);die;
        $count = 0;
        foreach ($employeeData as $value) {
            $employeeData[$count]['designation'] = $objDesignation->getDesignationNameById($value['designation_id']);
            $employeeData[$count]['role'] = $objRole->getRoleNameById($value['role_id']);
            
            $count++;
        }
        
//                echo '<pre>';        print_r($employeeData);die;
//        $this->view->employeeRecords = $employeeData;
        $paginator = Zend_Paginator::factory($employeeData);
        $pageNumber = $this->_getParam('page');       
        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage(5);
        $this->view->paginator = $paginator;
        
    }

        
    
    public function editUserAction()
    {
         $form = new Admin_Form_EmployeeEdit();
         

        $this->view->form = $form; 
        if ($this->getRequest()->isPost()) { //die;
            $formData = $this->getRequest()->getPost();
//            print_r($formData);die;
            if ($form->isValid($formData))
            {
                $users = new Admin_Model_DbTable_Employee();
                $id = $this->getRequest()->getParam('id');  
//                print_r($id);die;
                $data = array(
                    'role_id' =>$_POST['role_id'],
                    'full_name'=>$_POST['full_name'],
                    'email_id'=>$_POST['email_id'],
                    'contact'=>$_POST['contact'],
                    'designation_id'=>$_POST['designation_id']
                    
                );

                $check = $users->updateEmployee($data, $id);
                if($check)
                {
                    $msg = 'User edit successful';
                }
                $this->_helper->redirector('get-users','index','admin');

            }
            else
            {
                $form->populate($formData);

            }
        } else {
            //uses model to retrieve the database row & toArray() is used to populate the form directly
            $id = $this->getRequest()->getParam('id');         
            if ($id > 0) {
                $users = new Admin_Model_DbTable_Employee();
                $userdata = $users->fetchRow('id=' . $id)->toArray();
                //print_r($userdata);die;
                $objDesignation = new Employee_Model_DbTable_Designation();
                $userdata['designation'] = $objDesignation->getDesignationNameById($userdata['designation_id']);
                $dataDesignation = $objDesignation->getDesignation();
                 
                $objRole = new Admin_Model_DbTable_Roles();
                 $dataRole = $objRole->getRoles();
        
                $form->employeeEditForm($dataDesignation, $dataRole);
                // print_r($userdata);die;
                $form->populate($userdata); 
            }
        }
        
    }
    
    public function deleteUserAction()
    {
  
       $id = $this->getRequest()->getParam('id');

       print_r($id);
       
       $objEmployee = new Admin_Model_DbTable_Employee();
       
       $result = $objEmployee->deleteEmployee($id);
       if($result)
       {
           $msg = "User has been deleted successfully.";
           $this->_helper->redirector('get-users','index');

           
       }
       
    }
    
    public function listProfileAction()
    {

//        $id = $this->getRequest->getParam('id');
        $id = $this->_getParam('id');
     
        $userObj = new Employee_Model_DbTable_Employee();
        $user = $userObj->getnamebyEid($id); 
        $this->view->user = $user;

    }
    
    
    public function listLeaveAction()
    {
        $objLeave = new Employee_Model_DbTable_LeaveModel();
        $objEmployee = new Employee_Model_DbTable_Employee();
        
        $data = $objLeave->fetchAll()->toArray();
        
        $count = 0;
        foreach ($data as $value)
        {
            $data[$count++]['name'] = $objEmployee->getName($value['emp_id']);
        }
        
        $this->view->data = $data;
    }
    
}
