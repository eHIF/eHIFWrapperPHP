<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 7/8/2014
 * Time: 1:13 πμ

 */


use Curl\Curl;
class Activiti {
protected  $baseURL;
    const GET = "get";
    const POST = "post";
    protected $curl;



    public function  __construct($baseURL, $username, $password){
        $this->baseURL = $baseURL;
        $this->curl = new Curl();
        $this->curl->setBasicAuthentication($username,$password);
    }


    function request($url, $method, array $data = array()){

        switch ($method){
            case self::GET:

                return $this->curl->get($this->baseURL . $url,$data);

        }

    }

} 