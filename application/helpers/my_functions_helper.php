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

	if ( !function_exists('get_user_type')){

		function get_user_type($type_id){

			$user_type = array(1=>'ADMIN',2=>'TEAM MANAGER');// add if user type value here

			return $user_type[$type_id];

		}
	}


/* End of file My_function_helpers.php */
/* Location: ./application/helpers/My_function_helpers.php */