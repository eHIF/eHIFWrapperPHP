<?php
/**
 * Created by PhpStorm.
 * User: larjo_000
 * Date: 6/9/2014
 * Time: 4:28 μμ
 */

namespace eHIF;


use GuzzleHttp\Stream\GuzzleStreamWrapper;

class Entity extends Type {

    protected  $_wrapper = null;

    public function __construct($object){
        parent::__construct($object);

        $numargs = func_num_args();

        if ($numargs >= 2) {
            $wrapper=  func_get_arg(1);
            $this->_wrapper = $wrapper;
        }
        else{
            $thisClassName =  get_class($this);
            $reflector =  new \ReflectionClass($thisClassName);
            $wrapperClassName = "eHIF\\Wrappers\\".$reflector->getShortName() . "Wrapper";
            $this->_wrapper = new $wrapperClassName(Activiti::$last);
        }

    }
}