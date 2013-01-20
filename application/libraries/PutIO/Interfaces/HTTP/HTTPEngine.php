<?php

/**
 * Copyright (C) 2012  Nicolas Oelgart
 * 
 * @author Nicolas Oelgart
 * @license GPL 3 http://www.gnu.org/copyleft/gpl.html
 *
 * All HTTP engines must implement this interface.
 *
**/

namespace PutIO\Interfaces\HTTP;


interface HTTPEngine
{
    /**
     * Makes an HTTP request to put.io's API and returns the response.
     *
     * @param string $method       HTTP request method. Only POST and GET are supported.
     * @param string $url          Remote path to API module.
     * @param array  $params       OPTIONAL - Variables to be sent.
     * @param string $outFile      OPTIONAL - If $outFile is set, the response will be written to this file instead of StdOut.
     * @param array  $arrayKey     OPTIONAL - Will return all data on a specific array key of the response.
     * @param bool   $verifyPeer   OPTIONAL - If true, will use proper SSL peer/host verification.
     * @return mixed
     *
    **/
    public function request($method, $url, array $params = array(), $outFile = '', $returnBool = false, $arrayKey = '', $verifyPeer = true);
}

?>