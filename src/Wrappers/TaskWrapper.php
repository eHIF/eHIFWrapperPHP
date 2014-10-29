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
use eHIF\ProcessModel;

use eHIF\Task;


class TaskWrapper extends Wrapper
{

    public function get($id = null)
    {
        if (!empty($id)) {
            $j_task = $this->_activiti->request("runtime/tasks/" . $id, Activiti::GET);
            $task = new Task($j_task, $this);
            return $task;
        } else {
            $j_tasks = $this->_activiti->request("runtime/tasks", Activiti::GET);
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
        $response = $this->_activiti->put("task/" . $task->id . "/complete", $formData);
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


    public function assignUser($task,$user){
        $response = $this->_activiti->put("runtime/tasks/" . $task->id , array(
            "assignee"=>$user->id
        ));

        return $response;
    }



}