<?php

/**
 * File: cmd_display_items.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * A file represnts view
 * @version 1.0
 */

 /**
 * view layer file - to display items on console
 * @package views.cmd_display_items.php
 */


$items = $data['items'];
//var_dump($items);
//exit();


if(!count($items)){
    error_exit("No results found.");
}else{
    
    $count = 0;
    
    foreach($items as $item){
        
        $count++;
        $print_line .= $item->id." ".$item->name." (".$item->qty.")".  newline_char();
       
        foreach($item->categories as $category){
                if(strlen($category) > 0){
                    $print_line.= "- {$category}".newline_char();
                }
            }
        
        $print_line .= newline_char();
    } // End of for each
    
    echo $print_line; // prints out put to console
} // End of If
