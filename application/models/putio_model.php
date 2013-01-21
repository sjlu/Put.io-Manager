<?php

class Putio_model extends CI_Model
{

   private $location = null;

   function __construct()
   {
      parent::__construct();
      $this->load->library('putio');

      $this->location = $this->config->item('putio_location');
      if (empty($this->location))
         $this->location = FCPATH.'downloads/';
   }

   private function _get_files($parent = 0)
   {
      $objects = $this->putio->list_files($parent);
      
      $files = array();
      foreach ($objects as $object)
      {
         if ($object['content_type'] == 'application/x-directory')
            $files = array_merge($files, $this->_get_files($object['id']));
         else
            $files[] = $object;
      }

      return $files;
   }

   function get_files()
   {
      return $this->_get_files();      
   }

   function download_file($file)
   {
      if (empty($file) || !isset($file['id']) || !isset($file['name']))
         return false;

      if (!file_exists($this->location . 'complete/'))
         mkdir($this->location . 'complete/');

      if (!file_exists($this->location . 'incomplete/'))
         mkdir($this->location . 'incomplete/');

      if ($this->putio->download_file($file['id'], $this->location . 'incomplete/' . $file['name']))
         rename(
            $this->location . 'incomplete/' . $file['name'], 
            $this->location . 'complete/' . $file['name']
         );
      else
         return false;

      return true;
   }

   function file_exists($file)
   {
      if (empty($file) || !isset($file['name']))
         return false;

      if (
         file_exists($this->location . 'complete/' . $file['name'])
         || file_exists($this->location . 'incomplete/' . $file['name'])
      )
         return true;

      return false;
   }

   function delete_file($file)
   {
      if (empty($file) || !isset($file['id']))
         return false;

      return $this->putio->delete_file($file['id']);
   }

}
