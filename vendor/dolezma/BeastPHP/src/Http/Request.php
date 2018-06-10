<?php
/**
 * Created by PhpStorm.
 * User: Boudha
 * Date: 10/06/2018
 * Time: 03:56
 */

namespace BeastPHP\Http;


class Request
{
    private $method;
    private $headers = [];

    public function __construct(){
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders() ?: [];
    }

    public function getMethod(){
        return $this->method;
    }
}