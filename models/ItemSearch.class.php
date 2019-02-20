<?php
/**
 * File: Item.class.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * A class to perform Item Search operations
 * @version 1.0
 */

 /**
 * Methods class.
 * @package models.ItemSearch
 * @desc: Item Search opearation 
 */
class ItemSearch{
    
    var $items;
    var $commands ;
    
    /**
     * Intializes Item search
     * @param array $items 
     * array of item objects used for searcj
     * @param array $commands
     * array of command strings to perform search
     */
    public function __construct($items = null,$commands = null) {
        $this->items = $items;
        $this->commands = $commands;
    }
    
    /**
     * Sets search parameters
     * @param array $items 
     * array of item objects used for searcj
     * @param array $commands
     * array of command strings to perform search
     */
    public function setSearchItems($items = null,$commands = null) {
        $this->items = $items;
        $this->commands = $commands;
    }

    /**
     * Validates search commands or parameters
     * @global type $argv
     * @param array $commands
     * commands/parameters to perform search
     * @return boolean is_validated
     * returns true if search commands are valid
     */
    public function validateCommands($commands = null){
        
        global $argv;    
        $this->commands = $commands;
        //var_dump($this->commands);
        
        $command = $commands[0];
        $param = $commands[1];
        
        if(!count($commands) || !strlen(trim($command)) ){
            error_exit("command missing after file name: {$argv[1]}\n"
            . "Ideal command-> <file-name> <command> [<search-parameter>]"); 
        }
        
        $valid_commands = array_keys(Config::$valid_commands);
        //var_dump($valid_commands);
        
        if(!in_array($command,$valid_commands)){
            // invalid command
            error_exit("Not a valid command");
            return false;
        }else{
            //check parameter (ID / category) required or not
            $param_exists = Config::$valid_commands[$command];
            
            if($param_exists && strlen(trim($param)) < 1){                
                error_exit("Search parameter for command <$command> missing ");
                return false;
            }
            
        }
            return true;
    
   
    }
    
    /**
     * Searches Item list and returns the search results
     * @param string $commands
     * search commands as array
     * @return array searchResuls
     * returns items list as search results 
     */
    public function searchByCommand($commands = null){      
               
        if($commands == null) $commands = $this->commands;
       //var_dump($this->commands);

        $command = $commands[0];
        $param = $commands[1];
        
        $searchResults = null;
        
        if(!$this->validateCommands($commands))   return $searchResults;
        
            switch($command){
                
                case 'find-by-id':
                    $searchResults = $this->searchById($param);
                    break;
                
                case 'find-by-category':
                    $searchResults = $this->searchByCategory($param);
                    break;
                case 'group-by-category':
                    $searchResults = $this->groupByCategory();
                    break;
                case 'find-all':
                default:
                    $searchResults = $this->items;
                    
            }          
        // by default Return all i.e find-all
        return $searchResults;
        
    }
    
    /**
     * searches for given id in the item list
     * @param string $id
     * item id
     * @return array searchResults
     * returns Items list as searh result
     */
    private function searchById($id){
        
        $searchResults = null;
        $items = $this->items;
        if(strlen(trim($id)) == 0 ) return $searchResults;
        
        foreach($items as $item){
           if($item->id == $id){
               $searchResults[] = $item;
           }     
        }
        
        return $searchResults;
        
    }
    
    /**
     * returns ithe items for given category
     * @param string $category
     * category name
     * @return array searchResults
     * returns catgorized items (by category)
     */
    private function searchByCategory($category){
        
        $searchResults = null;
        $items = $this->items;
        if(strlen(trim($category)) == 0 ) return $searchResults;
        
        foreach($items as $item){
           foreach($item->categories as $category_tmp)
            if($category == $category_tmp){
               $searchResults[] = $item;
           }     
        }
        return $searchResults;
    }
    
    /**
     * returns items category wise
     * @return array items
     * returns items category wise
     */
    private function groupByCategory(){
        
        $searchResults = null;
        $items = $this->items;        
        
        foreach($items as $item){
           foreach($item->categories as $category_tmp){            
               $searchResults[$category_tmp][] = $item;
           }     
        }
        
        return $searchResults;
    }
    
    
} //End of class itemSearch