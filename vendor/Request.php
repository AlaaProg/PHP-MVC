<?php 


class Request{


	static function query(String $key=null){

		return $_GET[$key] ?? $_GET;
	}

	static function session(){

    	return new Session();
    }

	static function status(){

		return $_SERVER['REDIRECT_STATUS'];
	}

    static function input(String $key=null){

    	if( !is_null($key) ){
    		return isset($_POST[$key]) ? $_POST[$key] : null;
    	}

    	return (object)$_POST;
    }

    static function file(String $key=null){

    	if( !is_null($key) ){
    		return isset($_FILE[$key]) ? $_FILE[$key] : null;
    	}

    	return (object) $_FILE;
    }

	static function url(){
		
		return $_SERVER['REQUEST_URI'];
	}

	static function method($method=null){

		return $method != null ? $_SERVER['REQUEST_METHOD'] == $method : $_SERVER['REQUEST_METHOD'];
	}

	static function ip(){

		if (isset($_SERVER['HTTP_CLIENT_IP'])){
			return $_SERVER['HTTP_CLIENT_IP'];

		}else if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ){
			return $_SERVER['HTTP_X_FORWARDED_FOR'];

		}else if ( isset($_SERVER['HTTP_X_FORWARDED']) ){
			return $_SERVER['HTTP_X_FORWARDED'];

		}else if ( isset($_SERVER['HTTP_FORWARDED_FOR']) ){
			return $_SERVER['HTTP_FORWARDED_FOR'];

		}else if ( isset($_SERVER['HTTP_FORWARDED']) ){
			return $_SERVER['HTTP_FORWARDED'];

		}else if ( isset($_SERVER['REMOTE_ADDR']) ){
			return $_SERVER['REMOTE_ADDR'];	

		}else{
			return "UNKNOWN";
		}
	}

	static function cookie($key){

		return $_COOKIE[$key];
	}
}