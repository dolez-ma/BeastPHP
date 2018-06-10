<?php
/**
 * Created by PhpStorm.
 * User: Boudha
 * Date: 09/06/2018
 * Time: 23:16
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