<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Remove session
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('email');

		// Redirect
		redirect();
	}

}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */