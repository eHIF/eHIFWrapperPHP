<?php
/**
 * Created by PhpStorm.
 * User: larjo_000
 * Date: 6/9/2014
 * Time: 3:55 μμ
 */

namespace eHIF\Wrappers;
use eHIF\Activiti;
use eHIF\Process;
use eHIF\ProcessInstance;
use GuzzleHttp\Exception\RequestException;

class ProcessInstanceWrapper extends Wrapper{

    public function get($id=null, $size=10000){
        if(!empty($id)){
            $j_process_instance =  $this->_activiti->get("runtime/process-instances/".$id,
                array("includeProcessVariables"=>"true",), true);
            $process_instance = new ProcessInstance($j_process_instance, $this);
            return $process_instance;
        }
        else{
            $j_process_instances =  $this->_activiti->get("runtime/process-instances",array("includeProcessVariables"=>"true",  "size"=>$size),true);
            $process_instances = array();

            foreach($j_process_instances->data as $j_process_instance){
                $process_instances[] = new ProcessInstance($j_process_instance, $this);
            }

            return $process_instances;

        }
    }

    public function getWhereProcess($processId){
        $j_process_instances =  $this->_activiti->request("runtime/process-instances", Activiti::GET,
        array("processDefinitionId"=>$processId));

        $process_instances = array();

        foreach($j_process_instances->data as $j_process_instance){
            $process_instances[] = new ProcessInstance($j_process_instance, $this);
        }

        return $process_instances;
    }



    public function getTasks($processInstance){
        $taskWrapper = new TaskWrapper($this->_activiti);
        return $taskWrapper->getWhereProcessInstance($processInstance->id);
    }


    public function getSubprocessInstances($processInstance){

        $j_process_instances =  $this->_activiti->get("runtime/process-instances",array("superProcessInstanceId"=>$processInstance->id),false);
        $process_instances = array();

        foreach($j_process_instances->data as $j_process_instance){
            $process_instances[] = new ProcessInstance($j_process_instance, $this);
        }

        return $process_instances;
    }

    public function getSuperprocessInstances($processInstance){

        $j_process_instances =  $this->_activiti->get("runtime/process-instances",array("subProcessInstanceId"=>$processInstance->id),false);
        $process_instances = array();

        foreach($j_process_instances->data as $j_process_instance){
            $process_instances[] = new ProcessInstance($j_process_instance, $this);
        }

        return $process_instances;
    }



    public function getVariables($processInstance){

        try{
            $id = $processInstance->id;

            $j_variables =  $this->_activiti->get("runtime/process-instances/".$id. '/variables',
                array(), false);

            $variables = array();
            foreach($j_variables as $j_variable){
                $variables[$j_variable->name] = $j_variable->value;
            }

            return $variables;
        }
        catch(RequestException $ex){
            return null;
        }



    }

    public function getVariable($processInstance, $variableName){

        try{
            $id = $processInstance->id;

            $j_variable =  $this->_activiti->get("runtime/process-instances/".$id. '/variables/'.$variableName ,
                array(), false);

            return $j_variable->value;
        }
        catch(RequestException $ex){
            return null;
        }



    }

    public function setVariables($processInstance, array $variables){

        $id = $processInstance->id;
        $j_variables = array();

        foreach ($variables as $variableName=>$value) {
            $j_variables[] = array(
                "name"=>$variableName,
                "value"=>$value,
                "type"=>gettype($value)
            );
        }

        $response = $this->_activiti->put("runtime/process-instances/".$id."/variables" , $j_variables);

        return $response;


    }

    public function setVariable($processInstance, $variableName, $variableValue){
        $id = $processInstance->id;



        $j_variable = array(
                "name"=>$variableName,
                "value"=>$variableValue,
                "type"=>gettype($variableValue)
        );


        $response = $this->_activiti->put("runtime/process-instances/".$id."/variables/", [$j_variable]);

        return $response;

    }



    public function deleteVariables($processInstance){

        $id = $processInstance->id;


        $response = $this->_activiti->del("runtime/process-instances/".$id."/variables");

        return $response;


    }

    public function deleteVariable($processInstance, $variableName){
        $id = $processInstance->id;

        $response = $this->_activiti->del("runtime/process-instances/".$id."/variables/", $variableName);

        return $response;

    }


    public function deleteProcessInstance($processInstance){
        $id = $processInstance->id;
        $response = $this->_activiti->del("runtime/process-instances/".$id);
        return $response;
    }

    



} 