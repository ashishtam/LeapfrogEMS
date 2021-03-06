<?php

class Plugins_Auth extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(\Zend_Controller_Request_Abstract $request) {
        parent::preDispatch($request);
        
        
        $allowedAction = array('login','logout');
        $allowedModule = array('front');
        
        $redirector = new Zend_Controller_Action_Helper_Redirector();
        
        $auth = Zend_Auth::getInstance();
        if(!$auth->hasIdentity() && !in_array($request->getActionName(), $allowedAction) && !in_array($request->getModuleName(), $allowedModule))
        {
            $redirector->gotoUrl('/front/index/login');

        }
        
        $acl = new Plugins_Acl();
        Zend_Registry::set('acl', $acl);
        
        $this->_aclCheck($auth, $request, $allowedModule, $allowedAction, $redirector);

    }
    
    
    private function _aclCheck($auth, $request, $allowed_modules, $allowed_actions, $redirector)
    {
            if ($auth->hasIdentity() && !in_array($request->getModuleName(), $allowed_modules)
                                                             && !in_array($request->getActionName(), $allowed_actions))
            {
                $resource = $request->getModuleName()."_".strtolower($request->getControllerName());
                $action = $request->getActionName();


                $has_per = $this->hasPermission($resource, $action, true);


                if (!$has_per)
                {
                           $this->getResponse()
                                ->setHttpResponseCode(403);

                            $request->setModuleName('front')
                                    ->setControllerName('error')
                                    ->setActionName('index')
                                    ->setDispatched(true);
                }
            }
    }

    public function hasPermission($resource, $action, $applyToNavigation = false)
    {

            $auth = Zend_Auth::getInstance();

            #if admin return true (Access throughout the application)
            if($auth->getIdentity()->role_id == '1') return true;

            $acl = Zend_Registry::get('acl');



//		if($applyToNavigation)
//		{
//                    
//			//assign acl to navigation
//			Zend_Layout::getMvcInstance()
//                                        ->getView()
//                                        ->navigation()
//                                        ->setAcl($acl)
//                                        ->setRole($auth->getIdentity()->role_id);
//            
////                                
//                 }


            $actionId = $this->getActionId($resource, $this->splitToUpperCase($action));

            $result =  $acl->isAllowed($auth->getIdentity()->role_id, $resource, $actionId);

             return $result;
    }
        
        
    private function getActionId($resource, $action)
    {
        $objActions = new Admin_Model_DbTable_Actions();
        $objResources = new Admin_Model_DbTable_Resources();


//            echo $resource."<br>";
        $resourceId = $objResources->getResourceId($resource);

        $actionId = $objActions->getActionId($resourceId, $action);

//            print_r($actionId[0]);

        if($actionId)
            return($actionId[0]['id']);
    }
        
        
    public function splitToUpperCase($action) {
        $explode = explode('-', $action);
        $count = count($explode);
        $actionName = "";
        for ($i = 0; $i < $count; $i++) {
            if ($i > 0)
                $explode[$i] = ucfirst($explode[$i]);
            $actionName .= $explode[$i];
        }
        
        return $actionName;
    }
}

?>
