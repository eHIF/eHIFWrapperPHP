<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 7/8/2014
 * Time: 2:12 πμ

 */

require 'vendor/autoload.php';

use eHIF\Activiti;



$activiti = new Activiti("http://localhost:8080/activiti-rest/service/", "kermit", "kermit");
$processes = $activiti->processes->get();
$users = $activiti->users->get();
$tasks = $activiti->tasks->get();

//var_dump($processes);

//var_dump($processes[0]->deployment->name);
//var_dump($processes[0]->processinstances[0]->startUserId);
//var_dump($tasks);
//var_dump( $activiti->users->get('kermit'));
//var_dump( $activiti->users->get('kermit')->tasks);
//var_dump($activiti->tasks->get(5477)->form);
$data = array(
    "patient_name"=>"Asklipios",
    "patient_surname"=>"Iatropoulos",
    "patient_id"=>"1362",
);

$response = $activiti->tasks->get(17530)->complete($data);
var_dump($response);