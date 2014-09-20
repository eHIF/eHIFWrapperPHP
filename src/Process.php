<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 5/8/2014
 * Time: 12:54 πμ

 */
namespace eHIF;

class Process extends Entity  {
    public function getdeployment(){
        return $this->_wrapper->getDeployment($this);

    }

    public function getprocessinstances(){
        return $this->_wrapper->getProcessInstances($this);
    }

    public function getprocessModel(){
        return $this->_wrapper->getModel($this);
    }



}