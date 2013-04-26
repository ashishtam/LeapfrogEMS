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
        
//        echo "<pre>";
//        print_r($resources);
//        echo "</pre>";
//        die;
        
        $objResource = new Admin_Model_DbTable_Resources();
        $objAction = new Admin_Model_DbTable_Actions();
        
        
        $resourcesList = $objResource->getAllResourcesName();
        
          $foundResource = null;
          $addedResource = null;
          $count = 0;
          
          foreach($resources as $key => $resource)
          {
              $arrResources = array_keys($resource);

              
              foreach($arrResources as  $value)
              {

                  $data = '';
                  $res = explode("_",$value);
                  $data['name'] = $value;
                  $data['description'] = ucfirst($res[1])." Controller - ".ucfirst($res['0'])." Module";
                  
                  try{
                      if(!in_array($data['name'], $resourcesList))
                      {  $res = $objResource->insert($data);
                       if($res)
                        {
                            $addedResource .= "<li>".$data['description']."</li><br/>";
                            $count++;
                        }
                      }
                      
                      $foundResource .= "<li>".$data['description']."</li><br/>";
                  }
                  catch(Exception $e)
                  {
                      echo "<br>msg: ".$e->getMessage();
                  }
                                           
                  
                 
              }
              
              $countKey = 0;
              foreach($resource as $key=>$action)
                   {
                        $resourceId = $objResource->getResourceId($arrResources[$countKey++]);
                       
                       foreach($action as $value)
                       {
                           $dataAction = array('name' => $value,
                                                'resource_id' => $resourceId);
                           
                           $checkAction = $objAction->checkAction($dataAction);
                           
                           if(!$checkAction)
                           {
                                $objAction->insertAction($dataAction);    
                           }
                       }
                       

                   }
              
          }
          
          
          $this->view->foundResource = $foundResource;
          if($count)
          {    
                $this->view->addedResource = $addedResource;
          }
          else
          {   
                $this->view->addedResource ='No new resource found';
          }
   
      }
}
