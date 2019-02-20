<?php

/**
 * File: Item.class.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * A class to represent Item Object
 * @version 1.0
 */

 /**
 * Methods class.
 * @package models.Item
 * @desc: Item object and its operations 
 */
class Item{
    
    var $id;
    var $name;
    var $qty;
    var $categories = array();
    
    /**
     * Constructor to intialize item data
     * @param array $item_array consisiting of item data
     */
    public function __construct($item_array = null) {
        
        if(is_array($item_array)){
            $this->id = $item_array['id'];
            $this->name = $item_array['name'];
            $this->qty = $item_array['qty'];
            
            $this->categories =  explode(';',$item_array['categories']);
            $cat_count = count($this->categories);
            for($i=0;$i< $cat_count;$i++){
                if(strlen(trim($this->categories[$i])) == 0){
                    unset($this->categories[$i]);
                    // remove empty category or space
                }
            }
        }//end of if
        
    }
    
    /**
     * validates item by applying business rules
     * @return boolean returns true if valid item
     */
    public function isValidItem(){
        
        if(!$this->validateId()) {
            //echo_n("Id {$this->id}"); 
            return false;
        }
        if(!$this->validateQty()) {
           // echo_n("Qty {$this->qty}"); 
           return false;
        }
        if(!$this->validateName()) {
           // echo_n("Name {$this->name}"); 
           return false;
        }
        return true;
    }

    /**
     * validates id as per business rules
     * @return boolean is_valid_id returns rue if valid id
     */
    public function validateId(){
        
        return preg_match(Config::$id_format,  $this->id);
    }
    
    /**
     * validates the length of item name by trimming as per business rules
     * @return bollean is_valid_item_name
     */
    public function validateName(){
        
        return strlen(trim($this->name)) > 0;
    }
    
    /**
     * validates qunatity as per business rules
     * @return boolean if_valid_Quantity 
     * retuns true if valid quantity
     */
    public function validateQty(){

        $int_val = (int)$this->qty;
        if( $int_val < 1) return false; //if negitive qty retun false
        
         // if qty is float return false
        if(is_float($this->qty+0)) return false;
        return true;        
    }
    
    
}//End of Item Class


