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

use eHIF\Task;


class TaskWrapper extends Wrapper
{

    public function get($id = null, $size=10000)
    {
        if (!empty($id)) {
            $j_task = $this->_activiti->get("runtime/tasks/" . $id, array("size"=>$size), true);
            $task = new Task($j_task, $this);
            return $task;
        } else {
            $j_tasks = $this->_activiti->get("runtime/tasks",array("candidateOrAssigned", $this->_activiti->username), true);
            $tasks = array();

            foreach ($j_tasks->data as $j_task) {
                $tasks[] = new Task($j_task, $this);
            }

            return $tasks;

        }
    }


    public function getUserTasks($user_id)
    {
        $j_tasks = $this->_activiti->request("runtime/tasks", Activiti::GET,
            array("candidateOrAssigned" => $user_id,
                "includeProcessVariables"=>"true",
                "includeTaskLocalVariables"=>"true",
            ));

        $tasks = array();

        foreach ($j_tasks->data as $j_task) {
            $tasks[] = new Task($j_task, $this);
        }

        return $tasks;
    }


    public function getForm($task)
    {
        $j_form = $this->_activiti->request("form/form-data?taskId=" . $task->id , Activiti::GET);

        return $j_form;
    }

    public function completeTask($task, $formData)
    {
        $variables = array();
        foreach ($formData as $data=>$val) {
            $variables[] = array("name"=>$data, "value"=>$val);
        }

        $body = array("action"=>"complete", "variables"=>$variables);

        $response = $this->_activiti->post("runtime/tasks/" . $task->id , $body);
        return $response;
    }


    public function getWhereProcessInstance($processInstanceId){
        $j_process_tasks =  $this->_activiti->request("runtime/tasks", Activiti::GET,
            array("processInstanceId"=>$processInstanceId));

        $tasks = array();

        foreach($j_process_tasks->data as $j_process_task){
            $tasks[] = new Task($j_process_task, $this);
        }

        return $tasks;
    }

    public function processInstance(Task $task){
        $processInstanceId = $task->processInstanceId;

        $processInstanceWrapper = new ProcessInstanceWrapper($this->_activiti);

        $processInstance = $processInstanceWrapper->get($processInstanceId);

        return $processInstance;

    }
    public function processDefinition(Task $task){
        $processDefinitionId = $task->processDefinitionId;

        $processDefinitionWrapper = new ProcessWrapper($this->_activiti);

        $process = $processDefinitionWrapper->get($processDefinitionId);

        return $process;

    }


    public function assignUser($task,$user){
        $response = $this->_activiti->put("runtime/tasks/" . $task->id , array(
            "assignee"=>$user->id
        ));

        return $response;
    }



}