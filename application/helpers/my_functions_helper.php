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
						'user'=>'user','team'=>'team','player'=>'player','team/draw_lot'=>'draw lots', 'admin/randomize'=>'RANDOMIZE !'),
					2=>array('team/players'=>'player','drafting'=>'draft')
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

			$position = array(0=>'NA',1=>'PG',2=>'SG',3=>'SF',4=>'PF',5=>'C');
		
			return $position[$position_id];
		}
	}

	if( !function_exists('get_team_players')){

		function get_team_players($team_id){

			$CI =& get_instance();

			$CI->db->select('*');
            $CI->db->from('team_players');
            $CI->db->join('player', 'player.id = team_players.player_id', 'left outer');
            $CI->db->where(array('team_players.team_id'=>$team_id));

            $query = $CI->db->get();

            if($query->num_rows() > 0){

                foreach($query->result() as $row){
            
                    $records[] = $row;
            
                }

                $html = '<ul>';

                foreach ($records as $record) {

                	$name = isset($record->first_name) ? ucfirst($record->first_name) . ' ' . ucfirst($record->last_name) : 'PASS';

                	$html .= '<li';
                	$html .= team_player_last_id() == $record->id ? ' class="latest"' : '';
                	$html .= '>' . $record->seed . ' ' . $name . '</li>';

                }

                $html .= '</ul>';

                return $html;

            }

		}

	}

	if(!function_exists('team_player_last_id')){

		function team_player_last_id(){

			$CI =& get_instance();

			$query = $CI->db->query('SELECT a.* FROM team_players as a WHERE id = (SELECT MAX(b.id) FROM team_players as b)');

            if($query->num_rows() == 1){

                foreach($query->result() as $row){
            
                    $records[] = $row;
            
                }

                $player = array_shift($records);

                return $player->player_id;
            
            }

		}

	}

	if( !function_exists('is_drafted')){

		function is_drafted($player_id){

			$CI =& get_instance();

			$CI->db->select('player_id');
			$CI->db->where('player_id', $player_id);

			$query = $CI->db->get('team_players');

			if($query->num_rows() > 0){

				return TRUE;

			}else{

				echo FALSE; //$CI->db->last_query();
				
			}

		}
	}

	if( !function_exists('is_queue')){

		function is_queue($manager_id){

			$CI =& get_instance();

			$CI->db->select('team.id as team_id, team.manager_id, team_queue.team_id as queue_team_id, team_queue.turn');
            $CI->db->from('team');
            $CI->db->join('team_queue', 'team_queue.team_id = team.id', 'left');
			$CI->db->where('team.manager_id', $manager_id);

			$query = $CI->db->get();

			$record = '';
			if($query->num_rows() == 1){

                foreach($query->result() as $row){
            
                    $records[] = $row;
            
                }

                $record = array_shift($records);

            	if($record->turn == 1){

	            	return TRUE;

	            }else{

	            	return FALSE;

	            }

            }else{

            	return FALSE;

            }
            
		}
		
	}



	
/* End of file My_function_helpers.php */
/* Location: ./application/helpers/My_function_helpers.php */