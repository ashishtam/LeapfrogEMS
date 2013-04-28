<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        
    }
    
    public function addUserAction()
    {
        $objDesignation = new Employee_Model_DbTable_Designation();
        $dataDesignation = $objDesignation->getDesignation();
               
        $objEmployee = new Employee_Model_DbTable_Employee();
                
        $form = new Admin_Form_Employee();
        $form->employeeForm($dataDesignation);
        $this->view->form = $form;
        
          
        
        if($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            
            
            if($form->isValid($formData))
            {
                $dataEmployee = $form->getValues();
                
                $objEmployee->addEmployee($dataEmployee);
                
                
            }
        }
        
    }
    
    public function getUsersAction()
    {
        $objEmployee = new Employee_Model_DbTable_Employee();
        $objDesignation = new Employee_Model_DbTable_Designation();

        $employeeData = $objEmployee->getRecords();
        //echo '<pre>';        print_r($employeeData);die;
        $count = 0;
        foreach ($employeeData as $value) {
            $employeeData[$count++]['designation'] = $objDesignation->getDesignationNameById($value['designation_id']);
        }
//        $this->view->employeeRecords = $employeeData;
        $paginator = Zend_Paginator::factory($employeeData);
        $pageNumber = $this->_getParam('page');       
        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setItemCountPerPage(5);
        $this->view->paginator = $paginator;
        
    }

        public function profileAction() {
        $form = new Admin_Form_ProfileForm();
        $this->view->form = $form;

        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) { 

                $adapter = new Zend_File_Transfer_Adapter_Http();
                $info = $adapter->getFileInfo(); 

                $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads'; 
                try {
                    
                    $adapter->setDestination($uploadPath);  
                    $adapter->receive();
                
                } catch (Zend_File_Transfer_Exception $e) {
                    $e->getMessage();
                }
               
 
                
                $auth = Zend_Auth::getInstance();
                $identity = $auth->getIdentity();
                $values['emp_id'] = $identity->id;
                $values['address'] = $_POST['address'];
      
                $year=$_POST['DisplayUntil_year'];
                            
                $month = sprintf("%02s", $_POST['DisplayUntil_month']);
                $day = sprintf("%02s", $_POST['DisplayUntil_day']);
                                  
                
                $values['DOB'] = $year.'-'.$month.'-'.$day;
                
                $values['info'] = $_POST['info'];
                
                $values['image_name'] = $info['image_name']['name']; //print_r($values);die;
                // echo $values['photo_name']; die;
                $Savedata = new Admin_Model_DbTable_ProfileModel();

                $check = $Savedata->insert($values);              // echo 'asd';die;
                if ($check) {
                    echo 'Profile saved successfully';
                    exit;
//                    $this->_helper->redirector->gotoRoute(array
//                        ('controller' => 'cms',
//                        'action' => 'showimages'));
                } else {
                    echo 'Insertion error';
                    die;
                }
            } else {
                echo 'Invalid form data';
            }
        }
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
                $form->employeeEditForm($dataDesignation);
                // print_r($userdata);die;
                $form->populate($userdata); 
            }
        }
        
    }
    
    public function deleteUserAction()
    {
//       $id = $this->_getParam('id');
       $id = $this->getRequest()->getParam('id');

      // print_r($id); die;
       $objEmployee = new Admin_Model_DbTable_Employee();
       
       $result = $objEmployee->deleteEmployee($id);
       if($result)
       {
           $msg = "User has been deleted successfully.";
           $this->_helper->redirector('get-users','index');

           
       }
       
    }
    
}
