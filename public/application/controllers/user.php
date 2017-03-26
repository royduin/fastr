<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($user_id = FALSE, $user_name = FALSE,$car = FALSE,$car_id = FALSE,$car_name = FALSE,$update = FALSE,$update_id = FALSE,$update_name = FALSE)
	{
		// No user_id?
		if(!$user_id)
		{
			// Set view data
			$data['page']		= 'user/list';
			$data['page_title']	= 'Alle '.site_name().' gebruikers';
			$data['page_descr']	= 'Alle '.site_name().' gebruikers';
			$data['users']		= $this->db->get('users')->result();

			// Load view
			$this->load->view('layout',$data);
		}
		else
		{
			// Get user from the database
			$data = $this->db->get_where('users',['user_id' => $user_id])->row_array();

			// No user?
			if(empty($data)){ show_404(); }

			// No username or not the right one?
			if(!$user_name OR $user_name != url_title(e($data['username']))){ redirect('user/'.$user_id.'/'.url_title(e($data['username']))); }

			// Load cars model
			$this->load->model('cars_model');

			// Load thumb helper
			$this->load->helper('image');

			// No car?
			if(!$car)
			{
				// Set view data
				$data['page']		= 'user/user';
				$data['page_title']	= 'Auto profiel van '.$data['username'].' op '.site_name();
				$data['page_descr']	= 'Auto profiel van '.$data['username'].' op '.site_name();
				$data['cars']		= $this->cars_model->get_car(FALSE,FALSE,$user_id);
				$data['clubs']		= $this->db->select('clubs.club_id,name')->join('clubs','users_clubs.club_id = clubs.club_id')->get_where('users_clubs',['user_id' => $user_id])->result();

				// Load view
				$this->load->view('layout',$data);
			}
			// Car?
			else
			{
				// Car isn't a car or no car id?
				if($car != 'car' OR !$car_id){ redirect('user/'.$user_id.'/'.url_title(e($data['username']))); }

				// Get car
				$car = $this->cars_model->get_car( $car_id );

				// Car not found?
				if(empty($car)){ redirect('user/'.$user_id.'/'.url_title(e($data['username']))); }

				// No car name or not the right one?
				if(!$car_name OR $car_name != url_title(e($car['brand']).' '.e($car['model']).' '.e($car['type']))){ redirect('user/'.$user_id.'/'.url_title(e($data['username'])).'/car/'.$car_id.'/'.url_title(e($car['brand']).' '.e($car['model']).' '.e($car['type']))); }

				// No update?
				if(!$update)
				{
					// Get images
					$data['images'] = glob('img/cars/'.$car_id.'/*.*');

					// Images present but not a default one?
					if(!empty($data['images']) AND !$car['image_default'])
					{
						// Set the first one as default
						$this->db->update('cars',['image_default' => $data['images'][0]],['car_id' => $car_id]);
					}

					// Get updates
					$data['updates'] = $this->db->order_by('date','desc')->get_where('updates',['car_id' => $car_id])->result();

					// Load specs helper
					$this->load->helper('specs');

					// Set view data
					$data['page']		= 'car/car';
					$data['page_title']	= e($car['brand']).' '.e($car['model']).' '.e($car['type']).' van '.e($data['username']).' op '.site_name();
					$data['page_descr']	= e($car['brand']).' '.e($car['model']).' '.e($car['type']).' van '.e($data['username']).' op '.site_name();
					$data = array_merge($data,$car);

					// Load view
					$this->load->view('layout',$data);
				}
				// Update?
				else
				{
					// Update isn't a update or no update id?
					if($update != 'update' OR !$update_id){ redirect('user/'.$user_id.'/'.url_title(e($data['username'])).'/car/'.$car_id.'/'.url_title(e($car['brand']).' '.e($car['model']).' '.e($car['type']))); }

					// Get update
					$update = $this->db->get_where('updates',['update_id' => $update_id,'car_id' => $car_id])->row_array();

					// Update not found?
					if(empty($update)){ redirect('user/'.$user_id.'/'.url_title(e($data['username'])).'/car/'.$car_id.'/'.url_title(e($car['brand']).' '.e($car['model']).' '.e($car['type']))); }

					// No update name or not the right one?
					if(!$update_name OR $update_name != url_title(e($update['title']))){ redirect('user/'.$user_id.'/'.url_title(e($data['username'])).'/car/'.$car_id.'/'.url_title(e($car['brand']).' '.e($car['model']).' '.e($car['type'])).'/update/'.$update_id.'/'.url_title(e($update['title']))); }

					// Get images
					$data['images'] = glob('img/updates/'.$update_id.'/*.*');

					// Images present but not a default one?
					if(!empty($data['images']) AND !$update['image_default'])
					{
						// Set the first one as default
						$this->db->update('updates',['image_default' => $data['images'][0]],['update_id' => $update_id]);
					}

					// View data
					$data['page'] 		= 'car/update';
					$data['page_title']	= e($update['title']).' update voor de '.e($car['brand']).' '.e($car['model']).' '.e($car['type']).' van '.e($data['username']).' op '.site_name();
					$data['page_descr']	= e($update['title']).' update voor de '.e($car['brand']).' '.e($car['model']).' '.e($car['type']).' van '.e($data['username']).' op '.site_name();

					// Load view
					$this->load->view('layout',array_merge($data,$car,$update));
				}
			}
		}
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */