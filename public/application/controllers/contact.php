<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Set view data
		$data['page'] 			= 'contact';
		$data['page_title']		= 'Contact opnemen met '.site_name();
		$data['page_descr']		= 'Contact opnemen met '.site_name();

		// Load view
		$this->load->view('layout',$data);
	}

}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */