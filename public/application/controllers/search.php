<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// View data
		$data['page'] = 'search';

		// Load view
		$this->load->view('layout',$data);
	}

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */