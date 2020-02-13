<?php 
namespace app;

use Model;

class User extends Model{


	public $tablename = 'users';

	protected $primary_key = 'id';


	protected $fields = [
		"id", 'fullname', 'email', 'password' ,'role_id'
	];


	protected $hide_fields = [
		'role_id', 'password'
	];

	function role(){


		return $this->hasOne("app\Role");
	}

	/*	
		$user->select()

		select * from users JOIN roles ON roles.id=users.role_id where user=id
		
	*/
}