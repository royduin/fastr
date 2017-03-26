<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verzekering extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Set view data
		$data['page'] 		= 'verzekering';
		$data['page_title']	= 'Auto verzekeringen';
		$data['page_descr']	= 'Ben je opzoek naar een verzekering voor je auto? Hier vindt je een overzicht van auto verzekeringen.';

		// Load view
		$this->load->view('layout',$data);
	}

}

/* End of file verzekering.php */
/* Location: ./application/controllers/verzekering.php */