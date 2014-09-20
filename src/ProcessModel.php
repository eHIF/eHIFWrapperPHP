<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 19/9/2014
 * Time: 12:39 μμ

 */

namespace eHIF;


class ProcessModel extends Entity {
    public function getmodel(){
        return $this->_wrapper->getModel();
    }
} 