<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Model_DbTable_ProfileModel extends Zend_Db_Table_Abstract {

    public $_name = "CV_Info";

    public function getProfile()
    {
        $result = $this->fetchAll()->toArray();
        return $result;
        
    }

}

