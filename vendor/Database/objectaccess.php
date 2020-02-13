<?php
namespace Database;

use Iterator;
use ArrayAccess;

class ObjectAccess implements ArrayAccess, Iterator{

    public function offsetExists($key){
        return isset($this->fields[$key]);
    }
    public function offsetGet($key){
        return $this->fields[$key];
    }

    public function offsetSet($key, $value){
        $this->fields[$key] = $value;
    }
    public function offsetUnset($key){
        unset($this->fields[$key]);
    }

    public function rewind(){
        reset($this->fields);
    }

    public function current(){
        return current($this->fields);
    }

    public function key(){
        return key($this->fields);
    }

    public function next(){
        return next($this->fields);
    }

    public function valid(){
        $key = key($this->fields);
        return  ($key !== NULL && $key !== FALSE);
    }
    
}