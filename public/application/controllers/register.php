<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Logged in?
		if( logged_in() )
		{
			// Redirect
			redirect('dashboard');
		}

		// Load form validation
		$this->load->library('form_validation');

		// Remove delimiters
		$this->form_validation->set_error_delimiters('', '');

		// Form rules
		$this->form_validation->set_rules('username', 'gebruikersnaam', 'required|is_unique[users.username]|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('email', 'email adres', 'required|is_unique[users.email]|max_length[255]|valid_email');
		$this->form_validation->set_rules('password', 'wachtwoord', 'required|matches[password2]');
		$this->form_validation->set_rules('password2', 'wachtwoord herhalen', 'required');
	}

	public function index()
	{
		// Validation successful?
		if ($this->form_validation->run())
		{
			// Insert into the database
			$this->db->insert('users',[
				'username' 	=> $this->input->post('username'),
				'email'		=> $this->input->post('email'),
				'password' 	=> sha1($this->input->post('password').config_item('encryption_key'))
			]);

			// Set sessions
			$this->session->set_userdata('user_id', $this->db->insert_id());
			$this->session->set_userdata('username', $this->input->post('username'));
			$this->session->set_userdata('email', $this->input->post('email'));

			// Set message
			$this->session->set_flashdata('message','Welkom bij '.site_name().' en bedankt voor het aanmaken van een account!');

			// Redirect
			redirect('dashboard');
		}
		else
		{
			// Set view information
			$data['page'] 		= 'login/register';
			$data['page_title']	= 'Registreren bij '.config_item('website_name');
			$data['page_descr'] = 'Registreer je gratis bij '.config_item('website_name').' en maak je eigen auto profiel';

			// Load view
			$this->load->view('layout',$data);
		}
	}

}

/* End of file register.php */
/* Location: ./application/controllers/register.php */