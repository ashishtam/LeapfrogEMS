<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_ResourcesController extends Zend_Controller_Action
{
    public function init()
    {
        
    }
    
    public function autoAction()
      {

          $resources = $this->_helper->Asset->getList();

          $objResource = new Admin_Model_DbTable_Resources();

          $foundResource = null;
          $count = 0;

          foreach($resources as $key => $resource)
          {
              $arrResources = array_keys($resource);

               print_r($arrResources);


              foreach($arrResources as  $value)
              {

                  $data = '';
                  $res = explode("_",$value);
                  $data['name'] = $value;
                  $data['description'] = ucfirst($res[1])." Controller - ".ucfirst($res['0'])." Module";

                  try{
                       $res = $objResource->insert($data);
                  }
                  catch(Exception $e)
                  {
                      echo "<br>msg: ".$e->getMessage();
                  }

                  //print_r($result);
                  if($res)
                  {
                      $foundResource .= $data['description']."<br/>";
                      $count++;
                  }
              }
          }


          if($count)
          {
                $this->view->foundResource = $foundResource;
          }
          else
          {
                $this->view->foundResource ='No new resource found';
          }
   
      }
}
