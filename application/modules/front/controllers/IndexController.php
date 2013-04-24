<?php
Class Front_IndexController extends Zend_Controller_Action
{
     
    public function indexAction()
    {
        //echo 'sdfdsf';  die;
        $test='Front controller data';
        $this->view->showdata = $test;
    }
    
    public function aboutAction()
    {
        $test='Front controller data';
        $this->view->showdata = $test;
        
    }
    
     public function loginAction()
    {
        //Zend_Layout::getMvcInstance()->setLayout('layout');
        $form = new Front_Form_LoginForm;

        $this->view->loginfrm = $form;
        
       $request = $this->getRequest();
//       print_r($request);die;

        if ($request->isPost()) {

            if ($form->isValid($request->getPost())) {

                if ($this->_process($form->getValues())) {

                    // We're authenticated! Redirect to the home page

                    $this->_helper->redirector('index', 'index','employee');

                }
            else {
                    $msg = 'Wrong username or password. Please try again!';
                    $this->view->missmatchmsg = $msg;
                }
            }

        }
       $messages = $this->_helper->FlashMessenger->getMessages('actions');
       // print_r($messages);die;
        $this->view->msg = $messages;
        $this->view->loginfrm = $form;  
    }
    
    protected function _process($values)

    {

        // Get our authentication adapter and check credentials

        $adapter = $this->_getAuthAdapter();

        $adapter->setIdentity($values['email_id']); 

        $adapter->setCredential($values['password']);



        $auth = Zend_Auth::getInstance();

        $result = $auth->authenticate($adapter);

        if ($result->isValid()) {

            $user = $adapter->getResultRowObject();

            $auth->getStorage()->write($user);

            return true;

        }

        return false;

    }
    
    protected function _getAuthAdapter() {

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

        

        $authAdapter->setTableName('Employee')

            ->setIdentityColumn('email_id')

            ->setCredentialColumn('password')

            ->setCredentialTreatment('MD5(?)');

        return $authAdapter;

    }
}



