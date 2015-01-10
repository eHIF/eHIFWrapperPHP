<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 7/8/2014
 * Time: 2:12 πμ

 */

require 'vendor/autoload.php';

use eHIF\Activiti;


$activiti = new Activiti("http://ws307.math.auth.gr:8080/activiti-rest/service/", "kermit", "kermit");
/*$processes = $activiti->processes->get();
$users = $activiti->users->get();

$tasks = $activiti->tasks->get();
//var_dump($tasks);


var_dump($activiti->tasks->get(12865));



$instance = $processes[1]->startInstance();
$instance->tasks[0]->assign($users[2]);
$tasks = $users[2]->tasks;
//var_dump($tasks);
$tasks[0]->complete();*/
//var_dump($instance->tasks[0]->name);
//var_dump($processes[1]->processinstances);
//die;
//var_dump($processes[0]->deployment->name);
//var_dump($processes[0]->processinstances[0]->startUserId);
//var_dump($tasks);
//var_dump( $activiti->users->get('kermit'));
//var_dump( $activiti->users->get('kermit')->tasks);
//var_dump($activiti->tasks->get(5477)->form);
/*$data = array(
    "patient_name"=>"Asklipios",
    "patient_surname"=>"Iatropoulos",
    "patient_id"=>"1362",
);

$response = $activiti->tasks->get(17530)->complete($data);*/
//var_dump($response);

$processInstance =  $activiti->processInstances->get('48719');

$processInstance->setVariable("lol","troll");

var_dump($processInstance->getvariable("lol"));