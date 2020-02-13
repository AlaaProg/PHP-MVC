<?php 


return [
	'app'  => [
		'path_base' => "/blog_site/",
		'url' => "http://localhost/blog_site/"

	],

	"database" => [
			"drive" => 'sqlite',

			"mysql" => [
				"host" => '127.0.0.1',
				"username" => 'root' ,
				"password" => "",
				"dbname"  => 'test',
				"options"  => [
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", 
				]
			],

			"sqlite" => [
				'dbname' => "database.sqlite"
			]

	],


];