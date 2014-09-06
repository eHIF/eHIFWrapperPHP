<?php
/**
 * Created by PhpStorm.
 * User: larjo_000
 * Date: 6/9/2014
 * Time: 4:23 μμ
 */

namespace eHIF\Wrappers;
use eHIF;


class Wrapper {
    protected  $_activiti;

    public function __construct($activiti){
        $this->_activiti= $activiti;
    }
} 