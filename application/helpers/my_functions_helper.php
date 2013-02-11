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

	if ( !function_exists('get_menus')){

		function get_menus(){

			$CI =& get_instance();

            $user_type = $CI->session->userdata('user_type');

			$user_menu = array(
					1=>array(
						'user'=>'user','team'=>'team','player'=>'player','team/draw_lot'=>'draw lots'),
					2=>array('player'=>'player','draft'=>'draft')
				);

			return $user_menu[$user_type];

		}

	}

	if( !function_exists('get_manager_name')){

		function get_manager_name($manager_id){

			$CI =& get_instance();

			$CI->db->where('id', $manager_id);

			$query = $CI->db->get('user');

			$manager = array_shift($query->result_array());

			return ucfirst($manager['first_name']) . ' ' .ucfirst($manager['last_name']);
		}

	}

	if( !function_exists('get_status')){

		function get_status($status){

			$active = array(0=>'Inactive',1=>'Active');
		
			return $active[$status];
		}
	}

	if( !function_exists('readable_position')){

		function readable_position($position_id){

			$position = array(1=>'PG',2=>'SG',3=>'SF',4=>'PF',5=>'C');
		
			return $position[$position_id];
		}
	}

	
/* End of file My_function_helpers.php */
/* Location: ./application/helpers/My_function_helpers.php */