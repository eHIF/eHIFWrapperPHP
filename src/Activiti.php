<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 7/8/2014
 * Time: 1:13 πμ

 */

namespace eHIF;
use GuzzleHttp\Client;
use eHIF\Wrappers\ProcessWrapper;

class Activiti {
protected  $baseURL;
    const GET = "get";
    const POST = "post";
    protected $client;

    public  static $last;


    protected $username;
    protected $password;

    public $processes;

    public function  __construct($baseURL, $username, $password){
        $this->baseURL = $baseURL;
        $this->client = new Client();
        $this->username = $username;
        $this->password = $password;

        $this->processes = new ProcessWrapper($this);

        self::$last = $this;
    }


    function request($url, $method, array $data = array()){

        switch ($method){
            case self::GET:
                $response = $this->client->get($this->baseURL . $url, array('query'=> $data,
                    'auth' => array($this->username, $this->password)));
                $body = json_decode($response->getBody());

                return $body;
            default:
                return null;


        }

    }

} 