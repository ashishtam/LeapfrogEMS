<?php

class Employee_Form_ProfileForm extends Zend_Form {

    public function init() {
        $this->setName("addprofile");
        $this->setMethod('post');
        $this->setEnctype('multipart/form-data');
        // create text input for name
        $address = new Zend_Form_Element_Text('address');
        $address->setLabel('Address:')
                ->setOptions(array('size' => '40'))
                ->setRequired(true)
                ->setValidators(array
                    (array
                        ('stringLength', false, array(0, 255))));

        // create text input for day for dob
        $displayUntilDay = new Zend_Form_Element_Select('DisplayUntil_day');
        $displayUntilDay->setLabel('Date of Birth:')
                ->addValidator('Int')
                ->addFilter('HtmlEntities')
                ->addFilter('StringTrim')
                ->addFilter('StringToUpper')
                ->setDecorators(array(
                    array('ViewHelper'),
                    array('Label', array('tag' => 'dt')),
                    array('HtmlTag',
                        array(
                            'tag' => 'div',
                            'openOnly' => true,
                            'id' => 'divDisplayUntil',
                            'placement' => 'prepend'
                        )
                    ),
        ));
        for ($x = 1; $x <= 31; $x++) {
            $displayUntilDay->addMultiOption($x, sprintf('%02d', $x));
        }
        
        // create text input for month for dob
        
        $displayUntilMonth = new Zend_Form_Element_Select('DisplayUntil_month');
        $displayUntilMonth->addValidator('Int')
                ->addFilter('HtmlEntities')
                ->addFilter('StringTrim')
                ->setDecorators(array(
                    array('ViewHelper')
        ));
        for ($x = 1; $x <= 12; $x++) {
            $displayUntilMonth->addMultiOption(
                    $x, date('M', mktime(1, 1, 1, $x, 1, 1)));
        }
        
        // create text input for year for dob
        $displayUntilYear = new Zend_Form_Element_Select('DisplayUntil_year');
        $displayUntilYear->addValidator('Int')
                ->addFilter('HtmlEntities')
                ->addFilter('StringTrim')
                ->setDecorators(array(
                    array('ViewHelper'),
                    array('HtmlTag',
                        array(
                            'tag' => 'div',
                            'closeOnly' => true
                        )
                    ),
        ));
        for ($x = 1940; $x <= 2012; $x++) {
            $displayUntilYear->addMultiOption($x, $x);
        }
        
        //use textarea and ckeditor for info data
        $info = new Zend_Form_Element_Textarea('info',array('required'));
        $info->setLabel('Info:');
        $info->setRequired(true);
        
        //for image upload
        $image_name = new Zend_Form_Element_File('image_name');
        $image_name->setLabel('Upload an image (jpg,jpeg,png,gif):');
   
        // limits the filesize on the client side
        $image_name->addValidator('Count', false, 1);                // ensure only 1 file
        $image_name->addValidator('Size', false, 10240000);            // limit to 10 meg
        $image_name->addValidator('Extension', false, 'jpg,jpeg,png,gif')
                ->setRequired(TRUE); // only JPEG, PNG, and GIFs
        
// create submit button
        $submit = new Zend_Form_Element_Submit(
                'submit', array('class' => 'submit'));
        $submit->setLabel('Save');
        $submit->setIgnore(true);
// attach elements to form
        $this->addElement($address)
                ->addElement($displayUntilDay)
                ->addElement($displayUntilMonth)
                ->addElement($displayUntilYear)
                ->addElement($info)
                ->addElement($image_name)
                ->addElement($submit);
    }

}