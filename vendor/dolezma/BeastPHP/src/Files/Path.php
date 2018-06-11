<?php
/**
 * @package Beast
 * @licence MIT
 * @author dolezma
 */

namespace BeastPHP\Files;


class Path
{
    protected $basepath;

    /**
     * @param $basepath
     * @return $this
     */
    public function setBasepath($basepath){
        $this->basepath = rtrim($basepath, SEP);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBasepath(){
        return $this->basepath;
    }

    public function getPath($path){
        return $this->basepath . SEP . ltrim($path, SEP);
    }

}