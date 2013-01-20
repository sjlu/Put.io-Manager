<?php

/**
 * Copyright (C) 2012  Nicolas Oelgart
 * 
 * @author Nicolas Oelgart
 * @license GPL 3 http://www.gnu.org/copyleft/gpl.html
 *
 * Handles HTTP requests using cURL.
 *
**/

namespace PutIO\Helpers\HTTP;

use PutIO\Exceptions\MissingJSONException;
use \Services_JSON;


abstract class HTTPHelper
{
    
    /**
     * Holds whether or not the JSON PHP extension is available.
     * Sets automatically.
     *
    **/
    protected $jsonExt = null;
    
    
    /**
     * Returns true if the server responded with status === OK
     * False if anything else.
     *
     * @param array $response    Response from remote server.
     * @return boolean
     *
    **/
    protected function getStatus(array $response)
    {
        if (isset($response['status']) AND $response['status'] === 'OK')
        {
            return true;
        }
        
        return false;
    }
    
    
    /**
     * Parses the response header from the server, fetches the
     * HTTP status code, and returns it.
     *
     * @param array $headers    Array containing response headers
     * @return integer
     *
    **/
    protected function getResponseCode(array $headers)
    {
        if (isset($headers[0]) AND preg_match('~HTTP/1\.[01]\s+(\d+)~', $headers[0], $match))
        {
            return (int) $match[1];
        }
        
        return 0;
    }
    
    
    /**
     * Attemps to get the MIME type of a given file. Required for native file
     * uploads.
     * 
     * Relies on the file info extension, which is shipped with PHP 5.3
     * and enabled by default. So,... nothing should go wrong, RIGHT?
     *
     * @param string $file    Path of the file you want to get the MIME type of.
     * @return string
     *
    **/
    protected function getMIMEType($file)
    {
        if (function_exists('finfo_open') AND $info = @finfo_open(FILEINFO_MIME))
        {
            if (($mime = @finfo_file($info, $file)) !== false)
            {
                $mime = explode(';', $mime);
                return trim($mime[0]);
            }
        }

        return 'application/octet-stream';
    }
    
    
    /**
     * Decodes the response and returns the appropriate value
     *
     * @param string $response      Response data from server. Must be JSON encoded.
     * @param string $returnBool    Whether or not to return boolean
     * @param array  $arrayKey      OPTIONAL - Will return all data on a specific array key of the response.
     * @return mixed
     *
    **/
    protected function getResponse($response, $returnBool, $arrayKey = '')
    {
        if (($response = $this->jsonDecode($response)) === null)
        {
            return false;
        }
        
        if ($returnBool)
        {
            return $this->getStatus($response);
        }
        
        if ($arrayKey)
        {
            if (isset($response[$arrayKey]))
            {
                return $response[$arrayKey];
            }
            
            return false;
        }
        
        return $response;
    }
    
    
    /**
     * Decodes a JSON encoded string.
     *
     * Requires either the JSON PHP extension, or the Services_JSON Pear
     * package. The Pear package is not shipped with this one, but if you
     * rely on it, download it from here:
     *
     * http://pear.php.net/package/Services_JSON/download
     * (Tested with version 1.0.3)
     *
     * Extract 'JSON.php' from the package and place it into:
     *
     * PutIO/Engines/JSON/
     *
     * The rest is handled by the script.
     *
     * @param string $string   JSON encoded string
     * @return mixed
     * @throws PutIO\Exceptions\MissingJSONException
     *
    **/
    protected function jsonDecode($string)
    {
        if (!isset($this->jsonExt))
        {
            $this->jsonExt = function_exists('json_decode');
        }
        
        if ($this->jsonExt)
        {
            return json_decode($string, true);
        }

        $included = @include_once __PUTIO_ROOT__ . '/Engines/JSON/JSON.php';
        
        if ($included === false)
        {
            throw new MissingJSONException('JSON.php is missing from the /Engines/JSON/ directory.');
        }
        
        $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        return $json->decode($string);
    }
}

?>