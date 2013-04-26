<?php 
//class Employee_Form_LeaveForm extends Zend_Form{
//    
//    public function init() {
//        $this->setName("leaveform");
//        $this->setMethod("post");
//        
//
//        
////        $employee = new Zend_Form_Element_Text('employee_id');
////        
////        $employee->setLabel('Empoyee Id:')
////                ->setRequired(true)
////                ->setFilters(array('StringTrim'), array('StripTags'));
//        
//        //Add leave date range
//      $from_date = new Zend_Validate_Date('from_date');
//      $from_date->setLabel('From date(yyyy-mm-dd):')
//              ->setRequired(true)
//              ->setFilters(array('StringTrim'), array('StripTags'));
//     
//      $to_date = new Zend_Validate_Date();
//      $to_date->setLabel('To date(yyyy-mm-dd):')
//              ->setRequired(true)
//              ->setFilters(array('StringTrim'), array('StripTags'));
//        
//        $reason = new Zend_Form_Element_Text('reason');
//        $reason->setLabel('Reason:')
//                ->setRequired(true)
//                ->setFilters(array('StringTrim'), array('StripTags'));
//         
//       $submit = new Zend_Form_Element_Submit('submit');
//        
//        $submit->setLabel('Apply Leave')
//                ->setIgnore(true)
//                ->setRequired(true);
//        
//       // $this->addElement($element);
//        $this->addElement($from_date);
//        $this->addElement($to_date);
//        $this->addElement($reason);
//        $this->addElement($submit);      
//    }
//}
