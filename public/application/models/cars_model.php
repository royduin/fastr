<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cars_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_car_search($filters = FALSE)
	{
		if(isset($filters['brand']) AND $filters['brand']){
			$where[] = 'brand_name = '.$this->db->escape($filters['brand']);
		}

		if(isset($filters['model']) AND $filters['model']){
			$where[] = 'model_name = '.$this->db->escape($filters['model']);
		}

		if(isset($filters['type']) AND $filters['type']){
			$where[] = 'type_name = '.$this->db->escape($filters['type']);
		}

		if(isset($filters['year']) AND $filters['year']){
			$where[] = 'year = '.$this->db->escape($filters['year']);
		}

		if(isset($filters['color']) AND $filters['color']){
			$where[] = 'colors.color = '.$this->db->escape($filters['color']);
		}

		if(isset($filters['club']) AND $filters['club']){
			$where[] = 'clubs.name = '.$this->db->escape($filters['club']);
		}

		if(isset($filters['specs']) AND $filters['specs']){
			$where[] = 'specs LIKE "%'.$this->db->escape_like_str($filters['specs']).'%"';
		}

		// The query
		$query = $this->db->query('
		SELECT
			cars.user_id,
			users.username,
			car_id,
			label,
			year,
			cars.description,
			specs,
			image_default,
			IFNULL(brand_name,"Onbekend") as brand,
			IFNULL(model_name,"Onbekend") as model,
			IFNULL(type_name,"Onbekend") as type
		FROM cars
		LEFT JOIN brands ON brand_id = brand
		LEFT JOIN models ON model_id = model
		LEFT JOIN types ON type_id = type
		LEFT JOIN users ON cars.user_id = users.user_id
		LEFT JOIN colors ON cars.color = colors.color_id
		LEFT JOIN users_clubs ON users_clubs.user_id = cars.user_id
		LEFT JOIN clubs ON users_clubs.club_id = clubs.club_id
		'.(isset($where) ? 'WHERE '.implode("\nAND ",$where) : ''));

		return $query->result();
	}

	public function get_car($id = FALSE,$hash = FALSE,$user = FALSE)
	{
		// The query
		$query = $this->db->query('
		SELECT
			cars.car_id,
			cars.user_id,
			username,
			label,
			year,
			colors.color_id,
			colors.color,
			cars.description,
			specs,
			image_default,
			hash,
			IFNULL(brand_name,"Onbekend") as brand,
			IFNULL(model_name,"Onbekend") as model,
			IFNULL(type_name,"Onbekend") as type,
			following.car_id as following
		FROM cars
		LEFT JOIN brands ON brand_id = brand
		LEFT JOIN models ON model_id = model
		LEFT JOIN types ON type_id = type
		LEFT JOIN users ON cars.user_id = users.user_id
		LEFT JOIN colors ON cars.color = colors.color_id
		LEFT JOIN following ON cars.car_id = following.car_id
		'.($id !== FALSE ? 'WHERE cars.car_id = '.$this->db->escape( $id ) : '').'
		'.($hash !== FALSE ? 'AND hash = '.$this->db->escape( $hash ) : '').'
		'.($user !== FALSE ? 'WHERE cars.user_id = '.$this->db->escape( $user ) : '').'
		');

		// ID set?
		if($id AND !$hash)
		{
			// Return array of the first result
			return $query->row_array();
		}
		elseif($hash)
		{
			// Return object of the first result
			return $query->row();
		}
		else
		{
			// Return object
			return $query->result();
		}
	}

	public function get_insert($type,$previous = FALSE)
	{
		// Select
		$item = $this->db->get_where($type.'s',[
			$type.'_name' => $this->input->post($type)
		])->row();

		// Set the field name
		$id = $type.'_id';

		// Exists?
		if(isset($item->$id))
		{
			// Set ID
			return $item->$id;
		}
		else
		{
			if($previous)
			{
				// Insert new
				$this->db->insert($type.'s',[
					array_keys($previous)[0] 	=> $previous[ array_keys($previous)[0] ],
					$type.'_name' 				=> $this->input->post($type)
				]);
			}
			else
			{
				// Insert new
				$this->db->insert($type.'s',[
					$type.'_name' => $this->input->post($type)
				]);
			}

			// Set ID
			return $this->db->insert_id();
		}
	}

}

/* End of file cars_model.php */
/* Location: ./application/models/cars_model.php */