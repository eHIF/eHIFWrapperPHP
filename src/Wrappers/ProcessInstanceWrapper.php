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

class ProcessInstanceWrapper extends Wrapper{

    public function get($id=null){
        if(!empty($id)){
            $j_process_instance =  $this->_activiti->request("process-instances/".$id, Activiti::GET,
                array("includeProcessVariables"=>"true"));
            $process_instance = new ProcessInstance($j_process_instance, $this);
            return $process_instance;
        }
        else{
            $j_process_instances =  $this->_activiti->request("process-instances", Activiti::GET);
            $process_instances = array();

            foreach($j_process_instances->data as $j_process_instance){
                $process_instances[] = new ProcessInstance($j_process_instance, $this);
            }

            return $process_instances;

        }
    }

    public function getWhereProcess($processId){
        $j_process_instances =  $this->_activiti->request("process-instances", Activiti::GET,
        array("processDefinitionId"=>$processId));

        $process_instances = array();

        foreach($j_process_instances->data as $j_process_instance){
            $process_instances[] = new ProcessInstance($j_process_instance, $this);
        }

        return $process_instances;
    }



    public function getTasks($procesInstance){
        $taskWrapper = new TaskWrapper($this->_activiti);
        return $taskWrapper->getWhereProcessInstance($procesInstance->id);
    }


} 