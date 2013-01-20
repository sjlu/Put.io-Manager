<?php

/**
 * Copyright (C) 2012  Nicolas Oelgart
 *
 * @author Nicolas Oelgart
 * @license GPL 3 http://www.gnu.org/copyleft/gpl.html
 *
 * This class manages anything related to 'Files'.
 * For precise return values see put.io's documentation here:
 *
 * https://api.put.io/v2/docs/#files
 *
**/

namespace PutIO\Engines\PutIO;

use PutIO\Helpers\PutIO\PutIOHelper;

class FilesEngine extends PutIOHelper
{
    
    /**
     * Returns an array of files. False on error.
     *
     * @param integer $parentID  OPTIONAL - Only returns files of $parentID if supplied
     * @return mixed
     *
    **/
    public function listall($parentID = 0)
    {
        return $this->get('files/list', array('parent_id' => $parentID), false, 'files');
    }
    
    
    /**
     * Returns an array of files matching the given search query.
     *
     * @param string  $query   Search query
     * @param integer $page    OPTIONAL - Page number
     * @return array
     *
    **/
    public function search($query, $page = 1)
    {
        return $this->get('files/search/' . rawurlencode(trim($query)) . '/page/' . $page, array());
    }
    
    
    /**
     * Uploads a local file to your account.
     *
     * NOTE 1: The response differs based on the uploaded file. For regular files, the
     * array key containing the info is 'file', but for torrents it's 'transfer'.
     * @see https://api.put.io/v2/docs/#files-upload
     *
     * NOTE 2: Files need to be read into the memory when using NATIVE functions. Keep
     * that in mind when uploading large files or running multiple instances.
     *
     * @param string  $file        Path to local file.
     * @param integer $parentID    OPTIONAL - ID of upload folder.
     * @return mixed
     *
    **/
    public function upload($file, $parentID = 0)
    {
        return $this->uploadFile('files/upload', array('parent_id', $parentID, 'file' => '@' . $file));
    }
    
    
    /**
     * Creates a new folder. Returns folder info on success, false on error.
     *
     * @param string  $name        Name of the new folder.
     * @param integer $parentID    OPTIONAL - ID of the parent folder.
     * @return mixed
     *
    **/
    public function makeDir($name, $parentID = 0)
    {
        return $this->post('files/create-folder', array('name' => $name, 'parent_id' => $parentID), false, 'file');
    }
    
    
    /**
     * Returns an array of information about given file. False on error.
     *
     * @param integer $fileID   ID of the file.
     * @return mixed
     *
    **/
    public function info($fileID)
    {
        return $this->get('files/' . $fileID, array(), false, 'file');
    }
    
    
    /**
     * Deletes files from your account.
     *
     * @param mixed $fileIDs   IDs of files you want to delete. Array or integer.
     * @return boolean
     *
    **/
    public function delete($fileIDs)
    {
        return $this->post('files/delete', array('file_ids' => is_array($fileIDs) ? implode(',', $fileIDs) : $fileIDs), true);
    }
    
    
    /**
     * Renames a file.
     *
     * @param integer $fileID  ID of the file you want to rename.
     * @param string  $name    New name of the file.
     * @return boolean
     *
    **/
    public function rename($fileID, $name)
    {
        return $this->post('files/rename', array('file_id' => $fileID, 'name' => $name), true);
    }
    
    
    /**
     * Moves one of more files to a new directory.
     *
     * @param mixed   $fileIDs      IDs of files you want to move. Array or integer.
     * @param integer $parentID     ID of the folder you want to move the files to.
     * @return boolean
     *
    **/
    public function move($fileIDs, $parentID)
    {
        return $this->post('files/move', array('file_ids' => (is_array($fileIDs) ? implode(',', $fileIDs) : $fileIDs), 'parent_id' => $parentID), true);
    }
    
    
    /**
     * Converts a remote file to MP4 (whenever possible).
     *
     * @param integer $fileID   ID of the file you want to convert.
     * @return boolean
     *
    **/
    public function convertToMP4($fileID)
    {
        return $this->post('files/' . $fileID . '/mp4', array(), true);
    }
    
    
    /**
     * Returns information about the conversation process of a specific file.
     *
     * @param integer $fileID    ID of the file you want to get the status of.
     * @return array
     *
    **/
    public function getMP4Status($fileID)
    {
        return $this->get('files/' . $fileID . '/mp4', array(), false, 'mp4');
    }
    
    
    /**
     * Downloads a remote file to the local server. Second parameter '$SaveAs' is
     * optional, but very recommened. If it's left empty, it'll query for the original
     * file name by sending an additional HTTP request.
     *
     * @param integer  $fileID   ID of the file you want to download.
     * @param string   $saveAS   OPTIONAL - Local path you want to save the file to.
     * @param boolean  $isMP4    OPTIONAL - Tells whether or not to download the MP4 version of a file.
     * @return boolean
     *
    **/
    public function download($fileID, $saveAs = '', $isMP4 = false)
    {
        if ($saveAs === '')
        {
            if (!$info = $this->info($fileID))
            {
                return false;
            }
            
            $saveAs = $info['name'];
        }
        
        return $this->downloadFile('files/' . $fileID . '/' . ($isMP4 ? 'MP4/' : '') . 'download', $saveAs);
    }
    
    
    /**
     * Downloads the MP4 version of a file if available.
     * Alias of FilesEngine::download($fileID, $saveAS, true)
     *
     * @see self::download()
     *
     * @param integer $fileID   ID of the file you want to download.
     * @param string  $saveAS   Local path you want to save the file to.
     * @return boolean
     *
    **/
    public function downloadMP4($fileID, $saveAS)
    {
        return $this->download($fileID, $saveAs, true);
    }
}

?>