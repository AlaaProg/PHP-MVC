<?php 


class Session{

	public function __construct(){

		foreach($_SESSION as $key => $val){
			$this->{$key} = $val;
		}
		
	}

	public static function Id(){

		return session_id();
	}

	function __debugInfo(){
		return $_SESSION;
	}

	function __toString(){

		return json_encode($_SESSION);
	}

	public function __set($key, $val){

		$_SESSION[$key] = $val;
	}

	public function __get($key){
		return $_SESSION[$key] ?? null;
	}

	public static function set($key, $value){
		$_SESSION[$key] = $value;
	}

	public static function get($key=null){
		return $_SESSION[$key] ?? null;
	}	

	public static function delete($key=null){
		if(!is_null($key)){		

			if (isset($_SESSION[$key])){
				unset($_SESSION[$key]) ;
			}

		}

		session_commit();
	}

}