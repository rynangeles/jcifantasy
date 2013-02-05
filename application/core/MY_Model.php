<?php

class My_model extends CI_Model{

	var $table = '';

        public function get_all_records(){
            
            $query = $this->db->get($this->table);
            
            if($query->num_rows() > 0){
            
                foreach($query->result() as $row){
            
                    $records[] = $row;
            
                }
            
                return $records;
            
            }
        
        }


      //   public function get_by_id($table, $id_col, $id){

      //       $this->db->where($id_col, $id);

      //       if(isset($table['join']) && is_array($table['join']) && !empty($table['join'])){

      //           foreach ($table['join'] as $joiningTable => $joiningKeys) {

      //               $joiningKey = explode(",", $joiningKeys);

      //               $this->db->join($joiningTable, $joiningKey[0]."=".$joiningKey[1]);

      //           }

      //       }

      //       $query = $this->db->get($table['table']);

            

      //       if($query->num_rows() > 0){

      //           foreach($query->result() as $row){

      //               $project[] = $row;

      //           }

      //           return $project;

      //       }

      //   }

      //   public function get_by_sql($sql){

      //       $query = $this->db->query($sql);
		   
		    // if($query->num_rows() > 0){

      //           foreach($query->result() as $row){

      //               $units[] = $row;

      //           }

      //           return $units;

      //       }else{

      //           return false;

      //       }

      //   }

      //   public function insert_record($table, $data){

      //       if($this->db->insert($table, $data)){

      //           return $this->db->insert_id();

      //       }else{

      //           return false;

      //       }

      //   }

      //   public function insert_batch_record($table, $data){
            
      //       if($this->db->insert_batch($table, $data)){

      //           return true;

      //       }else{

      //           return false;

      //       }
      //   }

        

      //   public function update_record($table, $id_col, $id, $data){

      //       $this->db->where($id_col, $id);

      //       if($this->db->update($table, $data)){

      //           return $id;

      //       }else{

      //           false;

      //       }

      //   }

      //   public function update_batch_record($table, $data, $where_key){
      //       $this->db->trans_start();
      //       $this->db->update_batch($table, $data, $where_key);
      //       $this->db->trans_complete();

      //       if ($this->db->trans_status() === FALSE){
      //            return false;
      //       }else{
      //           return true;
      //       } 
      //   }

      //   public function delete_record($table, $id_col, $id){

      //       $this->db->where($id_col, $id);

      //       if($this->db->delete($table)){

      //           return true;

      //       }else{

      //           return false;

      //       }

      //   }

    } 

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */