<?php 
namespace vendor;

use vendor\RefClass;

class Bootstrap  {

    private $ref = null;
	
    function __construct() {

            if (MAIN_URL){
                $argv = explode("/", trim(MAIN_URL,"/"));
                $this->cls  =  array_shift($argv);
                $ctrl = 'app\\Controllers\\'.$this->cls; 
                if (file_exists($ctrl.".php")){
                    echo $this->requireCtrl($ctrl,$argv);

                }else if(file_exists('app\\Controllers\\index'.".php")){
                    array_unshift($argv, $this->cls);

                    echo $this->requireCtrl('app\\Controllers\\index',$argv);
                }else{

                    echo $this->error_page();
                }
            }
        
    }

    function error_page(){
        // 
        return "Error Page";
    }

   	function requireCtrl($cls,$argv){
        
        $this->ref = new RefClass($cls);
        $methodname = null ;

        if (isset($argv[0]) && $this->ref->check_method($argv[0]) ){

              $methodname = array_shift($argv); 
        }else if($this->ref->check_method($this->cls)){

           $methodname = $this->cls;

        }else if( $this->ref->check_method('index') ){
            $methodname = 'index';

        }


        if ($methodname != null){
            $args = $this->ref->args($methodname);
            if ($argv){
                array_push($args, ...$argv);
            }
            $method = $this->ref->method($methodname, $args) ; 

        }else{
            
           $method = $this->error_page() ;  
        }

        ob_clean();
        if ( $this->ref->check_method("__invoke")){

            return $this->ref->__invoke() ;
        }
        return $method;
    }

}