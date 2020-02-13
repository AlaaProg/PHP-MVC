<?php 
namespace Database; 

use Database\ObjectAccess;


class Row extends ObjectAccess {

    protected $_parent;
    protected $_change = array();
    protected $fields  = array();

    function __construct($parent){
        
        $this->_parent = $parent; 
    }

    function __debugInfo()
        {return $this->fields; }

    function __get($key)
        { return $this->fields[$key]  ?? null;}


    function __set($key, $value){
        if(!is_null($this->{$key})){
            $this->_change[$key] = $value;
        }else{
            $this->fields[$key] = $value; 
        }
    }


    function __toString()
        {return json_encode([ get_class($this->_parent) => $this->fields]);}

    function update($date){

        if($this->_parent->update($date)){
            foreach ($date as $key => $value) {
                $this->fields[$key] = $value;
            }
        }     
    }

    function delete()
        {$this->_parent->delete();}

    function save()
        {$this->update($this->_change);}

    function with($model){


        return $this->_parent->{$model}()[0];
    }
}
