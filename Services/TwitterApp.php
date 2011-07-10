<?php

namespace Inori\TwitterAppBundle\Services;

use \TwitterOAuth;

class TwitterApp {

    private $twitter;

    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
        $this->twitter->decode_json_to_array = true;
    }
    
    public function getApi()
    {
        return $this->twitter;
    }
    
    public function tweet($status)
    {
        return $this->twitter->post('statuses/update', array('status' => $status));
    }
        
    public function follow($user)
    {
        return $this->twitter->post('friendships/create', array('screen_name' => $user));
    }
    
    public function sendDirectMessage($text, $user)
    {
        return $this->twitter->post('direct_messages/new', array('text' => $text, 'screen_name' => $user));
    }    
    
    public function getDirectMessages($since = false)
    {
        return $this->twitter->get('direct_messages', array('since_id' => $since));
    }
}