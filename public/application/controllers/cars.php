<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cars extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Load cars model
		$this->load->model('cars_model');

		// Load image helper
		$this->load->helper('image');
	}

	public function index()
	{
		// Posted?
		if( $this->input->get() )
		{
			// Get all cars by filters
			$data['cars'] 		= $this->cars_model->get_car_search( $this->input->get() );	
		}
		else
		{
			// Get all cars
			$data['cars'] 		= $this->cars_model->get_car_search();
		}

		// Get brands
		$data['brands'] 	= $this->db->get('brands')->result();

		// Get colors
		$data['colors']		= $this->db->get('colors')->result();

		// Clubs
		$data['clubs']		= $this->db->get('clubs')->result();

		// View data
		$data['js']				= 'cars';
		$data['page'] 			= 'cars/cars';
		$data['page_title']		= 'Bekijk alle auto\'s van de autoliefhebbers op '.site_name();
		$data['page_descr']		= 'Bekijk alle auto\'s van de autoliefhebbers op '.site_name();

		// Load view
		$this->load->view('layout',$data);
	}

}

/* End of file cars.php */
/* Location: ./application/controllers/cars.php */