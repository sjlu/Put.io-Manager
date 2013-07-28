<?php

class Cron extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('putio_model'));
	}

	function sync()
	{
		// upload the files
		$this->putio_model->upload_torrents();

		// get the file list
		$files = $this->putio_model->get_files();

		// download each file
		foreach ($files as &$file)
		{
			if ($this->putio_model->file_exists($file))
				continue;

			if ($this->putio_model->download_file($file))
				$this->putio_model->delete_file($file);

			$this->putio_model->process_file($file);
		}

	}

}