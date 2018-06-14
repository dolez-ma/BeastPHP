<?php

namespace BeastPHP\Core\HttpLayer;

use BeastPHP\Core\AppComponent;
use BeastPHP\Core\Interfaces\HTTPRequestInterface;

/**
 * Class HttpRequest Represents the request from the client
 *
 * This class is used to get POST and GET variables, get the cookies
 * It allows us also to get the methods used when sending the request
 * and the url
 *
 * @package BeastPHP\Core\HttpLayer
 * @author MDOLEZ
 */
class HttpRequest extends AppComponent implements HttpRequestInterface
{
    /**
     * Returns the value of the cookie
     *
     * @param string $name the name of the cookie
     * @return string|null The value of the cookie
     */
    public function getCookieValue(string $name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    /**
     * Checks whether a cookie exists or not.
     *
     * @param string $name The name of the cookie
     * @return bool
     */
    public function cookieExists(string $name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Returns the value of the $_GET
     *
     * @param string $name The name of the GET
     * @return mixed The value of the $_GET superglobal
     */
    public function getGet(string $name)
    {
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }

    /**
     * Checks whether a GET exists or not.
     *
     * @param string $name  The name of the GET
     * @return bool
     */
    public function getExists(string $name)
    {
        return isset($_GET[$name]);
    }

    /**
     * Returns the value of the method used to send the request.
     *
     * @return string The method
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Returns the value of the $_POST.
     *
     * @param string $name The name of the POST
     * @return null|string the value of the $_GET superglobal
     */
    public function getPost(string $name)
    {
        return isset($_POST[$name]) ? $_POST[$name] : null;
    }

    /**
     * Checks whether a POST exists or not.
     *
     * @param string $name  The name of the POST
     * @return bool
     */
    public function postExists(string $name)
    {
        return isset($_POST[$name]);
    }

    /**
     * @return string the URL
     */
    public function getURI()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
