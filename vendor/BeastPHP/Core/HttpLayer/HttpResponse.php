<?php

namespace BeastPHP\Core\HttpLayer;

use BeastPHP\Core\AppComponent;
use BeastPHP\Core\Interfaces\HttpResponseInterface;
use BeastPHP\Core\Page;

/**
 * Class HttpResponse Represents the response that will be send to the client
 *
 * This class is linked to a page. When the response is send, the Page will be
 * generated. This class also redirects the user on the page asked or on the 404
 * page. It it wasn't found. It can also set a cookie and add some specific headers
 *
 * @package BeastPHP\Core\HttpLayer
 * @author  MDOLEZ
 */
class HttpResponse extends AppComponent implements HttpResponseInterface
{
    /**
     * @var Page $page the page assigned to the response.
     */
    protected $page;

    /**
     * Adds a new specific header to the response
     *
     * @param string $header The header to add.
     */
    public function addHeader(string $header)
    {
        $header($header);
    }

    /**
     * Redirects the user to a new location
     *
     * @param string $location The new location.
     */
    public function redirect(string $location)
    {
        header('Location: '.$location);
        exit(0);
    }

    /**
     * Redirects to a 404 error page
     */
    public function redirectPageNotFound()
    {

    }

    /**
     * Sends the response while rendering the page
     */
    public function send()
    {
        exit($this->page->renderPage());
    }

    /**
     * Assign a page to the response
     *
     * @param Page $page
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Adds a cookie
     *
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool $secure
     * @param bool $httpOnly
     */
    public function setCookie(
        string $name,
        string $value = '',
        int $expire = 0,
        string $path = null,
        string $domain = null,
        bool $secure = false,
        bool $httpOnly = true
    )
    {
        setCookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }


}