<?php

	class Player_model extends My_model{

		//extends CRUD model

		var $table 			= 'player';
		var $primary_key 	= 'id';


		public function get_all_active(){

			$this->db->where('active', 1);

			$query = $this->db->get($this->table);

			if($query->num_rows() > 0){

				foreach($query->result() as $row){

					$records[] = $row;

            	}

            return $records;

            }

		}

		public function get_team_players($team_id){

			$this->db->select('*');
            $this->db->from('team_players');
            $this->db->join('player', 'player.id = team_players.player_id', 'left');
            $this->db->where(array('player.active'=>1, 'team_players.team_id'=>$team_id));

            $query = $this->db->get();

            if($query->num_rows() > 0){

                foreach($query->result() as $row){
            
                    $records[] = $row;
            
                }
                
                return $records;
            }

            return FALSE;

		}

		public function get_available_players(){

            $query = $this->db->query('SELECT * FROM player as p WHERE p.id NOT IN (SELECT tp.player_id FROM team_players as tp)');
		   
		    if($query->num_rows() > 0){

                foreach($query->result() as $row){
            
                    $records[] = $row;
            
                }
                
                return $records;
            }

            return FALSE;

        }
		

	}

/* End of file player_model.php */
/* Location: ./application/model/player_model.php */