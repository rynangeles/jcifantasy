<?php

	class User_model extends My_model{

		//extends CRUD model

		var $table 			= 'user';
		var $primary_key 	= 'id';


		function validate(){

			$this->db->where('username', $this->input->post('username'));
			$this->db->where('password', md5($this->input->post('password')));
			$query = $this->db->get('user');

			if($query->num_rows() == 1){

				return array_shift($query->result_array());
			}

			return FALSE;

		}

		public function get_all_active(){

			$this->db->where(array('active' => 1, 'deleted' => 0));

			$query = $this->db->get($this->table);

			if($query->num_rows() > 0){

                  foreach($query->result() as $row){

                  $records[] = $row;

            }

            return $records;

            }

		}

		public function is_duplicate($value){

			$this->db->where('username', $value);

			$query = $this->db->get($this->table);

			if($query->num_rows() > 0){

                  return TRUE;

            }else{

            	return FALSE;

            }

		}
		

	}

/* End of file user_model.php */
/* Location: ./application/model/user_model.php */