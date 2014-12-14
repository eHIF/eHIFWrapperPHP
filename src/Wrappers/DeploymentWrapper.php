<?php
/**
 * Created by PhpStorm.
 * User: larjo_000
 * Date: 6/9/2014
 * Time: 3:55 μμ
 */

namespace eHIF\Wrappers;
use eHIF\Activiti;
use eHIF\Deployment;
class DeploymentWrapper extends Wrapper {



    public function get($id=null){
        if(!empty($id)){

            $j_deployment =  $this->_activiti->get("repository/deployments/".$id, array(), true);

            $deployment = new Deployment($j_deployment, $this);

            return $deployment;
        }
        else{
            $j_deployments =  $this->_activiti->get("repository/deployments",array(), true);
            $deployments = array();

            foreach($j_deployments->data as $j_deployment){
                $deployments[] = new Deployment($j_deployment, $this);
            }

            return $deployments;

        }
    }



} 