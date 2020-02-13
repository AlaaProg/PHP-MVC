<?php 
namespace Database\Drives;

use PDO;

class MySQL extends PDO{

     function __construct(){

        $this->db = new PDO("mysql:".CONFIG['database']['mysql']['host'].";dbname=".CONFIG['database']['mysql']['db_name'],
					CONFIG['database']['mysql']['username'],
					CONFIG['database']['mysql']['password'],
					CONFIG['database']['mysql']['options']
				);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     }

    function get_column_table($name){
        return $this->query("SHOW TABLE {$name}")
                    ->fetchAll(PDO::FETCH_COLUMN, 1);
    }

}