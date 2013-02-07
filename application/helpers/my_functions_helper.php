<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

	if ( !function_exists('is_logged_in')){

		function is_logged_in(){

			$CI =& get_instance();

			$is_logged_in = $CI->session->userdata('logged_in');

            if($is_logged_in){

            	return $is_logged_in;

            }

            return FALSE;

		}
	}


/* End of file My_function_helpers.php */
/* Location: ./application/helpers/My_function_helpers.php */