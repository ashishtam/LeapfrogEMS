<?php

class Plugins_Auth extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(\Zend_Controller_Request_Abstract $request) {
        parent::preDispatch($request);
        $loginUrl = array('action' => 'login', 'controller' => 'index', 'module' => 'front');
        $allowedActions = array('login', 'logout');
        $allowedModules = array('front');
        $restrictedAction = array();
        $auth = Zend_Auth::getInstance();

        $redirect = new Zend_Controller_Action_Helper_Redirector();
       
       
        if (!in_array($request->getActionName(), $restrictedAction)) {
            if (!$auth->hasIdentity() && !in_array($request->getActionName(), $allowedActions) && !in_array($request->getModuleName(), $allowedModules)) {
                //goto login page
                $redirect->gotoRouteAndExit($loginUrl);
            }
        } else {
            $redirect->gotoSimpleAndExit('employee', 'index', 'index');
        }
         
        $acl = new Plugins_Acl();
        
        Zend_Registry::set('acl', $acl);
        
        $this->_aclCheck($auth, $request, $allowedModules, $allowedActions, $redirect);
    }

    private function _aclCheck($auth, $request, $allowed_modules, $allowed_actions, $redirect) {
        if ($auth->hasIdentity() && !in_array($request->getModuleName(), $allowed_modules) && !in_array($request->getActionName(), $allowed_actions)) {
            
            $resource = $request->getModuleName() . "_" . strtolower($request->getControllerName());
            $action = $request->getActionName();
            
            $has_per = $this->hasPermission($resource, $action, true);
            
            if (!$has_per) {
                $this->getResponse()
                        ->setHttpResponseCode(403);

                $request->setModuleName('front')
                        ->setControllerName('index')
                        ->setActionName('index')
                        ->setDispatched(true);
            }
        }
    }

    public function hasPermission($resource, $action, $applyToNavigation = false) {
        $auth = Zend_Auth::getInstance();
        
        #if admin return true (Access throughout the application)
        $roleModel=new Admin_Model_DbTable_Roles();
        
//        $superAdminId=$roleModel->getSuperAdminId();
//        $roleName=$roleModel->getRoleById($auth->getIdentity()->role_id);
        
        if ($auth->getIdentity()->role_id == '1')
            return true;
        
        $acl = Zend_Registry::get('acl');
        
//        if ($applyToNavigation) {
//            //assign acl to navigation
//            Zend_Layout::getMvcInstance()
//                    ->getView()
//                    ->navigation()
//                    ->setAcl($acl)
//                    ->setRole($auth->getIdentity()->role);
//        }
       
        return $acl->isAllowed($auth->getIdentity()->role_id, $resource, $action); 
        
    }

}

?>
