<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_IndexController extends Zend_Controller_Action {

    
  
    
    public function indexAction() {
        $objEmployee = new Employee_Model_DbTable_Employee();
        $objDesignation = new Employee_Model_DbTable_Designation();

        $employeeData = $objEmployee->getRecords();
        //echo '<pre>';        print_r($employeeData);die;
        $count = 0;
        foreach ($employeeData as $value) {
            $employeeData[$count++]['designation'] = $objDesignation->getDesignationNameById($value['designation_id']);
        }

        $this->view->employeeRecords = $employeeData;
    }
    
     public function profileAction() {
         
         $auth = Zend_Auth::getInstance();
         $identity = $auth->getIdentity();
                
         
         $objProfile = new Employee_Model_DbTable_ProfileModel();
         
         $query = $objProfile->fetchRow('emp_id='. $identity->id);
         
            
         if(count($query) == 0)
         {
         
            $form = new Employee_Form_ProfileForm();
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



                    $values['emp_id'] = $identity->id;
                    $values['address'] = $_POST['address'];

                    $year=$_POST['DisplayUntil_year'];

                    $month = sprintf("%02s", $_POST['DisplayUntil_month']);
                    $day = sprintf("%02s", $_POST['DisplayUntil_day']);


                    $values['DOB'] = $year.'-'.$month.'-'.$day;

                    $values['info'] = $_POST['info'];

                    $values['image_name'] = $info['image_name']['name']; //print_r($values);die;
                    // echo $values['photo_name']; die;
                    $Savedata = new Employee_Model_DbTable_ProfileModel();

                    $check = $Savedata->insert($values);              // echo 'asd';die;
                    if ($check) {
                        echo 'Profile saved successfully';

                      $this->_redirect('/employee/index/list-profile');


                    } else {
                        echo 'Insertion error';

                    }
                } else {
                    echo 'Invalid form data';
                }
            }
         }
         
         else
         {
             echo "Already Profile Created!!";
         }
    }
    
    public function listProfileAction()
    {      
        $userObj = new Employee_Model_DbTable_Employee();
        $auth = Zend_Auth::getInstance();
        $id = $auth->getIdentity()->id;
        $user = $userObj->getnamebyEid($id); 
        $this->view->user = $user;

    }
    
     public function editProfileAction()
    {
//         $form = new Employee_Form_ProfileForm();
//         
//
//        $this->view->form = $form; 
//        if ($this->getRequest()->isPost()) { //die;
//            $formData = $this->getRequest()->getPost();
////            print_r($formData);die;
//            if ($form->isValid($formData))
//            {
//                $profileCV = new Employee_Model_DbTable_ProfileModel();
//                
//                $id = Zend_Auth::getInstance()->id;
////                print_r($id);die;
////                
//                $data = $form->getValues();
//
//                $data['DOB'] = $data['DisplayUntil_year']."-".$data['DisplayUntil_month']."-".$data['DisplayUntil_day'];
//                echo "<pre>";
//                
//                unset($data['DisplayUntil_year']);
//                unset($data['DisplayUntil_month']);
//                unset($data['DisplayUntil_day']);
//                
//                if($data['image_name'] == "")
//                    unset($data['image_name']);
//                
//                print_r($data);
//
//                    
//                try {
//                        $check = $profileCV->update($data, 'emp_id='.$id);
//                    if($check)
//                    {
//                        $msg = 'User edit successful';
//                    }
//                
//                }
//                catch(Exception $e)
//                {
//                    echo $e->getMessage();
//                }
//                
////                $this->_helper->redirector('get-users','index','admin');
//                $this->_redirect('/employee/index/list-profile');
//            }
//            else
//            {
//                $form->populate($formData);
//            }
//        } else {
//            //uses model to retrieve the database row & toArray() is used to populate the form directly
//            $id = $this->getRequest()->getParam('id');         
//            if ($id > 0) {
//                $profiles = new Employee_Model_DbTable_ProfileModel();
//                $userdata = $profiles->fetchRow('id=' . $id)->toArray();
//                
//                $this->view->imageName = $userdata['image_name'];
//                $form->populate($userdata);
//            }
//        }
    }
    

}
