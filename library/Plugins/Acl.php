<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Plugins_Acl extends Zend_Acl
{

        public function __construct()
        {
            self::roleResource();
        }

        
        private function initRoles()
        {
           
           $obj_role = new Admin_Model_DbTable_Roles();
           $roles = $obj_role->fetchAll($obj_role->select()->order('id DESC'))->toArray();
            foreach ($roles as $r) {
               $this->addRole(new Zend_Acl_Role($r['id']));
            }
           

        }

        private function initResources()
        {
            self::initRoles();

            $obj_resource = new Admin_Model_DbTable_Resources();
            $resources = $obj_resource->fetchAll($obj_resource->select()->order('name ASC'))->toArray();

            $module = '';
            foreach ($resources as $key=>$value)
            {
                if ($value['name'])
                {
                    $arr_resource = explode("_",$value['name']);

                    if($module != $arr_resource[0])
                    {
                        $this->add(new Zend_Acl_Resource($arr_resource[0]));
                        $module = $arr_resource[0];
                    }

                    $this->add(new Zend_Acl_Resource($value['name'],$arr_resource[0]));
                }
            }
           
        }

        private function roleResource()
        {
            self::initResources();
                    $obj_role = new Admin_Model_DbTable_Roles();
                    $obj_resource = new Admin_Model_DbTable_Resources();
                    $obj_permission = new Admin_Model_DbTable_Permissions();
                    
            $db  =  Zend_Db_Table::getDefaultAdapter();
            $acl = $db->fetchAll(
                   $db->select()
                        ->from($obj_role->_name. ' as r')
                        ->from($obj_resource->_name. ' as res')
                        ->from($obj_permission->_name. ' as p')
                        ->where('r.id = p.role_id and p.resource_id = res.id'));


                foreach ($acl as $key=>$value) 
                {
                   
                   try{
                       $this->allow($value['role_id'], $value['name'], $value['action_id']);
                   }
                    catch (Exception $e)
                    {
                        echo $e->getMessage();
                    }
               }
                        
        }
}

