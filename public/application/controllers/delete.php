<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delete extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Not logged in?
		if( ! logged_in() )
		{
			// Redirect
			redirect('login');
		}

		// Load cars model
		$this->load->model('cars_model');
	}

	public function index()
	{
		// Go home!
		redirect();	
	}

	public function follow($id = 0)
	{
		// Get car
		$data = $this->cars_model->get_car($id);

		// Car not found?
		if(empty($data)){ show_404(); }

		// Follow
		$this->db->delete('following',['user_id' => user('user_id'),'car_id' => $id]);

		// Set message
		$this->session->set_flashdata('message','Je volgt nu niet meer de '.e($data['brand']).' '.e($data['model']).' ('.e($data['type']).') van '.e($data['username']));

		// Redirect
		redirect('user/'.$data['user_id'].'/'.url_title(e($data['username'])).'/car/'.$id.'/'.url_title(e($data['brand']).' '.e($data['model']).' '.e($data['type'])));
	}

	public function club_member($id = 0)
	{
		// Get club
		$data = $this->db->get_where('clubs',['club_id' => $id])->row_array();

		// Club not found or not a open club?
		if(empty($data) OR $data['open'] != 1){ show_404(); }

		// Unsubscribe member
		$this->db->delete('users_clubs',['user_id' => user('user_id'),'club_id' => $id]);

		// Set message
		$this->session->set_flashdata('message','Je lidmaatschap is beëindigd bij '.e($data['name']));

		// Redirect
		redirect('clubs/'.$id.'/'.url_title(e($data['name'])));
	}

	public function image($path = FALSE,$what = FALSE,$id = 0,$image = FALSE)
	{
		// Car?
		if($what == 'cars')
		{
			// Get car
			$car = $this->cars_model->get_car($id);

			// Car not found or it's not your car or not a valid image?
			if(empty($car) OR $car['user_id'] != user('user_id') OR !file_exists($path.'/'.$what.'/'.$id.'/'.$image)){ show_404(); }

			// Is default image?
			if($car['image_default'] == $path.'/'.$what.'/'.$id.'/'.$image)
			{
				// Remove default image
				$this->db->update('cars',['image_default' => NULL],['car_id' => $id]);
			}
		}
		// Update?
		elseif($what == 'updates')
		{
			// Get update
			$update = $this->db->select('updates.image_default,title,updates.car_id')->where(['user_id' => user('user_id'),'update_id' => $id])->join('cars','updates.car_id = cars.car_id')->get('updates')->row();

			// Update not found or not a valid image?
			if(empty($update) OR !file_exists($path.'/'.$what.'/'.$id.'/'.$image)){ show_404(); }

			// Is default image?
			if($update->image_default == $path.'/'.$what.'/'.$id.'/'.$image)
			{
				// Remove default image
				$this->db->update('updates',['image_default' => NULL],['update_id' => $id]);
			}

			// Get car
			$car = $this->cars_model->get_car($update->car_id);
		}
		// Nothing...
		else
		{
			// Show 404
			show_404();
		}

		// Remove image
		unlink($path.'/'.$what.'/'.$id.'/'.$image);

		// Search for thumbnails
		foreach(glob($path.'/'.$what.'/'.$id.'/thumb/*'.$image) as $thumb)
		{
			// Remove them
			unlink($thumb);
		}

		// Set message
		$this->session->set_flashdata('message','Afbeelding succesvol verwijderd');

		// Update?
		if($what == 'updates')
		{
			// Redirect
			redirect('user/'.$car['user_id'].'/'.url_title(e($car['username'])).'/car/'.$car['car_id'].'/'.url_title(e($car['brand']).' '.e($car['model']).' '.e($car['type'])).'/update/'.$id.'/'.url_title(e($update->title)));
		}
		else
		{
			// Redirect
			redirect('user/'.$car['user_id'].'/'.url_title(e($car['username'])).'/car/'.$id.'/'.url_title(e($car['brand']).' '.e($car['model']).' '.e($car['type'])));
		}
	}

	public function car($car_id = FALSE)
	{
		// Check if car exists and is from the user
		$found = $this->db->get_where('cars',['user_id' => user('user_id'),'car_id' => $car_id])->num_rows();

		// Found?
		if($found)
		{
			// Delete car
			$this->db->delete('cars',['car_id' => $car_id]);

			// Delete car images
			remove_dir('img/cars/'.$car_id);

			// Loop through updates
			foreach( $this->db->get_where('updates',['car_id' => $car_id])->result() as $update)
			{
				// Delete update images
				remove_dir('img/updates/'.$update->update_id);
			}

			// Remove updates
			$this->db->delete('updates',['car_id' => $car_id]);

			// Set message
			$this->session->set_flashdata('message','Auto succesvol verwijderd');

			// Redirect
			redirect('dashboard');
		}
		else
		{
			// Show 404
			show_404();
		}
	}

	public function update($update_id = FALSE)
	{
		// Check if update exists and is from the user
		$found = $this->db->where(['user_id' => user('user_id'),'update_id' => $update_id])->join('cars','updates.car_id = cars.car_id')->get('updates')->num_rows();

		// Found?
		if($found)
		{
			// Delete update
			$this->db->delete('updates',['update_id' => $update_id]);

			// Delete images
			remove_dir('img/updates/'.$update_id);

			// Set message
			$this->session->set_flashdata('message','Update succesvol verwijderd');

			// Redirect
			redirect('dashboard');
		}
		else
		{
			// Show 404
			show_404();
		}
	}
}

/* End of file delete.php */
/* Location: ./application/controllers/delete.php */