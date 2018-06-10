<?php

namespace BeastPHP\Framework;


use BeastPHP\DependencyInjection\Container;
use BeastPHP\Events\EventManager;
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

    /** @var EventManager $eventManager */
    protected $eventManager;

    /** @var Router $router */
    protected $router;

    /** @var Url $url */
    protected $url;

    public function __construct(
        Path          $path,
        Configuration $configuration,
        EventManager  $eventManager,
        Router        $router,
        Url           $url
    ){
        $this->path          = $path;
        $this->configuration = $configuration;
        $this->eventManager  = $eventManager;
        $this->router        = $router;
        $this->url           = $url;
    }

    /**
     * @return EventManager
     */
    public function getEventManager(){ return $this->eventManager; }

    /**
     * @param EventManager $eventManager
     */
    public function setEventManager($eventManager){ $this->eventManager = $eventManager; }

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

        // Get the actual url
        $actualUrl = $this->url->getActualUrl();

        // Load the database configuration
        if($this->configuration->get('database.type')){
            $this->database->setConfiguration($this->configuration->get('database'));
        }

        // Load initial params defined in the configuration files
        if($this->configuration->get('initLocations')){
            $this->loadInitialParams();
        }

        // Match the routes if possible
        $this->eventManager->trigger('beast_route_match_before', $actualUrl);
        $route = $this->router->matchActualRoute();
        $this->eventManager->trigger('beast_route_match_after', $route);
        if($route){
            $this->eventManager->trigger('beast_http_ok', $route);
            // $this->dispatcher->dispatch($route);
        } else {
            // $this->response->setHttpCode(404);
            $this->eventManager->trigger('beast_http_not_found', $actualUrl);
        }

        $this->eventManager->trigger('beast_response_send');
        // $this->response->send();
        return $this;
    }

    protected function loadRoutes(){
        foreach (Container::get(Routes::class)->get() as $name => $route){
            $this->router->addRoute($name, $route);
        }
        return $this;
    }

    protected function loadInitialParams(){
        $locations = $this->configuration->get('initLocations');

        if(!is_array($locations)){
            return;
        }


        foreach ($locations as $location) {
            $folder = $this->path->getPath($location);

            if(!file_exists($folder)){
                continue;
            }

            $folderIterator = new \RecursiveDirectoryIterator($folder, \RecursiveDirectoryIterator::SKIP_DOTS);
            $iteratorIterator = new \RecursiveIteratorIterator($folderIterator);

            foreach ($iteratorIterator as $file){
                if($file->getExtension() !== 'php'){
                    continue;
                }

                $className = '\\init\\' . str_replace('.' . $file->getExension(), '', $file->getFilename());
                Container::create($className);
            }
        }


    }
}