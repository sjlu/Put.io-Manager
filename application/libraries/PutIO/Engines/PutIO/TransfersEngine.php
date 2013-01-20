<?php

/**
 * Copyright (C) 2012  Nicolas Oelgart
 *
 * @author Nicolas Oelgart
 * @license GPL 3 http://www.gnu.org/copyleft/gpl.html
 *
 * This class manages anything related to 'Transfers'.
 * For precise return values see put.io's documentation here:
 *
 * https://api.put.io/v2/docs/#transfers
 *
**/

namespace PutIO\Engines\PutIO;

use PutIO\Helpers\PutIO\PutIOHelper;

class TransfersEngine extends PutIOHelper
{
    
    /**
     * Returns an array of active transfers.
     *
     * @return array
     *
    **/
    public function listall()
    {
        return $this->get('transfers/list', array(), false, 'transfers');
    }
    
    
    /**
     * Adds a new transfer to the queue.
     *
     * @param string  $url          URL of the file/torrent
     * @param integer $parentID     OPTIONAL - ID of the target folder. 0 = root
     * @param boolean $extract      OPTIONAL - Extract file when download complete
     * @param string  $callbackUrl  OPTIONAL - put.io will POST the metadata of the file to the given URL when file is ready.
     * @return array
     *
    **/
    public function add($url, $parentID = 0, $extract = false, $callbackUrl = '')
    {
        return $this->post('transfers/add', array('url' => $url, 'save_parent_id' => $parentID, 'extract' => ($extract ? 'True' : 'False'), 'callback_url' => $callbackUrl), false, 'transfer');
    }
    
    
    /**
     * Returns an array containing information about the transfer.
     *
     * @param integer $transferID   ID of the transfer
     * @return array
     * 
    **/
    public function info($transferID)
    {
        return $this->get('transfers/' . $transferID, array(), false, 'transfer');
    }
    
    
    /**
     * Cancels given transfers.
     *
     * @param mixed $transferIDs   Transfer IDs you want to cancel. Array or integer.
     * @return boolean
     *
    **/
    public function cancel($transferIDs)
    {
        return $this->post('transfers/cancel', array('transfer_ids' => is_array($transferIDs) ? implode(',', $transferIDs) : $transferIDs), true);
    }
}

?>