<?php
/**
 * @package Beast
 * @licence MIT
 * @author dolezma
 */

namespace BeastPHP\Http;


class Url
{

    /** @var  string */
    protected $baseurl;

    /**
     * Makes the correct baseUrl
     * @return $this
     */
    public function makeBaseUrl(){
        $url = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $this->baseurl = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getBaseurl(){
        if(!$this->baseurl) $this->makeBaseUrl();
        return $this->baseurl;
    }

    /**
     *
     */
    public function getActualUrl(){
        return isset($_GET['url']) ? $_GET['url'] : '/';
    }






}