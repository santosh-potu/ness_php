<?php
/**
 * File: config.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * Configuration file that also contains some library functions and autoload
 * Autoload and other libray functions provided
 * We can set most of the configuartion parameters for the application here.
 * @version 1.0
 */

 /**
 * Methods class
 * @package config.php
 */
class Config{
 
    static  $valid_file_extensions = array('csv','nl');
    static $id_format = "/\d{2}[-][a-zA-z]{2}[-][a-zA-Z]{2}\d{2}/";
    static $error_reporting = E_ALL && ~E_NOTICE;
    
    static $valid_commands = array('find-all' => 0,
                                   'find-by-id' => 1,
                                   'group-by-category' => 0,
                                   'find-by-category' => 1,
                                    );
    
    /**
     * Loads the model class specified
     * @param String $modelName string representing model class name
     */
    public static function loadModel($modelName){
        
        require_once "models".DIRECTORY_SEPARATOR."$modelName.class.php";
    }

    
}// End of class Config


//require "controllers".DIRECTORY_SEPARATOR."indexController.class.php";

/**
 * Magic method autoload overrided to load classes automatically
 * @overrides __autoload
 * @param string $classname
 */
function __autoload($classname) {
    
    
    if(is_numeric( strpos($classname, 'Controller')) ){
        $filename = "controllers".DIRECTORY_SEPARATOR."$classname.class.php";
    }else{    
        $filename = "libraries".DIRECTORY_SEPARATOR."$classname.class.php";
    }
    
    require_once($filename);
}

/**
 * Returns newline charecter based on the execution medium
 * wheather commond line/Web server
 * @return string returns new line character
 */
function newline_char(){
    
    if(is_command() ){
            $new_line_char = "\n";
    }else{
        $new_line_char = "<br/>";
    }
    
    return $new_line_char;
}

/**
 * adds new line and echos/prints it on output medium automatically
 *  depending on command line / web server 
 */
function echo_n($string){    
    
    echo $string.newline_char();
}

/**
 * Displays error and stops execution
 * @param string $string 
 * error string containging error information
 * @param int $error_code 
 * error code to return to OS
 */
function error_exit($string ,$error_code =0){    
    echo_n($string);
    exit($error_code);
}

/**
 * Checks wheather execution medium is command line or not
 * @return boolean is_command_line
 * retuns true if execution mediuam is command line
 */
function is_command(){    
    return php_sapi_name() == "cli" ;
}

//EOF