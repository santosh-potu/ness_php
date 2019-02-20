<?php
/**
 * File: FileParser.class.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * A class to parse the csv,NL files
 * @version 1.0
 */

 /**
 * Methods class.
 * @package libraries.FileParser
 * All other validations are handled at intial stage (index.php) so not required
 * as per the requirments
 */


class FileParser{
    
    var $items = array();
    var $file_name;
    var $file_type;
    var $file_handle;
    
   
    /**
     * Constructor intializes File processing data
     * @param array $args
     * Commnd line parameters / Request parameters are to be passed
     * as arguments
     */
    public function __construct($args = null) {
        if($args){
            $this->file_name = $args[1];
            $this->file_type = strtolower(pathinfo($this->file_name,PATHINFO_EXTENSION));
            $this->file_handle = fopen($this->file_name, "r");
            
            if(!$this->file_handle) {
                error_exit("{$this->file_name} File Not found");
            }else{ 
                //Check file extension valid
                if( !in_array($this->file_type, Config::$valid_file_extensions) ){
                    error_exit("File should be csv/nl file");
                }           
            }
        }
    }
    
    /**
     * items from the inpu file
     * @return array items array of item records  . 
     * each element is an Item object
     */
    public function getItems(){        
        
        Config::loadModel("Item");        
        $this->readFromFile();    
        
        return $this->items;
    }
    
    /**
     * Reads item records from file based on file type
     */
    private function readFromFile(){
        
        if($this->file_type == "csv"){
            $this->readFromCSV();
        }elseif($this->file_type == "nl"){
            $this->readFromNL();
        }
    }
    
    /**
     * Reads the data from CSV file and records are added to the Item list
     */
    private function readFromCSV(){
        
        $item = null;
        $item_tmp = array();
        $id_list = array();
        
        // Read from csv file
        while (($data = fgetcsv($this->file_handle, 1000, ",")) !== FALSE) {
              
            $num = count($data);
            $item = null;
        
            $item_tmp['id'] = $data[0];
            $item_tmp['name'] = $data[1];
            $item_tmp['qty'] = $data[2];
            $item_tmp['categories'] = $data[3];
            
            $item = new Item($item_tmp);
            
            /* Validated items are added to the list , if item with ID already
             * on the list it is ignored as per the business rules
             */
            if($item->isValidItem() && !(in_array($item->id,$id_list)) ){
                $this->items[] = $item;
                $id_list[] = $item->id;
            }
            
        } // end of while loop
   // var_dump($this->items);
        
    }
    
    /**
     * Reads the records from NL file
     */ 
    private function readFromNL(){
        
        $item = null;
        $item_tmp = array();
        $id_list = array();
        
        $counter = 0; // read ine by line from NL file 
        while (($line = fgets($this->file_handle)) !== false) {
            
            $data[] = trim($line,"\n\r");
            $counter++;
            if($counter == 4) { // each record has 4 fields so read 4 lines
                    
                $item_tmp['id'] = $data[0];
                $item_tmp['name'] = $data[1];
                $item_tmp['qty'] = $data[2];
                $item_tmp['categories'] = $data[3];
                
                $item = new Item($item_tmp);
            /* Validated items are added to the list , if item with ID already
             * on the list it is ignored as per the business rules
             */
                if($item->isValidItem() && !(in_array($item->id,$id_list)) ){
                    $this->items[] = $item;
                    $id_list[] = $item->id;
                }
                
                $item = $data= $item_tmp = null;
                $counter = 0; // one record reading completed so set counter
            }     
        } // end of while
   // var_dump($this->items);
        
    }
    
    /**
     * destructor to close the file handles used
     */
    public function __destruct() {
       
        if($this->file_handle) fclose($this->file_handle);
    }
    
} // end of FileParser Class