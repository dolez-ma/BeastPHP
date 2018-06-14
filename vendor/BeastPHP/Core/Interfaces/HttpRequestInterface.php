<?php
/**
 * Created by PhpStorm.
 * User: Boudha
 * Date: 13/06/2018
 * Time: 23:55
 */

namespace BeastPHP\Core\Interfaces;


interface HTTPRequestInterface
{

    public function getCookieValue(string $name);

    public function cookieExists(string $name);

    public function getGet(string $name);

    public function getExists(string $name);

    public function getMethod();

    public function getPost(string $name);

    public function postExists(string $name);

    public function getURI();
}