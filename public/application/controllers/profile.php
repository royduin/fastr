<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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
	}

	// Change profile
	public function index()
	{
		// Form rules
		$this->form_validation->set_rules('email', 'email adres', 'required|callback__is_unique_excepts|max_length[255]|valid_email');
		$this->form_validation->set_rules('city', 'woonplaats', 'max_length[255]');
		$this->form_validation->set_rules('website', 'website', 'max_length[255]|prep_url');
		$this->form_validation->set_rules('birth', 'geboorte datum', 'callback__check_date');
		$this->form_validation->set_rules('description', 'omschrijving', '');
		$this->form_validation->set_rules('visible', 'zichtbaar voor', 'is_natural');

		// Validation successful?
		if ($this->form_validation->run())
		{
			// Update records in the database
			$this->db->update('users',[
				'email'			=> $this->input->post('email'),
				'city'			=> $this->input->post('city') ?: NULL,
				'website'		=> $this->input->post('website') ?: NULL,
				'birth'			=> $this->input->post('birth') ?: NULL,
				'description'	=> $this->input->post('description') ?: NULL,
				'visible'		=> $this->input->post('visible')
			],'user_id = '.user('user_id'));

			// Set message
			$this->session->set_flashdata('message','Je profiel is succesvol bijgewerkt');

			// Redirect
			redirect('dashboard');
		}
		else
		{
			// Get user information
			$data = $this->db->get_where('users',['user_id' => user('user_id')])->row_array();

			// Set view data
			$data['page'] 		= 'profile/profile';
			$data['page_title']	= 'Profiel bewerken';
			$data['page_descr']	= 'Profiel bewerken';

			// Load view
			$this->load->view('layout',$data);	
		}
	}

	// Change password
	public function password()
	{
		// Set rules
		$this->form_validation->set_rules('password', 'wachtwoord', 'required|callback__login_check');
		$this->form_validation->set_rules('password_new', 'wachtwoord herhalen', 'required|matches[password_new2]');
		$this->form_validation->set_rules('password_new2', 'wachtwoord herhalen', 'required');

		// Validation successful?
		if ($this->form_validation->run())
		{
			// Update password in the database
			$this->db->update('users',[
				'password' => sha1($this->input->post('password_new').config_item('encryption_key'))
			],'user_id = '.user('user_id'));

			// Set message
			$this->session->set_flashdata('message','Je wachtwoord is succesvol gewijzigd');

			// Redirect
			redirect('dashboard');
		}
		else
		{
			// Get user information
			$data = $this->db->get_where('users',['user_id' => user('user_id')])->row_array();

			// Set view data
			$data['page'] 		= 'profile/password';
			$data['page_title']	= 'Wachtwoord wijzigen';
			$data['page_descr']	= 'Wachtwoord wijzigen';

			// Load view
			$this->load->view('layout',$data);	
		}

	}

	// Valid login credentials?
	public function _login_check()
	{
		// Check credentials in the database
		$correct = $this->db->get_where('users',[
			'user_id' 	=> user('user_id'),
			'password'	=> sha1($this->input->post('password').config_item('encryption_key'))
		])->num_rows();

		// Match?
		if($correct)
		{
			// Return TRUE
			return TRUE;
		}

		// Set message and return FALSE
		$this->form_validation->set_message('_login_check', 'Het ingevoerde wachtwoord is niet juist');
		return FALSE;
	}

	// Unique one excepts what it was?
	public function _is_unique_excepts($value)
	{
		// Get users email address
		$current = $this->db->get_where('users',['user_id' => user('user_id')])->row()->email;

		// Search for email address
		$data = $this->db->get_where('users',['email' => $value])->row();

		// Nothing found or the same?
		if(empty($data) OR $current == $data->email)
		{
			// Return TRUE
			return TRUE;
		}

		// Set message and return FALSE
		$this->form_validation->set_message('_is_unique_excepts', 'Dit %s bestaat al');
		return FALSE;
	}

	// Valid date?
	public function _check_date($date)
	{
		// Make it NOT required
		if($date == '')
		{
			return TRUE;
		}

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

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */