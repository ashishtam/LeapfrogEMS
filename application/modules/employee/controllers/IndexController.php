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
                $Savedata = new Employee_Model_DbTable_ProfileModel();

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

}
