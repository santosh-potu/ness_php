<?php
/**
 * File: index.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * Index file or default file
 * @version 1.0
 */

 /**
 * file - to exexute the appplication
 * @package index.php
 */

/* load config file first */
require 'config.php';
error_reporting(Config::$error_reporting);


// validate arguments first

if( $argc < 2){    
    //other param is optional in case of find-all
    error_exit("Invalid arguments: - valid format <file> <command> [<search_param>]");
    exit(0);
}

// router routes request to the apprapriate controller
$router = new Router();
$router->route();

// End of index file