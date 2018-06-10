<?php
/**
 * Created by PhpStorm.
 * User: Boudha
 * Date: 10/06/2018
 * Time: 03:57
 */

namespace BeastPHP\Route;


use BeastPHP\Http\Request;

class Route
{

    protected $methods;
    protected $url;
    protected $controller;
    protected $action;
    protected $callable;
    protected $template;
    protected $parameters = [];
    protected $request;

    public function __construct(Request $request, array $data){

        $this->request = $request;

        $this->methods    = explode('|', $data['methods']);
        $this->url        = isset($data['url'])        ? $data['url']        : null;
        $this->controller = isset($data['controller']) ? $data['controller'] : null;
        $this->action     = isset($data['action'])     ? $data['action']     : null;
        $this->callable   = isset($data['callable'])   ? $data['callable']   : null;
        $this->template   = isset($data['template'])   ? $data['template']   : null;

        if(!$this->controller && !$this->action && !$this->callable){
            throw new \Exception('Either a controller/action or callable is required');
        }

        $this->parseUrlparameters();

    }

    public function parseUrlParameters(){
        $urlParts = explode('/', $this->url);
        foreach ($urlParts as $index => $part){
            if(mb_substr($part, 0, 1) === '{' && mb_substr($part, -1) === '}'){
                $this->parameters[$index] = mb_substr($part, 1, -1);
            }
        }
        return $this;
    }


}