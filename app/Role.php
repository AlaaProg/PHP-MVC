<?php 
namespace app;

use Model;

class Role extends Model{


	protected $tablename = 'roles';

	protected $primary_key = 'id';

	protected $fields = [
		'id', 'name'
	];

	/*	
		$user->select()

		select * from users JOIN roles ON roles.id=users.role_id where user=id
		
	*/
}