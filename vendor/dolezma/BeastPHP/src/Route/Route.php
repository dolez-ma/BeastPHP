<?php
/**
 * @package Beast
 * @licence MIT
 * @author dolezma
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
    protected $values = [];
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

    public function matchDirectly($url){
        if(!$this->isAllowedRequestMethod()){
            return false;
        }

        if($this->url === $url){
            return true;
        }
        return false;
    }

    public function matchWithParams($url){
        if(!$this->parameters || !$this->isAllowedRequestMethod() || !$this->isPartCountSame($url) || !$this->hasParameters()){
            return false;
        }

        $this->extractParamValues($url);
        if(!$this->values){
            return false;
        }

        $fixedUrl = $this->injectParams($url);
        if($this->matchDirectly($fixedUrl)){
            return true;
        }
        return false;
    }

    public function isAllowedRequestMethod(){
        return in_array($this->request->getMethod(), $this->methods);
    }

    public function isPartCountSame($url){
        return count(explode('/', $url)) === count(explode('/', $this->url));
    }

    public function hasParameters(){
        return mb_strpos($this->url, '{') && mb_strpos($this->url, '}');
    }

    public function extractParamValues($url){
        $urlParts = explode('/', $url);
        $this->values = [];
        foreach ($this->parameters as $index => $name){
            $this->values[$name] = $urlParts[$index];
        }
        return $this->values;
    }

    public function injectParams($url){
        $urlParts = explode('/', $url);
        $parameters = array_flip($this->values);
        foreach ($urlParts as &$urlPart){
            if(isset($parameters[$urlPart])){
                $urlPart = '{' . ltrim($parameters[$urlPart], '{}') . '}';
            }
        }
        return implode('/', $urlParts);
    }


}