<?php 

namespace vendor;

use ReflectionClass;

class RefClass extends ReflectionClass {

    private $object = null ;

    function __construct(String $class){
      try {
        parent::__construct($class);
        $this->object = new $class;
      } catch (Exception $e) {
        die($e->getMessage());
      }
    } 

    function __invoke(...$argv){

      return $this->object->__invoke(...$argv);
    }

    function method(String $name,Array $args){

      return  $this->object->{$name}(...$args);
    }

    function args(String $method){
      $args = [];
      foreach($this->getMethod($method)->getParameters() as $paras){
        if ($paras->getClass()){
            $args[] = $this->require($paras->getClass()->name);
        }
      }

      return $args;
    }

    function argObject(String $method,String $arg){
        $arg = new \ReflectionParameter([$this->name,$method],$arg);
        if ($arg->hasType() && $arg->getClass()){
          $class = $this->require($arg->getClass()->name);
          return $class;
        }
        return false;
    }

    function check_method(String $name){
      return method_exists($this->object, $name);
    }

    function require(String $cls){

        return new $cls;
    }
}
