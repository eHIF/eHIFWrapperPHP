<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 5/8/2014
 * Time: 12:54 πμ

 */
namespace eHIF;

class ProcessInstance extends Entity  {
    public function getdeployment(){
        return $this->_wrapper->getDeployment($this);

    }

}