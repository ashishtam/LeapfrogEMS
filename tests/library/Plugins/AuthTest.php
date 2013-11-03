<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Plugins_AuthTest extends Zend_Test_PHPUnit_ControllerTestCase {
    
    public function testSplitToUpperCase() {
        $actualInput = "get-users";
        $objAuth = new Plugins_Auth();
        
        $expectedOutput = "getUsers";
        $actualOutput = $objAuth->splitToUpperCase($actualInput);
        
        $this->assertEquals($expectedOutput, $actualOutput);
        
    }
    
    public function testSplitToUpperCaseNoHyphen() {
        $actualInput = "getusers";
        $objAuth = new Plugins_Auth();
        
        $expectedOutput = "getusers";
        $actualOutput = $objAuth->splitToUpperCase($actualInput);
        $this->assertEquals($expectedOutput, $actualOutput);
    }
    
    public function testSplitToUpperCaseNullValue() {
        $actualInput = null;
        $objAuth = new Plugins_Auth();
        
        $expectedOutput = null;
        $actualOutput = $objAuth->splitToUpperCase($actualInput);
        $this->assertEquals($expectedOutput, $actualOutput); 
    }
    
    public function testSplitToUpperCaseHyphenOnly() {
        $actualInput = "-";
        $objAuth = new Plugins_Auth();
        
        $expectedOutput = "";
        $actualOutput = $objAuth->splitToUpperCase($actualInput);
        $this->assertEquals($expectedOutput, $actualOutput); 
    }
    
//    public function testSplitToUpperCaseWrong() {
//        $actualInput = "get-users";
//        $objAuth = new Plugins_Auth();
//        
//        $expectedOutput = "get-Users";
//        $actualOutput = $objAuth->splitToUpperCase($actualInput);
//        $this->assertFalse(); 
//    }
}
