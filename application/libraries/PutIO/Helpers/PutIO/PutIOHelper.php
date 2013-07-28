<?php

/**
 * Copyright (C) 2012  Nicolas Oelgart
 * 
 * @author Nicolas Oelgart
 * @license GPL 3 http://www.gnu.org/copyleft/gpl.html
 *
 * This class helps PutIO engines to do common tasks.
 *
**/

namespace PutIO\Helpers\PutIO;

use PutIO\API;
use PutIO\Exceptions\LocalStorageException;
use PutIO\Exceptions\UnsupportedHTTPEngineException;


abstract class PutIOHelper
{
    
    /**
     * Holds the main PutIO class instance.
     *
    **/
    protected $putio = null;
    
    
    /**
     * Holds the instance of the HTTP Engine class
     *
    **/
    protected $HTTPEngine = null;
    
    
    /**
     * The main URL to the API (v2).
     *
    **/
    const API_URL = 'https://api.put.io/v2/';
    
    
    /**
     * Class constructor. Stores an instance of PutIO.
     *
     * @param PutIO $putio    Instance of PutIO
     * @return void
     *
    **/
    public function __construct(API $putio)
    {
        $this->putio = $putio;
    }
    
    
    /**
     * Sends a GET HTTP request.
     *
     * @param string   $path         Path of the API class.
     * @param array    $params       OPTIONAL - GET variables to be sent.
     * @param boolean  $returnBool   OPTIONAL - Will return boolean if true. True if $response['status'] === 'OK'.
     * @param array    $arrayKey     OPTIONAL - Will return all data on a specific array key of the response.
     * @return mixed
     *
    **/
    protected function get($path, array $params = array(), $returnBool = false, $arrayKey = '')
    {
        return $this->request('GET', $path, $params, '', $returnBool, $arrayKey);
    }
    

    /**
     * Sends a POST HTTP request.
     *
     * @param string  $path         Path of the API class.
     * @param array   $params       OPTIONAL - POST variables to be sent.
     * @param boolean $returnBool   OPTIONAL - Will return boolean if true. True if $response['status'] === 'OK'.
     * @param array   $arrayKey     OPTIONAL - Will return all data on a specific array key of the response.
     * @return mixed
     *
    **/   
    protected function post($path, array $params = array(), $returnBool = false, $arrayKey = '')
    {
        return $this->request('POST', $path, $params, '', $returnBool, $arrayKey);
    }
    
    
    /**
     * Downloads a remote file to the local server.
     *
     * TIP: The download can take a while, and it's possible that
     * the script time outs. To prevent that, call set_time_limit(0);
     * before attempting to download the file.
     *
     * @param string $path    Path to remote file.
     * @param string $saveAS  Path to local file.
     * @return boolean
     *
    **/
    protected function downloadFile($path, $saveAS)
    {
        return $this->request('GET', $path, array(), $saveAS);
    }
    
    
    /**
     * Uploads a local file to the remote server.
     * 
     * TIP: The upload can take a while, and it's possible that
     * the script time outs. To prevent that, call set_time_limit(0);
     * before attempting to upload the file.
     *
     * @param string $path     Path to file you want to upload.
     * @param array  $params   OPTIONAL - Addition variables to be sent.
     * @return boolean
     * 
    **/
    protected function uploadFile($path, array $params = array())
    {
        return $this->request('POST', $path, $params);
    }
    
    
    /**
     * Makes an HTTP request to put.io's API and returns the response.
     *
     * @param string $method    HTTP request method. Only POST and GET are supported.
     * @param string $path      Remote path to API module.
     * @param array  $params    OPTIONAL - Variables to be sent.
     * @param string $outFile   OPTIONAL - If $outFile is set, the response will be written to this file instead of StdOut.
     * @param array  $arrayKey  OPTIONAL - Will return all data on a specific array key of the response.
     * @return mixed
     * @throws PutIO\Exceptions\PutIOLocalStorageException
     *
    **/
    protected function request($method, $path, array $params = array(), $outFile = '', $returnBool = false, $arrayKey = '')
    {
        if ($this->putio->OAuthToken)
        {
            $params['oauth_token'] = $this->putio->OAuthToken;
        }

        $url = static::API_URL . $path;
        return $this->getHTTPEngine()->request($method, $url, $params, $outFile, $returnBool, $arrayKey, $this->putio->SSLVerifyPeer);
    }
    
    
    /**
     * Creates and returns a unique instance of the requested HTTP engine class.
     *
     * @return object        Instance of the HTTP engine.
     * @throws PutIO\Exceptions\UnsupportedHTTPEngineException
     *
    **/
    protected function getHTTPEngine()
    {
        if (!isset($this->HTTPEngine))
        {
            $className = 'PutIO\Engines\HTTP\\' . $this->putio->HTTPEngine . 'Engine';
            $this->HTTPEngine = new $className();
        }
        
        return $this->HTTPEngine;
    }
}

?>