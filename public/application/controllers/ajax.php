<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Ajax call?
		if( ! $this->input->is_ajax_request() )
		{
			// Show 404
			show_404();
		}
	}

	public function comment()
	{
		// Comment set?
		if($this->input->post('comment'))
		{
			// Update in the database
			$this->db->update('comments',['comment' => $this->input->post('comment')],['comment_id' => $this->input->post('id'),'user_id' => user('user_id')]);

			// Echo something
			echo json_encode(['succes' => true]);
		}
	}

	public function brands()
	{
		// Get all brands
		$data = $this->db->get('brands')->result_array();

		// Get just the name
		$data = array_map(function($array) { return $array['brand_name']; }, $data);

		// Echo as JSON
		echo json_encode($data);
	}

	public function models()
	{
		// Set array
		$data = [];

		// Get brand
		$brand = $this->db->get_where('brands',[
			'brand_name' => $this->input->post('brand')
		])->row();

		// Found?
		if(isset($brand->brand_id))
		{
			// Get models
			$data = $this->db->get_where('models',[
				'brand_id' => $brand->brand_id
			])->result_array();

			// Get just the name
			$data = array_map(function($array) { return $array['model_name']; }, $data);
		}

		// Echo as JSON
		echo json_encode($data);
	}

	public function types()
	{
		// Set array
		$data = [];

		// Get model
		$model = $this->db->get_where('models',[
			'model_name' => $this->input->post('model')
		])->row();

		// Found?
		if(isset($model->model_id))
		{
			// Get models
			$data = $this->db->get_where('types',[
				'model_id' => $model->model_id
			])->result_array();

			// Get just the name
			$data = array_map(function($array) { return $array['type_name']; }, $data);
		}

		// Echo as JSON
		echo json_encode($data);
	}

}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */
