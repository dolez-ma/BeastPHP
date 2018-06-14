<?php


namespace BeastPHP\Core;


abstract class AppComponent
{
    /**
     * @var App $app
     */
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function getApp()
    {
        return $this->app;
    }


}