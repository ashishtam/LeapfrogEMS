<?php

class Front_Form_LoginForm extends Zend_Form {

    public function init() {
        $this->setName("loginform");
        $this->setMethod('post');

        // create text input for email
        $email_id = new Zend_Form_Element_Text('email_id');
        $email_id->setLabel('Email:')
                ->setOptions(array('size' => '10'))
                ->setRequired(true)
                 ->addFilter('stringTrim')
                ->addValidator('EmailAddress',TRUE);
        // create text input for password
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password:');
        $password->setOptions(array('size' => '10'))
                ->setRequired(true)
                ->addFilter('stringTrim')
                ->addValidators(array(array('stringLength',false,array(0,50))));
       
// create submit button
        $submit = new Zend_Form_Element_Submit(
                'submit', array('class' => 'submit'));
        $submit->setLabel('Login');
// attach elements to form
        $this->addElement($email_id)
                ->addElement($password)
                ->addElement($submit);

    }

}
