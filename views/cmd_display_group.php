<?php

/**
 * File: cmd_display_group.php
 * @author Santosh Kumar Potu <santoshreddy.potu@gmail.com>
 * A file represnts view
 * @version 1.0
 */

 /**
 * view layer file - to display categorized items(By category) on console
 * @package views.cmd_display_group.php
 */


$categories = $data['categories'];

if(!count($categories)){
    error_exit("No results found.");
}else{
     
    foreach($categories as $category_name => $items){
        
        $print_line .= "$category_name".newline_char();        
                
            foreach($items as $item){
                $print_line .= "-".$item->id." ".$item->name." (".$item->qty.")".  newline_char();
            }
            $print_line .= newline_char();
    }
     
    echo $print_line; //out put to console
} // End of if

