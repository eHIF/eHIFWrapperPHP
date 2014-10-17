<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 7/8/2014
 * Time: 1:13 πμ

 */

namespace eHIF;
use eHIF\Wrappers\UserWrapper;
use GuzzleHttp\Client;
use eHIF\Wrappers\ProcessWrapper;
use eHIF\Wrappers\TaskWrapper;
use GuzzleHttp\Subscriber\Log\LogSubscriber;
use GuzzleHttp\Subscriber\Log\Formatter ;
class Activiti {
protected  $baseURL;
    const GET = "get";
    const POST = "post";
    const PUT = "put";
    protected $client;

    public  static $last;


    protected $username;
    protected $password;

    public $processes;
    public $users;
    public $tasks;

    public function  __construct($baseURL, $username, $password){
        $this->baseURL = $baseURL;
        $this->client = new Client();
       // $this->client->getEmitter()->attach(new LogSubscriber(null,Formatter::DEBUG));

        $this->username = $username;
        $this->password = $password;

        $this->processes = new ProcessWrapper($this);
        $this->users = new UserWrapper($this);
        $this->tasks = new TaskWrapper($this);


        self::$last = $this;
    }


    /**
     * Alias for PUT request
     * @param $url
     * @param array $data
     * @return mixed|null
     */
    function put($url, array $data = array()){
        return $this->request($url,Activiti::PUT, $data);
    }

    function post($url, array $data = array()){
        return $this->request($url,Activiti::POST, $data);
    }

    function get($url, array $data = array()){
        return $this->request($url,Activiti::GET, $data);
    }


    function request($action, $method, array $data = array()){

        switch ($method){
            case self::GET:
                $response = $this->client->get($this->baseURL . $action,
                    array(
                        'query'=> $data,
                        'auth' => array($this->username, $this->password)
                    ));
                $body = json_decode($response->getBody());

                return $body;

            case self::PUT:
                $response = $this->client->put($this->baseURL . $action,array(
                    "json"=>($data),
                    'auth' => array($this->username, $this->password)
                ));
                $body = json_decode($response->getBody());
                return $body;

            case self::POST:
                $response = $this->client->post($this->baseURL . $action,array(
                    "json"=>($data),
                    'auth' => array($this->username, $this->password)
                ));
                $body = json_decode($response->getBody());
                return $body;
            default:
                return null;


        }

    }

} 