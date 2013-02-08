<?php 

	class Team extends My_controller{

        public function index(){

            if($this->user_type != 1){

                redirect('admin');

            }else{

                $data = array();
                $data['page_id']        = 'team'; // <body id="$page_id">
                $data['javascripts']    = array(); // javascripts to load
                $data['stylesheets']    = array();  // stylesheets to load
                $data['menus']          = $this->user_menu[$this->user_type]; //user menus My_controller
                $data['users']          = $this->get_users();

                $data['content'] = 'admin/team/team'; // view to load
                $this->load->view('includes/base', $data);

            }

            
        }

		private function get_users(){
            if($this->user_model->get_all_records()){
                return $this->user_model->get_all_records();
            }
        }

	}

/* End of file team.php */
/* Location: ./application/controller/team.php */
	