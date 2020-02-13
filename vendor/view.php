<?php

class View {
        
    public $_title = "PHP MCV";

    function __construct()
    { 
        // do notthink 
    }
    
    function view(String $file, ...$argv){

        ob_start(); 
        if ($argv){ extract(...$argv); }
        require "views/".$file.".php";
        return ob_get_clean();
    }

    function json(Array $array){

        header('Content-Type:application/json; charset=utf-8');
        
        return json_encode($array);
    }
    
    function _static(String $file){

        return CONFIG['app']['url']."static/".$file;
    }


    function redirect(String $path, Int $time=0){
        header("Refresh:$time; url=".CONFIG['app']['url'].$path);
    }
    
}
