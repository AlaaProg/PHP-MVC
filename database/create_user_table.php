<?php 


use Database\DB;

$db = DB::prepare("CREATE TABLE IF NOT EXISTS users(
  id       integer     primary key AUTOINCREMENT, 
  role_id  integer     not null references  roles(id) , 
  fullname varchar(45) not null, 
  email    varchar(45) not null, 
  password varchar(45) not null 
  
)");
$db->execute();