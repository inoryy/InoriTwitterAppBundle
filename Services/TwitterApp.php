<?php

namespace Inori\TwitterAppBundle\Services;

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Very simple proxy class to TwitterOAuth functionality
 */
class TwitterApp {

    const RESPONSE_JSON   = 'json';
    const RESPONSE_ATOM   = 'atom';
    const RESPONSE_OBJECT = 'object';
    const RESPONSE_ARRAY  = 'array';

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
     * @param array or string $parameters 
     *
     *  If string given assumed to be the status body
     *  
     *  If array must be parameters with keys such as:
     *
     *  string 'status' - Message to tweet (max 140 characters).
     *  string 'lat' - The latitude of the location this tweet refers to.
     *  string 'long' - The longitude of the location this tweet refers to.
     *
     *  More details about the parameters can be found here:
     *  https://dev.twitter.com/docs/api/1/post/statuses/update
     *
     * @return string JSON encoded array
     */
    public function tweet($parameters)
    {
        if (is_array($parameters)) {
            return $this->twitter->post('statuses/update', $parameters);
        } else if (is_string($parameters)) {
            return $this->twitter->post('statuses/update', array('status' => $parameters));
        } else {
            throw new \InvalidArgumentException(sprintf('Parameter must be a string or an array ("%s" given).', gettype($parameters)));
        }
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

    /**
     * Change response format
     *
     * @param string $format
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function setResponseFormat($format = self::RESPONSE_JSON)
    {
        if (!in_array($format, $this->getSupportedResponseFormats())) {
            throw new \InvalidArgumentException(sprintf('Unsupported format type (%s)', $format));
        }

        if (self::RESPONSE_ARRAY === $format) {
            $this->twitter->format = 'json';
            $this->twitter->decode_json = true;
            //$this->twitter->decode_json_assoc = true; // uncomment when PR#122 is merged
        } elseif (self::RESPONSE_OBJECT === $format) {
            $this->twitter->format = 'json';
            $this->twitter->decode_json = true;
            //$this->twitter->decode_json_assoc = false; // uncomment when PR#122 is merged
        } elseif (self::RESPONSE_JSON === $format) {
            $this->twitter->format = 'json';
            $this->twitter->decode_json = false;
        } elseif (self::RESPONSE_ATOM === $format) {
            $this->twitter->format = 'atom';
        }
    }

    /**
     * Fetch an array of supported response formats
     *
     * @return array
     */
    public function getSupportedResponseFormats()
    {
        return array(
            self::RESPONSE_JSON,
            self::RESPONSE_ATOM,
            self::RESPONSE_OBJECT,
            // self::RESPONSE_ARRAY // can't use it right now, add this back when PR#122 is merged
        );
    }
}
