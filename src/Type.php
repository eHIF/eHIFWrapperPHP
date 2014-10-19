<?php
/**
 * Created by PhpStorm.
 * User: larjo_000
 * Date: 11/8/2014
 * Time: 1:03 πμ
 */
namespace eHIF;
class Type {

    private $state;

    public function __construct($object){
        $this->state = $object;
    }

    public function __get($name){
        if (method_exists($this, 'get'.$name)) {
            $method = 'get' . $name;
            return $this->$method();
        }
        else
            if(isset($this->state->$name)) return  $this->state->$name;
            else
                if(isset($this->state[$name])) return $this->state[$name];
        else return null;
    }

    public function __set($name, $value){
        $this->state->$name = $value;
    }

} 