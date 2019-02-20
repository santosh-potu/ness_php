<?php

/**
 * File: Router.class.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * Base Router class for application
 * @version 1.0
 */

 /**
 * Methods class.
 * @package libraries.router
 * @desc: Router class 
 */
class Router{
    var $contoller ;
    var $action;
    var $request;

    /**
     * constructor intializes object
     */
    public function __construct(){

        $controller = $_REQUEST['c'];
        $action = $_REQUEST['a'];

        if($controller == null) $controller = "index";
        if($action == null) $action = "index";

        $this->controller = $controller;
        $this->action = $action."Action";
        $this->request = $_REQUEST;
    }
    /**
     * Routes the request to the appropriate Contoller and executes the 
     * requested action
     * @global type $argv
     * @param string $controller
     * @param string $action
     */ 
    public function route($controller =null,$action=null){

        global $argv;

        if($controller == null) $controller = "index";
        if($action == null) $action = "index";
        $this->controller = $controller."Controller";
        $this->action = $action."Action";

        is_command()? ($args = $argv) : ($args = $this->request);
        call_user_func("{$this->controller}::{$this->action}",$args);


    }

} // End of class Router
