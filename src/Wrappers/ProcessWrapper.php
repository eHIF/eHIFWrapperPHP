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
use eHIF\ProcessModel;


class ProcessWrapper extends Wrapper{

    public function get($id=null, $size=10000){
        if(!empty($id)){
            $j_process =  $this->_activiti->get("repository/process-definitions/".$id, array(), true);
            $process = new Process($j_process, $this);
            return $process;
        }
        else{
            $j_processes =  $this->_activiti->get("repository/process-definitions", array("startableByUser"=>$this->_activiti->username, "size"=>100), false);
            $processes = array();

            foreach($j_processes->data as $j_process){
                $processes[] = new Process($j_process, $this);
            }

            return $processes;

        }
    }

    public function getDeployment($process){
        $deploymentWrapper = new DeploymentWrapper($this->_activiti);
        return $deploymentWrapper->get($process->deploymentId);
    }

    public function getProcessInstances($process){
        $processInstanceWrapper = new ProcessInstanceWrapper($this->_activiti);
        return $processInstanceWrapper->getWhereProcess($process->id);
    }

    public function getModel($process){

        $j_model =  $this->_activiti->request("repository/process-definitions/".$process->id."/model", Activiti::GET);

        $model = new ProcessModel($j_model);

        return $model;

    }



    public function startInstance($process, array $variables = array()){


        $vars = array();

        foreach ($variables as $name=>$value) {
            $vars[] = array("name"=>$name, "value"=>$value);

        }


        $result = $this->_activiti->request("runtime/process-instances", Activiti::POST, array(
            "processDefinitionId"=>$process->id,
            "returnVariables"=>"true",
            "variables" => $vars,
        ));



        $processInstance = new ProcessInstance($result);

        return $processInstance;
    }



} 