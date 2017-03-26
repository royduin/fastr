<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Not logged in?
		if( !logged_in() )
		{
			redirect('login');
		}

		// Load cars model
		$this->load->model('cars_model');

		// Load image helper
		$this->load->helper('image');
	}

	public function index()
	{
		// Information
		$data['cars'] 		= $this->cars_model->get_car(FALSE,FALSE,user('user_id'));
		$data['clubs'] 		= $this->db->join('clubs','users_clubs.club_id = clubs.club_id')->get_where('users_clubs',['user_id' => user('user_id')])->result();
		$data['comments'] 	= '';
		$data['following'] 	= $this->db->query('
			SELECT
				update_id,
				updates.title as update_title,
				date as update_date,
				updates.image_default as update_image,
				users.user_id,
				username,
				cars.car_id,
				cars.image_default,
				label,
				year,
				IFNULL(brand_name,"Onbekend") as brand,
				IFNULL(model_name,"Onbekend") as model,
				IFNULL(type_name,"Onbekend") as type
			FROM
				following
			LEFT JOIN cars ON cars.car_id = following.car_id
			LEFT JOIN brands ON brand_id = brand
			LEFT JOIN models ON model_id = model
			LEFT JOIN types ON type_id = type
			LEFT JOIN users ON cars.user_id = users.user_id
			LEFT JOIN updates ON updates.car_id = following.car_id AND updates.update_id = (SELECT MAX(update_id) FROM updates WHERE car_id = cars.car_id)
			WHERE
				following.user_id = '.$this->db->escape(user('user_id')).'
		')->result();
		$data['page'] 		= 'dashboard/dashboard';

		// Load view
		$this->load->view('layout',$data);
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */