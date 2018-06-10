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

    protected $config = [];

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

            if($className === 'Application'){
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
            $this->config = array_merge($this->config, $configClass->getValues());
        }
    }
}