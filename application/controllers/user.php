<?php 

	class User extends My_controller{

        public function index(){

            if($this->user_type != 1){

                redirect('admin');

            }else{

                $data = array();
                $data['page_id']        = 'user'; // <body id="$page_id">
                $data['javascripts']    = array(); // javascripts to load
                $data['stylesheets']    = array('user');  // stylesheets to load
                $data['users']          = $this->get_users();

                $data['content'] = 'admin/user/user'; // view to load
                $this->load->view('includes/base', $data);

            }

            
        }

		private function get_users(){
            if($this->user_model->get_all_records()){
                return $this->user_model->get_all_records();
            }
        }

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	