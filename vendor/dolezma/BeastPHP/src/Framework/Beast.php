<?php
/**
 * Created by PhpStorm.
 * User: Boudha
 * Date: 09/06/2018
 * Time: 18:16
 */

namespace BeastPHP\Framework;


use BeastPHP\DependencyInjection\Container;
use BeastPHP\Files\Path;
use BeastPHP\Http\Url;
use BeastPHP\Route\Router;
use Routes;

class Beast
{
    /** @var Path $path */
    protected $path;

    /** @var Configuration $configuration */
    protected $configuration;

    /** @var   */
    protected $router;

    /** @var Url $url */
    protected $url;

    public function __construct(
        Path $path,
        Configuration $configuration,
        Router $router,
        Url $url

    ){
        $this->path = $path;
        $this->configuration = $configuration;
        $this->router = $router;
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getRouter(){ return $this->router; }

    /**
     * @param mixed $router
     */
    public function setRouter($router){ $this->router = $router; }

    /**
     * @return Url
     */
    public function getUrl(){ return $this->url; }

    /**
     * @param Url $url
     */
    public function setUrl($url){ $this->url = $url; }

    /**
     * @return Configuration
     */
    public function getConfiguration(){ return $this->configuration; }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration($configuration){ $this->configuration = $configuration; }

    /**
     * @return Path
     */
    public function getPath(){ return $this->path; }

    /**
     * @param Path $path
     */
    public function setPath($path){ $this->path = $path; }



    public function wakeUp(){

        // Define the base path for paths
        $this->path->setBasepath(BASEPATH);

        // Load configuration files
        $this->configuration->load();

        // Build the base url
        $this->url->makeBaseUrl();

        // Load all routes
        $this->loadRoutes();

        // TODO [MDO]
    }

    protected function loadRoutes(){
        foreach (Container::get(Routes::class)->get() as $name => $route){
            $this->router->addRoute($name, $route);
        }
        return $this;
    }
}