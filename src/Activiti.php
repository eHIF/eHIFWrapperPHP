<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 7/8/2014
 * Time: 1:13 πμ

 */

namespace eHIF;
use GuzzleHttp\Client;
class Activiti {
protected  $baseURL;
    const GET = "get";
    const POST = "post";
    protected $client;


    protected $username;
    protected $password;

    public function  __construct($baseURL, $username, $password){
        $this->baseURL = $baseURL;
        $this->client = new Client();
        $this->username = $username;
        $this->password = $password;
    }


    function request($url, $method, array $data = array()){

        switch ($method){
            case self::GET:

                return $this->client->get($this->baseURL . $url, array('query'=> $data,
                    'auth' => array($this->username, $this->password)));
            default:
                return null;


        }

    }

} 