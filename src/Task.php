<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 5/8/2014
 * Time: 12:54 πμ

 */
namespace eHIF;

class Task extends Entity  {

public function getform(){
    return $this->_wrapper->getForm($this);
    }

    public function assign($user){
        $this->_wrapper->assignUser($this,$user);
    }

    public function complete(array $formData = array()){
        $this->_wrapper->completeTask($this, $formData);
    }

    public function getprocessInstance(){
        return $this->_wrapper->processInstance($this);
    }

    public function getprocess(){
        return $this->_wrapper->processDefinition($this);
    }

    public function gethistory(){
        return $this->_wrapper->getHistory($this);
    }

    public function getnextTasks(){
        return $this->_wrapper->nextTasks($this);
    }
}