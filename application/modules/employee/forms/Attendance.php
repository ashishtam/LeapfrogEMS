<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee_Form_Attendance extends Zend_Form
{
    public $thresholdTime = '9:00:00';
    public $thresholdLeaveTime = '17:00:00';
    

    /**
     * 
     * Returns the form for the check In page
     * 
     * 
     */
    
    public function checkIn()
    {
        $date = new Zend_Date();
        $currentTime = $date->get('HH:m:s');
        $currentDate = $date->get('Y-MM-d');
        
      
             
        
        $this->setName('checkIn')
            ->setMethod('post');
//
        $dateForm = new Zend_Form_Element_Text('date',array('readonly' => 'readonly'));
        
        $dateForm->setLabel('Today\'s Date:')
                    ->setValue($currentDate)
//                    ->setRequired(true)
                    ->setAttrib('style','width: 100px;');
      
        
        //Current Time
        $checkInTimeForm = new Zend_Form_Element_Text('checkin_time',array('readonly' => 'readonly'));
//        $checkInTimeForm = new Zend_Form_Element_Text('checkin_time',array('disabled' => 'disabled'));
        
        $checkInTimeForm->setLabel('Check In Time:')
                    ->setValue($currentTime)
//                    ->setRequired(true)
                    ->setAttrib('style','width: 100px;');
      
        
        //status
        $diff = $this->checkTime($currentDate, $currentTime, $this->thresholdTime);
        
        if($diff >= 0)
            $status = "On Time";
        else
            $status = "Late";
        
        $statusForm = new Zend_Form_Element_Text('checkin_status',array('readonly' => 'readonly'));
        
        $statusForm->setLabel('Status:')
//                ->setRequired(true)
                ->setValue($status)
                ->setAttrib('style','width: 100px;');
        
        //reason for late
         // Add an Content element
        $reason = new Zend_Form_Element_Textarea('checkin_comments');
        
        $reason->setLabel('Reason for late:')
                ->setRequired(true)
                ->setAttrib('style', 'width: 400px;height:300px;border-collapse:collapse; border: 1px solid gray;border-radius:5px;line-height:20px;')
                ->setFilters(array('StringTrim'));
        
        //add an Submit element
        $submit = new Zend_Form_Element_Submit('submit');
        
        $submit->setLabel('Check In')
                ->setIgnore(true)
                ->setRequired(true);
        
        
        $this->addElement($dateForm);
        $this->addElement($checkInTimeForm);
        $this->addElement($statusForm);
        
        if($status == 'Late')
            $this->addElement ($reason);
        
        $this->addElement($submit);
        
        
        
    }
    

    
    
    /**
     * 
     * Returns the form for the checkout page
     * 
     */
    
    public function checkOut()
    {
        $date = new Zend_Date();
        $currentTime = $date->get('HH:m:s');
        $currentDate = $date->get('Y-MM-d');
        
                   
        
        $this->setName('checkOut')
            ->setMethod('post');

        //date
        $dateForm = new Zend_Form_Element_Text('date',array('readonly' => 'readonly'));
        
        $dateForm->setLabel('Today\'s Date:')
                    ->setValue($currentDate)
                    ->setAttrib('style','width: 100px;');
      
        
        //Current Time
        $checkOutTimeForm = new Zend_Form_Element_Text('checkout_time',array('readonly' => 'readonly'));
        
        $checkOutTimeForm->setLabel('Check Out Time:')
                    ->setValue($currentTime)
                    ->setAttrib('style','width: 100px;');
        
        
         //status
        $diff = $this->checkTime($currentDate, $currentTime, $this->thresholdLeaveTime);
        
        if($diff < 0)
            $status = "On Time";
        else
            $status = "Early";
        
        $statusForm = new Zend_Form_Element_Text('checkout_status',array('readonly' => 'readonly'));
        
        $statusForm->setLabel('Status:')
                ->setValue($status)
                ->setAttrib('style','width: 100px;');
        
        
        // Add an Content element
        $reason = new Zend_Form_Element_Textarea('checkout_comments');
        
        $reason->setLabel('Reason for early leave:')
                ->setRequired(true)
                ->setAttrib('style', 'width: 400px;height:300px;border-collapse:collapse; border: 1px solid gray;border-radius:5px;line-height:20px;')
                ->setFilters(array('StringTrim'));
        
         //add an Submit element
        $submit = new Zend_Form_Element_Submit('submit');
        
        $submit->setLabel('Check Out')
                ->setIgnore(true)
                ->setRequired(true);
        
        $this->addElement($dateForm);
        $this->addElement($checkOutTimeForm);
        $this->addElement($statusForm);
        
        if($status == 'Early')
            $this->addElement($reason);
        
        $this->addElement($submit);
        
      
    }
    
    
    
    /**
     * Returns the timestamp difference of the current time and the threshold time
     * @param $currentDate Current Date
     * @param $currentTime Current Time
     * @param $thresholdTime Threshold time
     * @return timestamp
     */
    
        private function checkTime($currentDate, $currentTime, $thresholdTime)
    {
//        if($time->isEarlier($this->_hourTime, Zend_Date::HOUR))
//        {
//            echo "Ontime";
//        }
//        else if($time->isEarlier($this->_hourTime + 1,Zend_Date::HOUR) && $time->isEarlier($this->_minuteTime,Zend_Date::MINUTE))
//        {
//            echo "On-time";
//        }
//        else
//            echo "Late";

        
        $currentTimestamp =  new Zend_Date($currentDate  . " " . $currentTime);;
        $thresholdTimestamp = new Zend_Date($currentDate . " " . $thresholdTime);
     
             
        $diff = $thresholdTimestamp->getTimestamp() - $currentTimestamp->getTimestamp();
        
        return $diff;
        
        
        
    }
    
}
