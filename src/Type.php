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
        return $this->state->$name;
    }

    public function __set($name, $value){
        $this->state->$name = $value;
    }

} 