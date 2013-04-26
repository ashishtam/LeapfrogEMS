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
    
    public function editUserAction()
    {
        
    }
    
    public function deleteUserAction()
    {
       $id = $this->_getParam('id');
       
       $objEmployee = new Employee_Model_DbTable_Employee();
       
       $objEmployee->deleteEmployee($id);
       
    }
    
}
