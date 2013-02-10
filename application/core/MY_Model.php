<?php

class My_model extends CI_Model{

	var $table = '';
      var $primary_key  = '';

      public function get_all_records(){

            $query = $this->db->get($this->table);

            if($query->num_rows() > 0){

                  foreach($query->result() as $row){

                  $records[] = $row;

            }

            return $records;

            }

      }

      public function insert_record($data){

            if($this->db->insert($this->table, $data)){

                  return $this->db->insert_id();

            }else{

                  return false;

            }

      }


      public function get_by_id($id){

            $this->db->where($this->primary_key , $id);

            
            $query = $this->db->get($this->table);



            if($query->num_rows() > 0){

                  foreach($query->result() as $row){

                        $records[] = $row;

                  }

            return $records;

            }

      }

      public function update_record($id, $data){

            $this->db->where($this->primary_key, $id);

            if($this->db->update($this->table, $data)){

                  return $id;

            }else{

             return FALSE;

            }

      }

      public function delete_record($id){

            $this->db->where($this->primary_key, $id);

            if($this->db->delete($this->table)){

                  return TRUE;

            }else{

                  return FALSE;

            }

      }


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

      

      //   public function insert_batch_record($table, $data){
            
      //       if($this->db->insert_batch($table, $data)){

      //           return true;

      //       }else{

      //           return false;

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

      

    } 

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */