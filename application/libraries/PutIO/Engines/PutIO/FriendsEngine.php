<?php

/**
 * Copyright (C) 2012  Nicolas Oelgart
 *
 * @author Nicolas Oelgart
 * @license GPL 3 http://www.gnu.org/copyleft/gpl.html
 *
 * This class manages anything related to 'Friends'.
 * For precise return values see put.io's documentation here:
 *
 * https://api.put.io/v2/docs/#friends
 *
**/

namespace PutIO\Engines\PutIO;

use PutIO\Helpers\PutIO\PutIOHelper;

class FriendsEngine extends PutIOHelper
{
    
    /**
     * Returns an array of all friends.
     *
     * @return array 
     *
    **/
    public function listall()
    {
        return $this->get('friends/list', array(), false, 'friends');
    }
    
    
    /**
     * Returns an array of pending requests.
     *
     * @return array
     *
    **/
    public function pendingRequests()
    {
        return $this->get('friends/waiting-requests', array(), false, 'friends');
    }
    
    
    /**
     * Sends out a friend request to a specific user.
     *
     * @param string $username User to receive friend request
     * @return boolean
     *
    **/
    public function sendRequest($username)
    {
        return $this->post('friends/' . $username . '/request', array(), true);
    }
    
    
    /**
     * Denies a specific friend request.
     *
     * @param string $username User to have their request denied
     * @return boolean
     *
    **/
    public function denyRequest($username)
    {
        return $this->post('friends/' . $username . '/deny', array(), true);
    }
}

?>