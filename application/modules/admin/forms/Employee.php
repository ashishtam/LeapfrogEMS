<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Form_Employee extends Zend_Form
{
    public function employeeForm($designationList)
    {
        $this->setName('addEmployee')
             ->setMethod('post');
        
        
       
        //Full Name element
        $name = new Zend_Form_Element_Text('full_name');
        
        $name->setFilters(array('StringTrim'))
                ->setValidators(array(array('Alpha', false,  array('allowWhiteSpace' => true), array('message' => array(Zend_Validate_Alnum::NOT_ALNUM=>'Name can only contain alphabets with space'))
                                                )))
                ->setRequired(true)
                ->setAttrib('style', 'width: 250px;border-collapse:collapse; border: 1px solid gray;border-radius:5px;line-height:20px;')
                ->setAttrib('placeholder','Full Name')
                ->setLabel('Title');
        
        
        //email address
        $email = new Zend_Form_Element_Text('email_id');
        
        $email->setRequired(true)
                ->setLabel('Email:')
                ->setAttribs(array('placeholder' => 'Email'))
                ->setFilters(array('StringTrim'))
                ->addValidator('EmailAddress', true);
        
            
                
         //password
        $password = new Zend_Form_Element_Password('password');
        
        $password->setRequired(true)
                ->setLabel('Password:')
                ->setAttribs(array('placeholder' => 'Password'))
                ->setFilters(array('StringTrim'), array('StripTags'));
     
        
        //contact
        $contact = new Zend_Form_Element_Text('contact');
        
        $contact->setRequired(true)
                ->setLabel('Contact Number:')
                ->setAttribs(array('placeholder' => 'Contact No'))
                ->setFilters(array('StringTrim'), array('StripTags'))

                ->addValidator('Digits', true);
       
        //Designation
        $menuList = array();
        foreach($designationList as $key=>$value)
        {  
            $menuList[$value['id']] = $value['name'];   
        }
          
        $designation = new Zend_Form_Element_Select('designation_id');
        
        $designation->setLabel('Designation:')
                    ->setMultiOptions($menuList)
                    ->setRequired(true);      

        
        
       //submit 
       $submit = new Zend_Form_Element_Submit('submit');
        
        $submit->setLabel('Add Employee')
                ->setIgnore(true)
                ->setRequired(true);
        
        
        $this->addElement($name);
        $this->addElement($email);
        $this->addElement($password);
        $this->addElement($contact);
        $this->addElement($designation);
        $this->addElement($submit);
        
      
    }
    
}
