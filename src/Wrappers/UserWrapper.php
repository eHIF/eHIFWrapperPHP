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
use eHIF\User;


class UserWrapper extends Wrapper{

    public function get($id=null){
        if(!empty($id)){
            $j_user =  $this->_activiti->request("identity/users/".$id, Activiti::GET);
            $user = new User($j_user, $this);
            return $user;
        }
        else{
            $j_users =  $this->_activiti->request("identity/users", Activiti::GET);
            $users = array();

            foreach($j_users->data as $j_user){
                $users[] = new User($j_user, $this);
            }

            return $users;

        }
    }

    public function  getTasks($user){

        $taskWrapper = new TaskWrapper($this->_activiti);
        return $taskWrapper->getUserTasks($user->id);
    }



} 