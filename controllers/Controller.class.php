<?php
/**
 * File: Controller.class.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * Base Contoller class for application
 * @version 1.0
 */

 /**
 * abstract class.
 * @package contollers.contoller
 * @desc: Contoller class 
 */
 abstract class Controller{
     
     /**
      * Index Action default Action for the controller
      * tobe implemented by child class
      * @param array $args 
      */
     abstract static function indexAction($args =null);
         
     /**
      * Renders the view
      * @param string $view_name view name
      * @param array $data to be passed to view layer
      */
     static protected function display_view($view_name,$data = null){
        
        $data = $data;
        $view_name = getcwd().DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.$view_name.".php";
        
        if(file_exists($view_name)){
            require_once $view_name;
        }else{
            error_exit("View not found ");
        }
    }

 }

