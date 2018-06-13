<?php

namespace BeastPHP\Core\HttpLayer;

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
class HttpResponse implements HttpResponseInterface
{
    /**
     * @var Page $page the page assigned to the response.
     */
    protected $page;
}