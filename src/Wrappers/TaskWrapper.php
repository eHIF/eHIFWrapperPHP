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
            $j_task = $this->_activiti->get("runtime/tasks/" . $id, array(), true);
            $task = new Task($j_task, $this);
            return $task;
        } else {
            $j_tasks = $this->_activiti->get("runtime/tasks",array("candidateOrAssigned"=> $this->_activiti->username, "size"=>$size), true);
            $tasks = array();

            foreach ($j_tasks->data as $j_task) {
                $tasks[] = new Task($j_task, $this);
            }

            return $tasks;

        }
    }


    public function getUserTasks($user_id, $size=10000)
    {
        $j_tasks = $this->_activiti->request("runtime/tasks", Activiti::GET,
            array("candidateOrAssigned" => $user_id,
                "includeProcessVariables"=>"true",
                "includeTaskLocalVariables"=>"true",
                "size"=>$size,
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
            array("processInstanceId"=>$processInstanceId,
                "candidateOrAssigned" => $this->_activiti->username));

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


    public function nextTasks(Task $task){
        $process = $this->processDefinition($task);
        $processModel = $process->getprocessModel()->processes[0];
        $elements = $processModel->flowElements;

        $tasks = array();

        $id = $task->taskDefinitionKey;

        $i=0;
        do{
            $task = array_values(array_filter ($elements,
                function($elem) use($id){
                    return $elem->id  == $id;
                }
            ))[0];


            $outgoingFlows = $task->outgoingFlows;

            if(count($outgoingFlows)>1 || count($outgoingFlows)<1){
                break;
            }
            else{



                $tasks[]=$task;
                if (strpos($outgoingFlows[0]->targetRef, 'call') !== FALSE)
                    break;
                $id = $outgoingFlows[0]->targetRef;
            }
            $i++;
        }
        while($i<10);
        array_shift($tasks);
        return $tasks;
    }


    public function assignUser($task,$user){
        $response = $this->_activiti->put("runtime/tasks/" . $task->id , array(
            "assignee"=>$user->id
        ));

        return $response;
    }

    public function getHistory($task){
        $processInstanceId = $task->processInstanceId;
        $j_process_tasks =  $this->_activiti->request("history/historic-task-instances", Activiti::GET,
            array("processInstanceId"=>$processInstanceId));

        $tasks = array();

        foreach($j_process_tasks->data as $j_process_task){
            $tasks[] = new Task($j_process_task, $this);
        }

        return $tasks;


    }



}