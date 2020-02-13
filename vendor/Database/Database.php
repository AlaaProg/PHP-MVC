<?php 
namespace Database; 

use PDO;
use Database\Row;
use Database\Driver;
use Database\BuildQuery;

class Database  extends BuildQuery {

    public $tablename;
    protected $primary_key = 'id';

    protected $_dbpdo; 
    protected $_where;
    protected $_query;
    protected $_orderby;
    protected $_limit;
    protected $_join;

    protected $_fields     = array();
    protected $_select     = array();

    function __construct(){
        if (!$this->tablename){

            $this->tablename = $this->get_class_name();
        }

        $this->_dbpdo = Driver::get_driver();
        $this->_dbpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // WARNING EXCEPTION
        $this->_dbpdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    function __get($key){

        return $this->{$key} ?? null;
    }

    function __debugInfo(){
        return [
            "tablename:protected" => $this->tablename,
            "fields" => $this->get_columns()
        ];;
    }

    function __toString(){

        return "{$this->tablename}";
    }

    public function select(...$args){

        foreach ($args as  $fileds) {
            if (is_array($fileds)){
                $this->_select[] = array_keys($fileds)[0]." as ".array_values($fileds)[0];
            }else{
               $this->_select[] = $fileds; 
            }
        }

        return $this;
    }

    public function join(String $table, $ref, $pky='id'){

        $this->_join = sprintf("JOIN %s ON %s=%s",
                        $table, "{$this->tablename}.{$ref}","{$table}.{$pky}");

        return $this;
    }

    public function whereRaw(String $raw, Array $field){
        $this->_where[]= $raw;

        $this->_fields =array_merge($this->_fields, $field);

        return $this;
    }

    public function where(String $field,String $val1,String $val2=null){

        $filed_ref = str_replace(".", "_", $field);

        if ( !is_null($val2) ){
            $this->_where []= " {$field} {$val1} :{$filed_ref}";
            $this->_fields[":".$filed_ref] = $val2;

        }else{

            $this->_where []= " {$field}=:{$filed_ref}";
            $this->_fields[":".$filed_ref] = $val1;
        }

        return $this;
    }

    public function orderBy($order, $direction='DESC'){

        $this->_orderby = "ORDER BY {$order} {$direction}";

        return $this;
    }


    public function update($data){
        $this->_buildUpdate($data);
        // print_r($this->_fields);
        $state = $this->_query->execute($this->_fields);
        $this->_fields = array();
        return $state;
    }

    public function delete(){
        $this->_buildDelete();

        $state = $this->_query->execute($this->_fields);
        $this->_fields = array();
           
        return $state;
    }
    
    public function get_columns(){

        return $this->_dbpdo->get_column_table($this->tablename);
    }

    public function take($limit, $offset=null){
        
        $this->_limit = 'LIMIT {$limit}';
        if(!is_null($offset)){
            $this->_limit .= ", {$offset}";
        }
        
        return $this;
    }

    public function grep($field,$grep){
        $this->where($field,"LIKE",$grep);
        return $this;
    }

    public function get(){
        $this->_buildSelect();
        $this->_query->execute($this->_fields);

        return $this->_query->fetchall(PDO::FETCH_FUNC, function(...$argv){
            $db  = new $this;
            $row = new Row($db);

            foreach ($db->get_columns() as $index => $name) {
                if( isset($argv[$index]) ){
                    $row->{$name} = $argv[$index];
                }
            }

            $db->where($db->primary_key, $row->{$db->primary_key});
            return $row;
        });
    }

    public static function insert($data){
        $db = new static;
        $db->_buildInsert($data);
        return $db->_query->execute($db->_fields);
        // $db->_fields = array();
    }
    
    public static function first(){

        $db = new static;
        $prepare = $db->_buildSelect();
        $row = new Row($db);

        $db->_query->setFetchMode(PDO::FETCH_INTO, $row);
        $db->_query->execute($db->_fields);

        $row = $db->_query->fetch();

        $db->where("{$db->tablename}.{$db->primary_key}",$row->{$db->primary_key});

        return $row;
    }

    public static function all(){

        $db = new static;
        print_r($db->_where);
        $db->_buildSelect();

        $db->_query->execute($db->_fields);

        return $db->_query->fetchall(PDO::FETCH_FUNC, function(...$argv){
            $db  = new static;
            $row = new Row($db);

            foreach ($db->get_columns() as $index => $name) {
                $row->{$name} = $argv[$index];
            }

            $db->where($db->primary_key, $row->{$db->primary_key});
            return $row;
        });
    }

    public static function find($key){


        $db = new static;

        $db->where("{$db->tablename}.{$db->primary_key}",$key);
        $db->_buildSelect();

        $row = new Row($db);

        $db->_query->setFetchMode(PDO::FETCH_INTO, $row);
        $db->_query->execute($db->_fields);
            
        return $db->_query->fetch();
    }

}