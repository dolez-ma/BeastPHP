<?php
/**
 * Created by PhpStorm.
 * User: Boudha
 * Date: 09/06/2018
 * Time: 23:26
 */

namespace BeastPHP\Framework;


use BeastPHP\DependencyInjection\Container;
use BeastPHP\Files\Path;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Configuration
{
    protected $path;

    protected $configuration = [];

    public function __construct(Path $path){
        $this->path = $path;
    }

    /**
     * @return Path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param Path $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }



    public function load(){
        $folderIterator = new RecursiveDirectoryIterator($this->path->getPath('app/Configuration'), RecursiveDirectoryIterator::SKIP_DOTS);
        $iteratorIterator = new RecursiveIteratorIterator($folderIterator);

        $configClasses = [];
        foreach ($iteratorIterator as $file){
            $className = 'Configuration\\' . str_replace('.php', '', $file->getFilename());

            if($className === 'Beast'){
                continue;
            }

            $configClass = Container::get($className);
            if($configClass->getSortOrder() === null){
                array_push($configClasses, $configClass);
            } else {
                $configClasses[$configClass->getSortOrder()] = $configClass;
            }
        }

        ksort($configClasses);

        foreach ($configClasses as $configClass){
            $this->configuration = array_merge($this->configuration, $configClass->getValues());
        }
    }

    /**
     * @param string $configParam
     * @return mixed|null
     */
    public function get(string $configParam){
        if(strpos($configParam, '.') !== false){
            return $this->getNested($this->configuration, explode('.', $configParam));
        }
        if(isset($this->configuration[$configParam])){
            return $this->configuration[$configParam];
        }
        return null;
    }

    /**
     * @param $config
     * @param $configParams
     * @return mixed
     */
    public function getNested(&$configuration, $configParams){
        foreach ($configParams as $configParam){
            $configuration = &$configuration[$configParam];
        }
        return $configuration;
    }


}