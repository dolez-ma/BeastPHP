<?php
/**
 * @package Beast Framework
 * @licence MIT
 * @author dolezma
 */

namespace BeastPHP\Framework;


class Autoloader
{
    private $locations = [];

    public function register(){
        spl_autoload_register([$this, 'load']);
        return $this;
    }

    public function addLocation($location){
        $this->locations[] = $location;
        return $this;
    }

    public function getLocations(){
        return $this->locations;
    }

    private function load($class){
        $path = str_replace('\\', SEP, $class);
        $path = '¤¤change¤¤/' . trim($path, SEP) . '.php';
        $path = str_replace('/', SEP, $path);

        foreach ($this->getLocations() as $subPath){
            $actualPath = str_replace('¤¤change¤¤', $subPath, $path);
            if(file_exists($actualPath)){
                require_once($actualPath);
                return true;
            }
        }
        return false;
    }

}