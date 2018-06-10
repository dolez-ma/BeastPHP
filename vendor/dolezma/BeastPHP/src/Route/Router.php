<?php
/**
 * Created by PhpStorm.
 * User: Boudha
 * Date: 10/06/2018
 * Time: 03:52
 */

namespace BeastPHP\Route;


use BeastPHP\Http\Request;
use BeastPHP\Http\Url;

class Router
{
    /** @var Request $request */
    protected $request;

    /** @var Url $url */
    protected $url;

    /** @var Route[] */
    protected $routes = [];

    public function __construct(Request $request, Url $url){
        $this->request = $request;
        $this->url = $url;
    }

    /**
     * Add route to the routes collection
     *
     * @param $name
     * @param array $routeArray
     * @return $this
     */
    public function addRoute($name, array $routeArray){
        $route = new Route($this->request, $routeArray);
        $this->routes[$name] = $route;
        return $this;
    }

    /**
     * Try to match the actual Url
     *
     * @return mixed
     */
    public function matchActualRoute(){
        return $this->matchRoute($this->url->getActualUrl());
    }

    /**
     * Try to find a match in all available routes
     *
     * @param $url
     * @return null
     */
    public function matchRoute($url){
        $url = '/' .ltrim($url, '/');
        if($route = $this->matchRouteDirectly($url)){
            return $route;
        }
        if($route = $this->matchRouteWithParams($url)){
            return $route;
        }
        return null;
    }

    private function matchRouteDirectly($url){
        foreach ($this->routes as $route){
            if($route->matchDirectly($url)){
                return $route;
            }
        }
        return null;
    }

    private function matchRouteWithParams($url){
        foreach ($this->routes as $route){
            if($route->matchWithParams($url)){
                return $route;
            }
        }
        return null;
    }


}