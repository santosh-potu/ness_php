<?php
/**
 * File: error.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * A file represnts view
 * To dispaly errors in the application
 * @version 1.0
 */

 /**
 * view layer file - to display error
 * @package views.error.php
 */

if(is_set($error_message)) $error_message = "Some unknown error occured" ;

echo_n($error_message);
