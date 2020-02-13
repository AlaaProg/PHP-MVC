<?php 

namespace Database; 

class Drive{

	
    public static function get_drive(){
        $drive = "\\Database\\Drives\\".CONFIG['database']['drive'];
        return new $drive;
    }
}