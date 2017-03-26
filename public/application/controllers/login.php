<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
		// TODO, add callback for login check!
		$this->form_validation->set_rules('username', 'gebruikersnaam', 'required|callback__login_check');
		$this->form_validation->set_rules('password', 'wachtwoord', 'required');
	}

	public function index()
	{
		// Validation successful?
		if ($this->form_validation->run())
		{
			// Get credentials
			$user = $this->db->get_where('users',[
				'username' 	=> $this->input->post('username'),
			])->row();

			// Set sessions
			$this->session->set_userdata('user_id', $user->user_id);
			$this->session->set_userdata('username', $this->input->post('username'));
			$this->session->set_userdata('email', $user->email);

			// Set message
			$this->session->set_flashdata('message','Je bent succesvol ingelogd, welkom terug!');

			// Redirect
			redirect('dashboard');
		}
		else
		{
			// Set view information
			$data['page'] 		= 'login/login';
			$data['page_title']	= 'Inloggen bij '.config_item('website_name');
			$data['page_descr'] = 'Inloggen bij '.config_item('website_name');

			// Load view
			$this->load->view('layout',$data);
		}
	}

	public function _login_check()
	{
		$correct = $this->db->get_where('users',[
			'username' 	=> $this->input->post('username'),
			'password'	=> sha1($this->input->post('password').config_item('encryption_key'))
		])->num_rows();

		if($correct)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('_login_check', 'De ingevoerde gegevens komen niet overeen');
			return FALSE;
		}
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */