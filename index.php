<?php 
    // START SESSION     
    @session_start();
   		
    define("APP_PATH", dirname(dirname(__FILE__)));

    define('MAIN_URL' , empty($_GET['url']) ? "index" : $_GET['url'] );
    define('ACTION', array_shift($_GET['action']) ?? null );
    define('ARGV'  , array_shift($_GET['argv']) ?? null );

    define('CONFIG', require "./config.php"); 
    
    spl_autoload_register(function($name) {
        if (!file_exists($name.'.php')){
          require_once("vendor/".$name.".php");
        }elseif(file_exists($name.'.php')){
          require_once($name.".php");
        }else{
          die("Not found ".$name);
        }
    });


  use vendor\Bootstrap;
  new Bootstrap();

?>