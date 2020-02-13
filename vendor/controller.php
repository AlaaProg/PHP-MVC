<?php



class Controller extends View{


    public function session(){

    	return new Session();
    }

    // public function get(String $key=null){

    // 	if(!is_null($key)){
    // 		return isset($_GET[$key]) ? $_GET[$key] : null;
    // 	}

    // 	return (object)$_GET;
    // }

    // public function input(String $key=null){

    // 	if( !is_null($key) ){
    // 		return isset($_POST[$key]) ? $_POST[$key] : null;
    // 	}

    // 	return (object)$_POST;
    // }

    // public function file(String $key=null){

    // 	if( !is_null($key) ){
    // 		return isset($_FILE[$key]) ? $_FILE[$key] : null;
    // 	}

    // 	return (object) $_FILE;
    // }
    
}

