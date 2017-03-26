<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		show_404();
	}

	public function sitemap()
	{
		// Load cars model
		$this->load->model('cars_model');

		// Generate sitemap
		$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
		$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		$sitemap .= $this->_sitemap_item();
		$sitemap .= $this->_sitemap_item('login');
		$sitemap .= $this->_sitemap_item('register');
		$sitemap .= $this->_sitemap_item('search');
		$sitemap .= $this->_sitemap_item('contact');
		$sitemap .= $this->_sitemap_item('clubs');

		// Clubs
		foreach($this->db->get('clubs')->result() as $club)
		{
			$sitemap .= $this->_sitemap_item('clubs/'.$club->club_id.'/'.url_title(e($club->name)));
		}
		$sitemap .= $this->_sitemap_item('events');
		$sitemap .= $this->_sitemap_item('cars');
		$sitemap .= $this->_sitemap_item('user');

		// Users
		foreach($this->db->get_where('users',['visible' => 0])->result() as $user)
		{
			$sitemap .= $this->_sitemap_item('user/'.$user->user_id.'/'.url_title(e($user->username)));

			// Cars
			foreach($this->cars_model->get_car(FALSE,FALSE,$user->user_id) as $car)
			{
				$sitemap .= $this->_sitemap_item('user/'.$user->user_id.'/'.url_title(e($user->username)).'/car/'.$car->car_id.'/'.url_title(e($car->brand).' '.e($car->model).' '.e($car->type)));

				// Updates
				foreach($this->db->get_where('updates',['car_id' => $car->car_id])->result() as $update)
				{
					$sitemap .= $this->_sitemap_item('user/'.$user->user_id.'/'.url_title(e($user->username)).'/car/'.$car->car_id.'/'.url_title(e($car->brand).' '.e($car->model).' '.e($car->type)).'/update/'.$update->update_id.'/'.url_title(e($update->title)));					
				}
			}
		}
		$sitemap .= '</urlset>';

		// Save sitemap
		file_put_contents('sitemap.xml', $sitemap);
		
		// Echo sitemap
		echo $sitemap;
	}

	public function _sitemap_item($url = '')
	{
		return '<url><loc>'.site_url($url).'</loc></url>';
	}

}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */