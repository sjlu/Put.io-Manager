<?php

class Putio_model extends CI_Model
{
   private $location = null;
   private $process = null;

   function __construct()
   {
      parent::__construct();
      $this->load->library('putio');

      $this->location = $this->config->item('putio_location');
      if (empty($this->location))
         $this->location = FCPATH . 'downloads/';

      $this->process_tv = $this->config->item('putio_process_tv');
      $this->process_movies = $this->config->item('putio_process_movies');

      $this->blackhole = $this->config->item('blackhole');

      $this->movie_path = $this->config->item('movie_path');
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

   function upload_torrents()
   {
      $location = $this->blackhole;

      $this->load->helper(array('directory', 'file'));
      $files = directory_map($location);
      foreach ($files as $file)
      {
         $this->putio->add_torrent_file($location . $file);
         unlink($location . $file);
      }
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

      if ($this->putio->download_file($file['id'], $this->location . 'incomplete/' . $file['name'])) {
         mkdir($this->location . 'complete/' . basename($file['name']));

         rename(
            $this->location . 'incomplete/' . $file['name'],
            $this->location . 'complete/' . basename($file['name']) . '/' . $file['name']
         );
      } else
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

   function process_file($file)
   {
      if (empty($file) || !isset($file['name']))
         return false;

      $dirpath = $this->location . 'complete/' . basename($file['name']) . '/';
      $filepath = $dirpath . $file['name'];

      if (filesize($filepath) < 3221225472)
         exec($this->process_tv . ' ' . $dirpath);
      else
         exec($this->process_movies . ' ' . $dirpath);

      return true;
   }

}
