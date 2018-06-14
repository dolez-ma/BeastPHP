<?php


namespace BeastPHP\Core;
use BeastPHP\Core\HttpLayer\HttpRequest;
use BeastPHP\Core\HttpLayer\HttpResponse;


/**
 * Represents an Application.
 *
 * It's purpose is to run itself.
 * It has 4 attributes : the name, the request of the client,
 * the response that will be sent, and the session.
 * Every application class need to inherit from this one.
 *
 * @package BeastPHP\Core
 * @author MDOLEZ
 */
abstract class App
{
    /**
     * @var string $name The application name
     */
    protected $name;

    /**
     * @var HttpRequest $request The client's request
     */
    protected $request;

    /**
     * @var HttpResponse $response The response to send to the client
     */
    protected $response;

    public function __construct()
    {
        $this->request = new HttpRequest($this);
        $this->response = new HttpRequest($this);
        $this->name = '';
    }

    abstract public function run();

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function name(){
        return $this->name;
    }

}