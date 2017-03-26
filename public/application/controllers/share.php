<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Share extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Load car model
		$this->load->model('cars_model');

		// Load image helper
		$this->load->helper('image');
	}

	public function index()
	{
		show_404();
	}

	public function update($update_id = 0,$hash = FALSE,$type = FALSE)
	{
		// No hash?
		if(!$hash){ show_404(); }

		// Get update
		$update = $this->db->get_where('updates',['update_id' => $update_id,'hash' => $hash])->row();

		// No update found?
		if(empty($update)){ show_404(); }

		// Image type?
		if($type == 'image')
		{
			// Set dimensions
			$width = 680;
			$h_counter = 30;

			// Set image header
			header("Content-Type: image/jpeg");

			// No cache
			header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

			// Create new image
			$image = imagecreatetruecolor($width,3000);

			// Background color
			$background = imagecolorallocate($image, 255, 255, 255);
			imagefill($image, 0, 0, $background);

			// Add title
			$h_counter += image_text($image,$width,20,5,$h_counter,'Update: '.$update->title,TRUE);

			// Update date
			image_text($image,$width,12,5,$h_counter,'Datum',TRUE);
			image_text($image,$width,12,150,$h_counter,date('d-m-Y',strtotime($update->date)));
			$h_counter += 40;

			// Description set?
			if($update->description)
			{
				// Add description
				$h_counter += image_text($image,$width,18,5,$h_counter,'Omschrijving',TRUE);
				$h_counter += image_text($image,$width,12,5,$h_counter,$update->description);
				$h_counter += 20;
			}

			// Get images
			$images = glob('img/updates/'.$update_id.'/*.*');

			// Images found?
			if(!empty($images))
			{
				// Add images
				$h_counter += image_text($image,$width,18,5,$h_counter,'Foto\'s',TRUE);

				// Set variables
				$w_counter 		= 5;
				$thumb_size 	= 225;
				$max_width 		= floor($width / $thumb_size) * $thumb_size - $thumb_size;
				$total_images 	= count($images) - 1;

				// Loop through images
				foreach($images as $num=>$merge_image)
				{
					// Get image from file
					$merge_image = imagecreatefromstring(file_get_contents(thumb($merge_image)));

					// Merge them
					imagecopy($image,$merge_image,$w_counter,$h_counter,0,0,imagesx($merge_image),imagesy($merge_image));

					// Last image?
					if($total_images != $num)
					{
						// Check if an "enter" is needed
						if($w_counter >= $max_width){
							$w_counter = 5;
							$h_counter += 225;
						} else {
							$w_counter += 225;
						}
					}
				}
				$h_counter += 255;
			}

			// Create image again with the right height
			$result = imagecreatetruecolor($width,$h_counter);
			imagecopy($result,$image,0,0,0,0,imagesx($image),imagesy($image));

			// Create jpeg
			imagejpeg($result,NULL,100);

			// Destroy image
			imagedestroy($image);
			imagedestroy($result);
		}
		else
		{
			// Show 404
			show_404();
		}
	}

	public function car($car_id = 0,$hash = FALSE,$type = FALSE)
	{
		// No hash?
		if(!$hash){ show_404(); }

		// Get car
		$car = $this->cars_model->get_car($car_id,$hash);

		// No car found?
		if(empty($car)){ show_404(); }

		// Image type?
		if($type == 'image')
		{
			// Set dimensions
			$width = 680;
			$h_counter = 30;

			// Set image header
			header("Content-Type: image/jpeg");

			// No cache
			header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

			// Create new image
			$image = imagecreatetruecolor($width,3000);

			// Background color
			$background = imagecolorallocate($image, 255, 255, 255);
			imagefill($image, 0, 0, $background);

			// Add title
			$h_counter += image_text($image,$width,20,5,$h_counter,$car->brand.' '.$car->model.' ('.$car->type.')',TRUE);

			// Add year
			image_text($image,$width,12,5,$h_counter,'Bouwjaar',TRUE);
			$h_counter += image_text($image,$width,12,150,$h_counter,$car->year);
			$h_counter += 10;

			// Add label
			image_text($image,$width,12,5,$h_counter,'Label',TRUE);
			$h_counter += image_text($image,$width,12,150,$h_counter,$car->label);
			$h_counter += 20;

			// Description set?
			if($car->description)
			{
				// Add description
				$h_counter += image_text($image,$width,18,5,$h_counter,'Omschrijving',TRUE);
				$h_counter += image_text($image,$width,12,5,$h_counter,$car->description);
				$h_counter += 20;
			}

			// Get images
			$images = glob('img/cars/'.$car->car_id.'/*.*');

			// Images found?
			if(!empty($images))
			{
				// Add images
				imagettftext($image, 18, 0, 5, $h_counter, imagecolorallocate($image,0,0,0), 'fonts/arialbd.ttf', 'Foto\'s');
				$h_counter 	+= 10;

				// Set variables
				$w_counter 		= 5;
				$thumb_size 	= 225;
				$max_width 		= floor($width / $thumb_size) * $thumb_size - $thumb_size;
				$total_images 	= count($images) - 1;

				// Loop through images
				foreach($images as $num=>$merge_image)
				{
					// Get image from file
					$merge_image = imagecreatefromstring(file_get_contents(thumb($merge_image)));

					// Merge them
					imagecopy($image,$merge_image,$w_counter,$h_counter,0,0,imagesx($merge_image),imagesy($merge_image));

					// Last image?
					if($total_images != $num)
					{
						// Check if an "enter" is needed
						if($w_counter >= $max_width){
							$w_counter = 5;
							$h_counter += 225;
						} else {
							$w_counter += 225;
						}
					}
				}
				$h_counter += 255;
			}

			// Specifications set?
			if($car->specs)
			{
				// Add specifications
				$h_counter += image_text($image,$width,18,5,$h_counter,'Specificaties',TRUE);

				// Explode specs by line
				$lines = explode("\n",$car->specs);

				// Loop through specs
				foreach($lines as $line)
				{
					// Category?
					if(substr($line,0,2) == '**')
					{
						// Add category
						$h_counter += image_text($image,$width,12,5,$h_counter + 5,substr($line,2),TRUE);
						$h_counter += 15;
					}
					else
					{
						// Add specification
						$h_counter += image_text($image,$width,12,10,$h_counter,$line);
						$h_counter += 5;
					}
				}
				$h_counter += 20;
			}

			// Get updates
			$updates = $this->db->order_by('date','desc')->get_where('updates',['car_id' => $car_id])->result();

			// Updates present?
			if(!empty($updates))
			{
				// Add updates
				$h_counter += image_text($image,$width,18,5,$h_counter,'Updates',TRUE);
				$h_counter += 10;

				// Loop through updates
				foreach($updates as $update)
				{
					// Add specification
					$h_counter += image_text($image,$width,12,5,$h_counter,date('d-m-Y',strtotime($update->date)).' - '.$update->title);
					$h_counter += 5;
				}
			}
			
			// Create image again with the right height
			$result = imagecreatetruecolor($width,$h_counter);
			imagecopy($result,$image,0,0,0,0,imagesx($image),imagesy($image));

			// Create jpeg
			imagejpeg($result,NULL,100);

			// Destroy image
			imagedestroy($image);
			imagedestroy($result);

		}
		else
		{
			// Show 404
			show_404();
		}
	}

}

/* End of file share.php */
/* Location: ./application/controllers/share.php */