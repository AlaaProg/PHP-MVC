<?php 
namespace Database;

use ReflectionClass;

class BuildQuery {


    protected function get_class_name(){

        $ref = new ReflectionClass($this);
        $name = explode("\\", $ref->name);
        return strtolower(array_pop($name));
    }

    protected function _buildSelect(){
        $fileds = [" * "];

        if (!empty($this->hide_fields)){
            $fileds = array_filter($this->fields, 
                function($var){
                    return !in_array($var, $this->hide_fields);
                }
            ); 
        }

        $fileds = join(", ", $fileds);


        if (!empty($this->_select)){

            $fileds = join(', ',$this->_select);
        }


        $_where = "";
        if ($this->_where){
            
            $_where = "WHERE ".join(" AND ",$this->_where);
        }

        $stmt = sprintf("SELECT %s FROM %s %s %s %s %s %s", 
                $fileds, $this->tablename, $this->_join, $_where, $this->_orderby, $this->_limit, $this->_like);
        // print_r($this->_dbpdo);
        // die($stmt);
        $this->_query = $this->_dbpdo->prepare($stmt);

        return $this->_query;
    }

    protected function _buildInsert(Array $data){

        $values = array();
        $fileds = array();
        foreach ($data as $key => $value) {
                if (is_string($key)){
                    if (in_array($key, $this->get_columns() )){
                        $values[] = ":$key";
                        $fileds[] = "`$key`";
                        $this->_fields[":".$key] = $value;
                    }
                }else{
                    $values[] = ":{$this->fields[$key]}";
                    $fileds[] = "`{$this->fields[$key]}`";
                    $this->_fields[":".$this->fields[$key]] = $value;
                }
        }

        $query = sprintf("INSERT INTO '%s' (%s) VALUES (%s)", $this->tablename,join(", ",$fileds), join(", ",$values) );
        $this->_query = $this->_dbpdo->prepare($query);

        return $this->_query;
    }

    protected function _buildUpdate($data){
    
        $fileds = [];
        foreach ($data as $key => $value) {
            if (is_string($key)){
                $fileds[] = "`$key`=:$key";
                $this->_fields[":".$key] = $value;
            }
        }

        $fileds = join(", ",$fileds);

        $_where = "";
        if ($this->_where){
           $_where = "WHERE ".join(" AND ",$this->_where);
        }

        $query = sprintf("UPDATE %s SET  %s %s ", $this->tablename, $fileds, $_where);
        // die($query);
        $this->_query = $this->_dbpdo->prepare($query);
        $_where = "";
        return $this->_query;
    }

    protected function _buildDelete(){

        $_where = "";
        if ($this->_where){
            $_where = "WHERE ".join(" AND ",$this->_where);
        }

        $query = sprintf('DELETE FROM %s %s', $this->tablename, $_where);

        // die($query);
        $this->_query = $this->_dbpdo->prepare($query);


        return $this->_query;
    }
}