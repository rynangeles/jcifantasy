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
		

	}

/* End of file user_model.php */
/* Location: ./application/model/user_model.php */