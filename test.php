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
$processes = $activiti->processes->get();

//var_dump($processes);

//var_dump($processes[0]->deployment->name);
var_dump($processes[0]->processinstances[0]->startUserId);
