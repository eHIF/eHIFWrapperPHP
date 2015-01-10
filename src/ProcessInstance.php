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

    public function gettasks(){
        return $this->_wrapper->getTasks($this);
    }

    public function getSubprocessInstances(){
        return $this->_wrapper->getSubprocessInstances($this);
    }


    public function getvariables(){
        return $this->_wrapper->getVariables($this);
    }

    public function getvariable($variableName){
        return $this->_wrapper->getVariable($this, $variableName);
    }

    public function setVariables(array $variables){
        return $this->_wrapper->setVariables($this, $variables);

    }

    public function setVariable($variableName, $variableValue){
        return $this->_wrapper->setVariable($this, $variableName, $variableValue);

    }



}