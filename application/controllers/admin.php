<?php 

	class Admin extends My_controller{

        public function index(){
        	$data = array();
            $data['page_id']        = 'admin'; // <body id="$page_id">
            $data['javascripts']    = array(); // javascripts to load
            $data['stylesheets']    = array('admin');  // stylesheets to load

            $this->load->model('team_model');

            $data['teams'] = $this->team_model->get_all_records();

            $data['content'] = 'admin/home'; // view to load
            $this->load->view('includes/base', $data);
		}

        private function validate_credential(){

            $validate = $this->user_model->validate();

            if(isset($validate) && $validate != FALSE){
                
                $data = array('user_id' => $validate['id'], 'logged_in' => TRUE);

                $this->session->set_userdata($data);

                return TRUE;
            }

            return FALSE;
        }

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	