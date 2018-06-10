<?php

class Routes {

    public function get() {
        return [
            'index' => [
                'methods' => 'GET',
                'url' => '/',
                'controller' => '',
                'action' => 'index',
            ],
        ];
    }

}