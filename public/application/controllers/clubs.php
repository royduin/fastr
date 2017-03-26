<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clubs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// Get all clubs
		$data['clubs'] = $this->db->get('clubs')->result();

		// Set view data
		$data['page'] 		= 'clubs/clubs';
		$data['page_title']	= 'Alle Nederlandse auto clubs';
		$data['page_descr']	= 'Alle Nederlandse auto clubs';

		// Load view
		$this->load->view('layout',$data);	
	}

	public function club($id = 0,$name = FALSE)
	{
		// Get club
		$data = $this->db->get_where('clubs',['club_id' => $id])->row_array();

		// No club found?
		if(empty($data)){ show_404(); }

		// No name or not the right one?
		if(!$name OR $name != url_title(e($data['name']))){ redirect('clubs/'.$id.'/'.url_title(e($data['name']))); }

		// Set view data
		$data['logo'] 		= isset(glob('img/clubs/'.$id.'/logo.*')[0]) ? glob('img/clubs/'.$id.'/logo.*')[0] : 'img/geen-foto.png';
		$data['member']		= $this->db->get_where('users_clubs',['user_id' => user('user_id'),'club_id' => $id])->num_rows();
		$data['members']	= $this->db->select('users.user_id,username')->join('users','users.user_id = users_clubs.user_id')->get_where('users_clubs',['club_id' => $id])->result();
		$data['page'] 		= 'clubs/club';
		$data['page_title']	= $data['name'].' op '.site_name();
		$data['page_descr']	= $data['name'].' op '.site_name();

		// Load view
		$this->load->view('layout',$data);
	}

}

/* End of file clubs.php */
/* Location: ./application/controllers/clubs.php */