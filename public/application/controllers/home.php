<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('layout',['page' => 'home']);
	}

	public function _404()
	{
		$this->output->set_status_header('404');
		$data['page'] 			= '404';
		$data['page_title']		= 'Pagina niet gevonden';
		$data['page_descr']		= 'Pagina niet gevonden';
		$this->load->view('layout',$data);
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */