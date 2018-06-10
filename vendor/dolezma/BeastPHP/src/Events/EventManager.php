<?php
/**
 * Created by PhpStorm.
 * User: Boudha
 * Date: 11/06/2018
 * Time: 00:01
 */

namespace BeastPHP\Events;


class EventManager
{

    protected $subscribers = [];

    /**
     * Trigger the event specified and run through all subscribers referenced,
     * passing the payload to callables
     *
     * @param string $event
     * @param null $payload
     * @return $this
     */
    public function trigger(string $event, &$payload = null){

        // Forbid global docks triggering
        if($event === '*'){
            return $this;
        }

        // Get all Gobal events
        $globalSubscribers = [];
        if(isset($this->subscribers['*']) && count($this->subscribers['*']) > 0){
            $globalSubscribers = $this->subscribers['*'];
        }

        // Verify if the event exist and has closure to call
        if(!isset($this->subscribers[$event]) || count($this->subscribers[$event]) == 0){
            // The specific events don't exist, are there some global events ?
            if(count($globalSubscribers) === 0){
                // No ? there is nothing to do here
                return $this;
            }
            $subscribers = $globalSubscribers;
        } else {
            $subscribers = $this->subscribers[$event];
            $subscribers = array_merge($subscribers, $globalSubscribers);
        }

        // Events exists, lets call their closure.
        foreach ($subscribers as $closure){
            $closure($event, $payload);
        }

        return $this;

    }

}