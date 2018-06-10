<?php
/**
 * Created by PhpStorm.
 * User: Boudha
 * Date: 10/06/2018
 * Time: 03:52
 */

namespace BeastPHP\Route;


use BeastPHP\Http\Request;

class Router
{

    protected $request;
    protected $routes = [];

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function addRoute($name, array $routeArray){
        $route = new Route($this->request, $routeArray);
        $this->routes[$name] = $route;
        return $this;
    }
}