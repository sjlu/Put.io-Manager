<?php

class Test extends CI_Controller 
{
   function __construct()
   {
      parent::__construct();
      $this->load->library('putio');
      $this->load->model('putio_model');
   }

   function files()
   {
      print_r($this->putio_model->list_all_files());
   }

   function grab()
   {
      print_r($this->putio_model->download_file(array('id' => 56499291, 'name' => 'test_file.mkv')));
   }
   
}
