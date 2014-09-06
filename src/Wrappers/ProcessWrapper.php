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


class ProcessWrapper extends Wrapper{

    public function get($id=null){
        if(!empty($id)){
            $j_process =  $this->_activiti->request("process-definitions/".$id, Activiti::GET);
            $process = new Process($j_process, $this);
            return $process;
        }
        else{
            $j_processes =  $this->_activiti->request("process-definitions", Activiti::GET);
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

} 