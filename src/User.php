<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 5/8/2014
 * Time: 12:54 πμ

 */
namespace eHIF;

class User extends Entity  {

    public function gettasks(){
        return $this->_wrapper->getTasks($this);
    }


    

}