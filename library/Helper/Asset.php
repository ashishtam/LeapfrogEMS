<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Helper_Asset extends Zend_Controller_Action_Helper_Abstract
{
    public function getList()
    {
        $module_dir = $this->getFrontController()->getControllerDirectory();
        $resources = array();
   
   
        unset($module_dir['default']);
        
        foreach ($module_dir as $dir => $dirpath) {
            $diritem = new DirectoryIterator($dirpath);

            foreach ($diritem as $item) {
                if ($item->isFile()) {
                    if (strstr($item->getFilename(), 'Controller.php') != FALSE) {
                        include_once $dirpath . '/' . $item->getFilename();
                    }
                }
            }

            foreach (get_declared_classes() as $class) {
                if (is_subclass_of($class, 'Zend_Controller_Action')) {
                    $functions = array();
                    #get module from class
                    $res = explode('_', $class);
                    if ($res[0] == ucfirst($dir)) {
                        foreach (get_class_methods($class) as $method) {
                            if (strstr($method, 'Action') != false) {
                                array_push($functions, substr($method, 0, strpos($method, "Action")));
                            }
                        }

                        $c = strtolower(substr($class, 0, strpos($class, "Controller")));
                        $resources[$dir][$c] = $functions;
                    }
                }
            }

        }
        ksort($resources);
        
        return $resources;
    }
}
