<?php 
namespace Database; 

use Database\Drive;

class DB extends Drive{

	public static function __callStatic($method, $parameters){
		$pdo = parent::get_drive();

		return call_user_func_array(array($pdo, $method), $parameters);
	}


}