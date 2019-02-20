<?php
/**
 * File: indexContoller.class.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * Index Contoller class handles request by deafult 
 * i.e if no contoller and action specified this class will be called
 * @version 1.0
 */

 /**
 * Methods class.
 * @package controlles.index
 * @desc: Index Contoller class handles request by deafult
 */

class indexController extends Controller{
    
    /**
     * Performs deafult action
     * @param array $args 
     * array contains request paramters as array element
     */
    public static function indexAction($args = null){
        
        if($args){           
            Config::loadModel("ItemSearch");                
            $commands = array($args[2],$args[3]);                
            $itemSearch = new ItemSearch();
                
            if($itemSearch->validateCommands($commands)){
                
                $fileParser = new FileParser($args);                
                $items = $fileParser->getItems();
                $itemSearch->setSearchItems($items,$commands);
                $items = $itemSearch->searchByCommand();
                
                if(is_command()){
                    $display_view = "cmd_display_items";// load command line view
                }else{
                    $error_message = "Only Command line accessed allowed currently";
                    $display_view = "error";
                }                
                if($args[2] == 'group-by-category'){
                    $data['categories'] = $items;
                    $display_view = "cmd_display_group";                    
                    self::display_view($display_view,$data);
                    exit(0);     
                }                
                $data['items'] = $items;                
                self::display_view($display_view,$data);
            }
        }
              
    }
    
   
        
}//end of class indexContoller