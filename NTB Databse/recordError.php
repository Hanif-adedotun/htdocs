<?php

//This file is for testing and recording of error into ntb_error.log


function recordError($text){
    if(file_exists("ntb_error.log")){
      $file = fopen("ntb_error.log", "a+") or die("Could not access file");
    }else{
       $file = fopen("ntb_error.log", "w+");
    }
  
    if (flock($file, LOCK_EX)){//prevent another user from using the file at the same time
    
        // class datatime
        // {
        //   public $time_value;
        // }
        // $time_stamp = new datatime();
        // $time_stamp->time_value = date("l, F jS, Y - g:i:sa", time()); 

       $date_text =  date("l, F jS, Y - G:i:s a", time()).' [Error]: '. $text . "\n";
       fwrite($file, $date_text) or die("Could not write to file");

       flock($file, LOCK_UN);//unlocks the file 
    }
    
    fclose($file);//Close the file
}
?>