<?php

	class Team_model extends My_model{

		//extends CRUD model

		var $table 				= 'team';
		var $primary_key 		= 'id';
		var $upload_path;

		function __construct(){

			parent::__construct();

			$this->upload_path = realpath(APPPATH . '../uploads/team');
		}

		public function do_upload($id){

			$config 					= array();
			$config['upload_path'] 		= $this->upload_path;
            $config['allowed_types'] 	= 'gif|jpg|jpeg|png';
            $config['max_size'] 		= '2000';
            $config['max_width']  		= '1024';
            $config['max_height']  		= '768';
            $config['file_name']		= 'team-' . $id . '-' . now();

            $this->load->library('upload', $config);

            $data = array();

            if ($this->upload->do_upload('team_logo')){

				$image_data = $this->upload->data();

                $data['status'] = TRUE;
                $data['data'] = $image_data;

                $config = array();

                /*==================
                    MAIN IMAGE
                ===================*/
                $config['source_image']       = $image_data['full_path'];
                $config['new_image']          = $this->upload_path . '/large-' . $image_data['file_name'];
                $config['maintain_ratio']     = TRUE;
                $config['width']              = 450;
                $config['height']             = 400;

                $this->load->library('image_lib', $config);
                
                if(!$this->image_lib->resize()){
                    
                    //$this->image_lib->display_errors();
                
                }

                $this->image_lib->clear();

                $config = array();

                /*====================
                    MAIN IMAGE THUMB 
                ======================*/
                $config['source_image']       = $image_data['full_path'];
                $config['new_image']          = $this->upload_path . '/thumb/thumb-' . $image_data['file_name'];
                $config['maintain_ratio']     = TRUE;
                $config['width']              = 150;
                $config['height']             = 100;

                $this->image_lib->initialize($config);

                if(!$this->image_lib->resize()){
                    
                    //$this->image_lib->display_errors();
                
                }

                if(file_exists($image_data['full_path'])){

                    unlink($image_data['full_path']);

                }

                return $data;

            }else{

                $error = $this->upload->display_errors('<span class="error errorInline">', '</span>');

                $data['status'] = false;
                $data['data'] = $error;

                return $data;
               
            }

		}

        public function get_all_records(){

            $this->db->select('*');
            $this->db->from('team');
            $this->db->join('team_queue', 'team_queue.team_id = team.id', 'left');
            $this->db->where(array('team.active'=>1));

            $query = $this->db->get();

            if($query->num_rows() > 0){
            
                foreach($query->result() as $row){
            
                    $records[] = $row;
            
                }
            
                return $records;
            
            }
            
        }

		public function get_all_available_manager(){

			$this->db->select('user.id as manager_id, user.first_name as manager_firstname, user.last_name as manager_lastname');
            $this->db->from('user');
            $this->db->join('team', 'team.manager_id = user.id', 'left');
            $this->db->where(array('team.manager_id'=>null,'user.active'=>1));

            $query = $this->db->get();

			if($query->num_rows() > 0){
            
                foreach($query->result() as $row){
            
                    $records[] = $row;
            
                }
            
                return $records;
            
            }

		}

		public function get_team_last_id(){

			$query = $this->db->get($this->table);

			$last = $query->last_row('array');

			return isset($last['id']) ? $last['id'] : 0;

		}

        public function all_unqueued_teams(){

            $this->db->select('*');
            $this->db->from('team');
            $this->db->join('team_queue', 'team_queue.team_id = team.id', 'left');
            $this->db->where(array('team.active'=>1, 'team_queue.queue'=>0));

            $query = $this->db->get();

            if($query->num_rows() > 0){
            
                foreach($query->result() as $row){
            
                    $records[] = $row;
            
                }
            
                return $records;
            
            }

        }

        public function last_queue(){

            $this->db->select_max('queue');

            $query = $this->db->get('team_queue');

            if($query->num_rows() == 1){

                return array_shift($query->result_array());
            }

            return FALSE;
        }

	}

/* End of file team_model.php */
/* Location: ./application/model/team_model.php */