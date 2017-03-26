<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lostpw extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// View data
		$data['page'] 		= 'login/lostpw';
		$data['page_title'] = 'Wachtwoord vergeten';
		$data['page_descr'] = 'Wachtwoord vergeten';

		// Load view
		$this->load->view('layout',$data);
	}

}

/* End of file lostpw.php */
/* Location: ./application/controllers/lostpw.php */