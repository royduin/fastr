<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Set view data
		$data['page'] 		= 'events/events';
		$data['page_title']	= 'Evenementen';
		$data['page_descr']	= '';

		// Load view
		$this->load->view('layout',$data);	
	}

}

/* End of file events.php */
/* Location: ./application/controllers/events.php */