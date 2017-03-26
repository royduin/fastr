<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

    public function show_404($page = '', $log_error = TRUE)
    {
    	// By default we log this, but allow a dev to skip it
		if ($log_error)
		{
			log_message('error', '404 Page Not Found --> '.$page);
		}
		
        $CI =& get_instance();
        $CI->output->set_status_header('404');
        $data['page']           = '404';
        $data['page_title']     = 'Pagina niet gevonden';
        $data['page_descr']     = 'Pagina niet gevonden';
        $CI->load->view('layout',$data);
        echo $CI->output->get_output();
        exit;
    }
}

/* End of file MY_Exceptions.php */
/* Location: ./application/core/MY_Exceptions.php */