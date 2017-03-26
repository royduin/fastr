<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addedit extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Not logged in?
		if( ! logged_in() )
		{
			// Redirect
			redirect('login');
		}

		// Load form validation
		$this->load->library('form_validation');

		// Remove delimiters
		$this->form_validation->set_error_delimiters('', '');

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
		$this->db->insert('following',['user_id' => user('user_id'),'car_id' => $id]);

		// Set message
		$this->session->set_flashdata('message','Je volgt nu de '.e($data['brand']).' '.e($data['model']).' ('.e($data['type']).') van '.e($data['username']));

		// Redirect
		redirect('user/'.$data['user_id'].'/'.url_title(e($data['username'])).'/car/'.$id.'/'.url_title(e($data['brand']).' '.e($data['model']).' '.e($data['type'])));
	}

	public function comment($what = FALSE,$id = 0)
	{
		// Nothing set?
		if(!$what OR !$id){ show_404(); }

		// Nothing posted or no redirect source?
		if(!$this->input->post('comment') OR !$this->input->post('source')){ show_404(); }

		// Type not exists?
		if(!in_array($what,config_item('comment_types'))){ show_404(); }

		// ID doesn't exists?
		if(!$this->db->get_where($what.'s',[$what.'_id' => $id])->num_rows()){ show_404(); }

		// Insert comment!
		$this->db->insert('comments',['user_id' => user('user_id'),'comment' => $this->input->post('comment'),'what' => $what,'what_id' => $id]);

		// Get comment ID
		$comment_id = $this->db->insert_id();

		// Set message
		$this->session->set_flashdata('message','Je reactie is succesvol geplaatst');

		// Redirect
		redirect( $this->input->post('source').'#reactie-'.$comment_id );
	}

	public function club_member($id = 0)
	{
		// Get club
		$data = $this->db->get_where('clubs',['club_id' => $id])->row_array();

		// Club not found or not a open club?
		if(empty($data) OR $data['open'] != 1){ show_404(); }

		// Become a member!
		$this->db->insert('users_clubs',['user_id' => user('user_id'),'club_id' => $id]);

		// Set message
		$this->session->set_flashdata('message','Je bent nu lid van '.e($data['name']));

		// Redirect
		redirect('clubs/'.$id.'/'.url_title(e($data['name'])));
	}

	public function club($id = 0)
	{
		// Get club
		$data = $this->db->get_where('clubs',['club_id' => $id])->row_array();

		// Club not found or you haven't permission to edit?
		if(empty($data) OR $data['manager'] != user('user_id')){ show_404(); }

		// Data for the view
		$data['page'] 		= 'add-edit/club';
		$data['page_title'] = 'Club pagina bewerken';
		$data['page_descr']	= 'Club pagina bewerken';
		$data['js']			= 'clubs';
		$data['members']	= implode(',',array_map(function($array) { return $array['user_id']; }, $this->db->select('user_id')->get_where('users_clubs',['club_id' => $id])->result_array()));

		// Set rules
		$this->form_validation->set_rules('name', 'name', 'required|max_length[255]');
		$this->form_validation->set_rules('email', 'email', 'required|max_length[255]|valid_email');
		$this->form_validation->set_rules('website', 'website', 'required|max_length[255]|prep_url');
		$this->form_validation->set_rules('description', 'omschrijving', 'required');
		$this->form_validation->set_rules('open', 'open club', '');

		// Validation successfull?
		if ($this->form_validation->run())
		{
			// Update in the database
			$this->db->update('clubs',[
				'name' 			=> $this->input->post('name'),
				'email' 		=> $this->input->post('email'),
				'website' 		=> $this->input->post('website'),
				'description' 	=> $this->input->post('description'),
				'open' 			=> $this->input->post('open')
			],'club_id = '.$id);

			// Not an open club?
			if($this->input->post('open') != 1)
			{
				// Add new ones
				foreach(explode(',',$this->input->post('members')) as $user_id)
				{
					// Create array of members
					$items[] = ['user_id' => $user_id,'club_id' => $id];
				}

				// Remove old ones
				$this->db->delete('users_clubs',['club_id' => $id]);

				// Insert into the database
				$this->db->insert_batch('users_clubs',$items);
			}

			// Check if image directory exists
			if(!file_exists('img/clubs/'.$id))
			{
				// Create directories
				mkdir('img/clubs/'.$id);
				mkdir('img/clubs/'.$id.'/thumb');
			}

			// New logo?
			if(is_uploaded_file($_FILES['logo']['tmp_name']))
			{
				// Set upload settings
				$config['upload_path'] 		= 'img/clubs/'.$id.'/';
				$config['allowed_types'] 	= 'gif|png|jpg|jpeg|bmp|jpe|tiff|tif';
				$config['max_size']			= 5120; // 5MB
				$config['file_name']		= 'logo';
				$config['overwrite']		= TRUE;

				// Load upload library
				$this->load->library('upload', $config);

				// Upload
				if (!$this->upload->do_upload('logo'))
				{
					// Send error to the view
					$data['error'] = $this->upload->display_errors('','');

					// Load view
					$this->load->view('layout',$data);
				}
				else
				{
					// Set message
					$this->session->set_flashdata('message','Club pagina succesvol bewerkt');

					// Redirect
					redirect('clubs/'.$id.'/'.url_title(e($data['name'])));
				}
			}
			else
			{
				// Set message
				$this->session->set_flashdata('message','Club pagina succesvol bewerkt');

				// Redirect
				redirect('clubs/'.$id.'/'.url_title(e($data['name'])));
			}
		}
		else
		{
			// Load view
			$this->load->view('layout',$data);
		}
	}

	public function image_default($path = FALSE,$what = FALSE,$id = 0,$image = FALSE)
	{
		// Load cars model
		$this->load->model('cars_model');

		// Car?
		if($what == 'cars')
		{
			// Get car
			$car = $this->cars_model->get_car($id);

			// Car not found or it's not your car or not a valid image?
			if(empty($car) OR $car['user_id'] != user('user_id') OR !file_exists($path.'/'.$what.'/'.$id.'/'.$image)){ show_404(); }

			// Set image to the default
			$this->db->update('cars',['image_default' => $path.'/'.$what.'/'.$id.'/'.$image],['car_id' => $id]);

			// Set message
			$this->session->set_flashdata('message','Afbeelding succesvol als standaard ingesteld');

			// Redirect
			redirect('user/'.$car['user_id'].'/'.url_title(e($car['username'])).'/car/'.$id.'/'.url_title(e($car['brand']).' '.e($car['model']).' '.e($car['type'])));
		}
		// Updates?
		elseif($what == 'updates')
		{
			// Get update
			$update = $this->db->where(['user_id' => user('user_id'),'update_id' => $id])->join('cars','updates.car_id = cars.car_id')->get('updates')->row();

			// Update not found or not a valid image?
			if(empty($update) OR !file_exists($path.'/'.$what.'/'.$id.'/'.$image)){ show_404(); }

			// Set image to the default
			$this->db->update('updates',['image_default' => $path.'/'.$what.'/'.$id.'/'.$image],['update_id' => $id]);

			// Get car
			$car = $this->cars_model->get_car($update->car_id);

			// Set message
			$this->session->set_flashdata('message','Afbeelding succesvol als standaard ingesteld');

			// Redirect
			redirect('user/'.$car['user_id'].'/'.url_title(e($car['username'])).'/car/'.$car['car_id'].'/'.url_title(e($car['brand']).' '.e($car['model']).' '.e($car['type'])).'/update/'.$id.'/'.url_title(e($update->title)));
		}
		// Nothing...
		else
		{
			// Show 404
			show_404();
		}
	}

	public function update($car_id = 0,$update_id = FALSE)
	{
		// Get car
		$data = $this->cars_model->get_car($car_id);

		// Car not found or not your car?
		if(!count($data) OR $data['user_id'] != user('user_id')){ show_404(); }

		// Remove description, it conflicts with the update description
		unset($data['description']);

		// Update ID set?
		if($update_id)
		{
			// Get update
			$update = $this->db->get_where('updates',['update_id' => $update_id,'car_id' => $car_id])->row_array();

			// No update found?
			if(!count($update)){ show_404(); }

			// Merge car and update information
			$data = array_merge($data,$update);

			// Set view data
			$data['page_title']	= 'Update bewerken';
			$data['page_descr']	= 'Update bewerken';
		}
		else
		{
			// Set view data
			$data['page_title']	= 'Update toevoegen aan je auto profiel';
			$data['page_descr']	= 'Update toevoegen aan je auto profiel';
		}

		// Set rules
		$this->form_validation->set_rules('title', 'title', 'required|max_length[255]');
		$this->form_validation->set_rules('date', 'date', 'required|callback__check_date');
		$this->form_validation->set_rules('description', 'omschrijving', 'required');

		// Validation successful?
		if ($this->form_validation->run())
		{
			// Update ID set?
			if($update_id)
			{
				// Update in the database
				$this->db->update('updates',[
					'title' 		=> $this->input->post('title'),
					'date' 			=> $this->input->post('date'),
					'description' 	=> $this->input->post('description')
				],'update_id = '.$update_id);

				// Set message
				$this->session->set_flashdata('message','Update succesvol bewerkt');
			}
			else
			{
				// Insert into the database
				$this->db->insert('updates',[
					'car_id'		=> $car_id,
					'title' 		=> $this->input->post('title'),
					'date' 			=> $this->input->post('date'),
					'description' 	=> $this->input->post('description'),
					'hash'			=> md5(time().rand(0,9999))
				]);
				$update_id = $this->db->insert_id();

				// Set message
				$this->session->set_flashdata('message','Update succesvol toegevoegd');
			}
			
			// Redirect
			redirect('user/'.$data['user_id'].'/'.url_title(e($data['username'])).'/car/'.$car_id.'/'.url_title(e($data['brand']).' '.e($data['model']).' '.e($data['type'])).'/update/'.$update_id.'/'.url_title(e($this->input->post('title'))));
		}
		else
		{
			// Set data
			$data['page'] 		= 'add-edit/update';

			// Load view
			$this->load->view('layout',$data);
		}
	}

	public function photo($car_id = 0,$update_id = FALSE)
	{
		// Get car
		$data = $this->cars_model->get_car($car_id);

		// Car not found or not your car?
		if(!count($data) OR $data['user_id'] != user('user_id')){ show_404(); }

		// Update ID set?
		if($update_id)
		{
			// Get update
			$update = $this->db->get_where('updates',['update_id' => $update_id,'car_id' => $car_id])->row_array();

			// No update found?
			if(!count($update)){ show_404(); }

			// Merge data
			$data = array_merge($data,$update);

			// Set directory name
			$dir = 'updates';

			// Set view data
			$data['page_title']	= 'Foto toevoegen aan update';
			$data['page_descr']	= 'Foto toevoegen aan update';
		}
		else
		{
			// Set directory name
			$dir = 'cars';

			// Set view data
			$data['page_title']	= 'Foto toevoegen aan je auto profiel';
			$data['page_descr']	= 'Foto toevoegen aan je auto profiel';
		}

		// Cars images folder not exists?
		if(!file_exists('img/'.$dir.'/'.($update_id ?: $car_id)))
		{
			// Create folders
			mkdir('img/'.$dir.'/'.($update_id ?: $car_id));
			mkdir('img/'.$dir.'/'.($update_id ?: $car_id).'/thumb/');
		}

		// Set upload settings
		$config['upload_path'] 		= 'img/'.$dir.'/'.($update_id ?: $car_id).'/';
		$config['allowed_types'] 	= 'gif|png|jpg|jpeg|bmp|jpe|tiff|tif';
		$config['max_size']			= 5120; // 5MB
		$config['encrypt_name']		= TRUE;

		// Load upload library
		$this->load->library('upload', $config);

		// Posted?
		if($_FILES)
		{
			// Change $_FILES to new vars and loop them
			foreach($_FILES['userfile'] as $key=>$value)
			{
				foreach($value as $i=>$val)
				{
					$field_name = "file_".$i;
					$_FILES[$field_name][$key] = $val;
				}
			}

			// Unset the useless one
			unset($_FILES['userfile']);

			// Loop throug the files
			foreach($_FILES as $field_name => $file)
			{
				// Upload
				if ( ! $this->upload->do_upload($field_name))
				{
					// Set errors
					$errors[] = $this->upload->display_errors();
				}
			}

			// No errors?
			if(!isset($errors))
			{
				// Set message
				$this->session->set_flashdata('message','Afbeelding(en) succesvol toegevoegd');

				// Update ID set?
				if($update_id)
				{
					// Redirect to update
					redirect('user/'.$data['user_id'].'/'.url_title(e($data['username'])).'/car/'.$car_id.'/'.url_title(e($data['brand']).' '.e($data['model']).' '.e($data['type'])).'/update/'.$update_id.'/'.url_title(e($update['title'])));
				}
				else
				{
					// Redirect to car
					redirect('user/'.$data['user_id'].'/'.url_title(e($data['username'])).'/car/'.$car_id.'/'.url_title(e($data['brand']).' '.e($data['model']).' '.e($data['type'])));
				}
			}
		}

		// Set data
		$data['page'] 		= 'add-edit/photo';
		$data['error'] 		= $this->upload->display_errors('<div class="alert alert-error">','</div>');

		// Load view
		$this->load->view('layout',$data);
	}

	public function car($car_id = FALSE)
	{
		// Car ID set?
		if($car_id)
		{
			// Get car
			$data = $this->cars_model->get_car($car_id);

			// Car not found or not your car?
			if(!count($data) OR $data['user_id'] != user('user_id')){ show_404(); }

			// Set view data
			$data['page_title']	= 'Auto bewerken';
			$data['page_descr']	= 'Auto bewerken';
		}
		else
		{
			// Set view data
			$data['page_title']	= 'Auto toevoegen';
			$data['page_descr']	= 'Auto toevoegen';
		}

		// Set rules
		$this->form_validation->set_rules('label', 'label', 'required|max_length[255]');
		$this->form_validation->set_rules('brand', 'merk', 'required|max_length[255]');
		$this->form_validation->set_rules('model', 'model', 'required|max_length[255]');
		$this->form_validation->set_rules('type', 'uitvoering', 'required|max_length[255]');
		$this->form_validation->set_rules('year', 'jaar', 'required|greater_than[0]');
		$this->form_validation->set_rules('color', 'kleur', 'required|greater_than[0]');
		$this->form_validation->set_rules('description', 'omschrijving', 'required');
		$this->form_validation->set_rules('specs', 'specificaties', '');

		// Validation successfull?
		if ($this->form_validation->run())
		{
			// Get ID's
			$brand_id 	= $this->cars_model->get_insert('brand');
			$model_id 	= $this->cars_model->get_insert('model',['brand_id' => $brand_id]);
			$type_id 	= $this->cars_model->get_insert('type',['model_id' => $model_id]);

			// Car ID set? So edit?
			if($car_id)
			{
				// Update in the database
				$this->db->update('cars',[
					'label' 		=> $this->input->post('label'),
					'brand' 		=> $brand_id,
					'model' 		=> $model_id,
					'type' 			=> $type_id,
					'year' 			=> $this->input->post('year'),
					'color' 		=> $this->input->post('color'),
					'description' 	=> $this->input->post('description'),
					'specs' 		=> remove_empty_lines($this->input->post('specs'))
				],'car_id = '.$car_id);

				// Set message
				$this->session->set_flashdata('message','Auto succesvol bewerkt');
			}
			else
			{
				// Insert into the database
				$this->db->insert('cars',[
					'user_id' 		=> user('user_id'),
					'label' 		=> $this->input->post('label'),
					'brand' 		=> $brand_id,
					'model' 		=> $model_id,
					'type' 			=> $type_id,
					'year' 			=> $this->input->post('year'),
					'color' 		=> $this->input->post('color'),
					'description' 	=> $this->input->post('description'),
					'specs' 		=> remove_empty_lines($this->input->post('specs')),
					'hash'			=> md5(time().rand(0,9999))
				]);
				$car_id = $this->db->insert_id();

				// Set message
				$this->session->set_flashdata('message','Auto succesvol toegevoegd');
			}

			// Redirect
			redirect('user/'.user('user_id').'/'.url_title(e(user('username'))).'/car/'.$car_id.'/'.url_title(e($this->input->post('brand')).' '.e($this->input->post('model')).' '.e($this->input->post('type'))));
		}
		else
		{
			// Set view data
			$data['page'] 	= 'add-edit/car';
			$data['js']		= 'add-car';
			$data['colors']	= $this->db->order_by('color','asc')->get('colors')->result();

			// Load view
			$this->load->view('layout',$data);
		}
	}

	// Valid date?
	public function _check_date($date)
	{
		// Length equal to 10?
		if(strlen($date) == 10)
		{
			// Explode it
			$date = explode('-',$date);

			// 3 array items?
			if(count($date) == 3)
			{
				// Valid date?
				if(checkdate($date[1],$date[2],$date[0]))
				{
					// Return TRUE
					return TRUE;
				}
			}
		}

		// Set message and return FALSE
		$this->form_validation->set_message('_check_date', 'Geen geldige datum');
		return FALSE;
	}

}

/* End of file add.php */
/* Location: ./application/controllers/add.php */