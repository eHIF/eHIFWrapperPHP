<?php
/**
 * Created by PhpStorm.
 * User: larjohns
 * Date: 7/8/2014
 * Time: 1:13 πμ

 */

namespace eHIF;
use eHIF\Wrappers\ProcessInstanceWrapper;
use eHIF\Wrappers\UserWrapper;
use GuzzleHttp\Client;
use eHIF\Wrappers\ProcessWrapper;
use eHIF\Wrappers\TaskWrapper;

use Illuminate\Cache\CacheManager;
use Illuminate\Filesystem\Filesystem;

class Activiti {
protected  $baseURL;
    const GET = "get";
    const POST = "post";
    const PUT = "put";
    const DELETE = "delete";
    protected $client;

    public  static $last;


    public $username;
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
        $this->processInstances = new ProcessInstanceWrapper($this);
        $this->users = new UserWrapper($this);
        $this->tasks = new TaskWrapper($this);


        self::$last = $this;
    }

    private static  $cache;
    private static  function getCache(){
        if(!isset(self::$cache)){

            $app = array(
                'files' => new Filesystem,
                'config' => array(
                    'cache.driver' => 'file',
                    'cache.path' => sys_get_temp_dir(),
                    'cache.prefix' => 'eHIF'
                )
            );

            $cacheManager = new CacheManager($app);
            self::$cache = $cacheManager->driver();

            return self::$cache;
        }
        else return  self::$cache;
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

    function del($url, array $data = array()){
        return $this->request($url,Activiti::DELETE, $data);
    }

    function get($url, array $data = array(), $fromCache = false){


        if($fromCache){
            $cache = self::getCache();
            if($cache->has("$url")) {


                return $cache->get($url);

            }
            else{
                $stuff =  $this->request($url,Activiti::GET, $data);
                $cache->add($url, $stuff,600);
                return $stuff;
            }
        }
        else{

            return $this->request($url,Activiti::GET, $data);
        }






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
            case self::DELETE:
                $response = $this->client->delete($this->baseURL . $action,array(
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