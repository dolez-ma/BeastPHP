<?php
/**
 * @package Beast
 * @licence MIT
 * @author dolezma
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