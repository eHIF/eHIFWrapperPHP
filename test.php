<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 7/8/2014
 * Time: 2:12 πμ

 */
require 'vendor/autoload.php';
require_once("base/Activiti.php");
$activiti = new Activiti("http://ws307.math.auth.gr:8080/activiti-rest/service/", "kermit", "kermit");
$var = $activiti->request("deployments", Activiti::GET);

var_dump($var);