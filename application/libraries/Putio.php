<?php

class Putio {

   private $key = null;
   private $putio = null;

   function __construct()
   {

      $ci =& get_instance();
      $ci->config->load('putio');
      $this->key = $ci->config->item('putio_key');

      require_once(APPPATH.'libraries/PutIO/Autoloader.php');
      $this->putio = new PutIO\API($this->key);

   }

   function add_torrent_file($file)
   {
      $url = 'https://api.put.io/v2/files/upload?oauth_token=' . $this->key;
      $post = array(
             "file" => "@" . $file
      );

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_VERBOSE, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);

      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      return curl_exec($ch);

      // return $this->putio->files->upload($file);
   }

   function add_torrent($url)
   {
      $this->putio->transfers->add($url);
   }

   function list_files($parent = 0)
   {
      return $this->putio->files->listall($parent);
   }

   function download_file($file_id, $save_as)
   {
      return $this->putio->files->download($file_id, $save_as);
   }

   function delete_file($file_id)
   {
      return $this->putio->files->delete($file_id);
   }

}
