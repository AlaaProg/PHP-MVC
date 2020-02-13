<?php 
namespace Database\Drives;

use PDO;

class SQLite extends PDO{


    function __construct(){

        parent::__construct("sqlite:".CONFIG['database']['sqlite']['dbname']);
        
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    function get_column_table($name){

    	return $this->query("PRAGMA table_info({$name})")
                    ->fetchAll(PDO::FETCH_COLUMN, 1);
    }

}