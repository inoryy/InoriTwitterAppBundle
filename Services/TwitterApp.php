<?php

namespace Inori\TwitterAppBundle\Services;

use \TwitterOAuth;

/**
 * Very simple proxy class to TwitterOAuth functionality
 */
class TwitterApp {

    private $twitter;

    /**
     * @param \TwitterOAuth $twitter TwitterOAuth API client instance
     */
    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Get oAuth client
     *
     * @return \TwitterOAuth
     */
    public function getApi()
    {
        return $this->twitter;
    }

    /**
     * Update status of a user (or tweet for short)
     *
     * @param string $status Message to tweet (max 140 characters)
     *
     * @return string JSON encoded array
     */
    public function tweet($status)
    {
        return $this->twitter->post('statuses/update', array('status' => $status));
    }

    /**
     * Follow a certain user
     *
     * @param string $user Username to follow
     *
     * @return string JSON encoded array
     */
    public function follow($user)
    {
        return $this->twitter->post('friendships/create', array('screen_name' => $user));
    }

    /**
     * Send DM to a given user
     *
     * @param string $text Message to send (max 140 characters)
     * @param string $user Username to send DM to
     *
     * @return string JSON encoded array
     */
    public function sendDirectMessage($text, $user)
    {
        return $this->twitter->post('direct_messages/new', array('text' => $text, 'screen_name' => $user));
    }

    /**
     * Fetch Direct Messages sent to app user
     *
     * @param string $since ID of DM after which to get updates
     *
     * @return string JSON encoded array
     */
    public function getDirectMessages($since = false)
    {
        return $this->twitter->get('direct_messages', array('since_id' => $since));
    }
}