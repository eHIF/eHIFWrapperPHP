<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 7/8/2014
 * Time: 2:12 πμ

 */

require 'vendor/autoload.php';

use eHIF\Activiti;
use eHIF\Process;


$activiti = new Activiti("http://ws307.math.auth.gr:8080/activiti-rest/service/", "kermit", "kermit");
$response = $activiti->request("deployments", Activiti::GET);
$body = json_decode($response->getBody());


$var = new Process($body->data[0]);

var_dump($var->name);
