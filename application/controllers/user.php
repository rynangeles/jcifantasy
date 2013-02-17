<?php 

	class User extends My_controller{

        function __construct(){

            parent::__construct();

            if($this->user_type != 1){

                redirect('admin');
                

            }

            $this->load->library('form_validation');

        }

        public function index(){

            $data = array();
            $data['page_id']        = 'user'; // <body id="$page_id">
            $data['javascripts']    = array(); // javascripts to load
            $data['stylesheets']    = array('user');  // stylesheets to load
            $data['users']          = $this->get_users();

            if($this->session->flashdata('success_message')){

                $data['success_message'] = $this->session->flashdata('success_message');

            }

            $data['content'] = 'admin/user/user'; // view to load
            $this->load->view('includes/base', $data);

            
        }

        public function create(){

            $data = array();
            $data['page_id']            = 'user-create'; // <body id="$page_id">
            $data['javascripts']        = array(); // javascripts to load
            $data['stylesheets']        = array('user');  // stylesheets to load
            $data['content']            = 'admin/user/create'; // view to load

            if($this->input->post('submit')){

                $this->form_validation->set_error_delimiters('<span class="error errorInline">', '</span>');
                $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user.username]|xss_clean');
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]|xss_clean');
                $this->form_validation->set_message('is_natural_no_zero', 'Please select a user type', 'usertype|xss_clean');
                $this->form_validation->set_rules('usertype', 'User Type', 'trim|required|is_natural_no_zero|xss_clean');
                
                if ($this->form_validation->run() == FALSE){

                    $data['error']      = TRUE;
                    $data['type']       = $this->input->post('usertype');
                    $data['status']     = $this->input->post('status');
                
                }else{                  

                    $data = array(
                            'username'      => $this->input->post('username'),
                            'first_name'    => $this->input->post('first_name'),
                            'last_name'     => $this->input->post('last_name'),
                            'email'         => $this->input->post('email'),
                            'password'      => md5($this->input->post('password')),
                            'type'          => $this->input->post('usertype'),
                            'created'       => date('Y-m-d H:i:s'),
                            'active'        => $this->input->post('status')
                        );

                    $inserted_id = $this->user_model->insert_record($data);

                    $data['success'] = TRUE;

                    $this->session->set_flashdata('success_message', 'User saving successful.');

                    redirect('user');

                }

                $this->load->view('includes/base', $data);

            }else{

                $this->load->view('includes/base', $data);

            }
                    

        }

        public function edit(){

            $data = array();
            $data['page_id']            = 'user-edit'; // <body id="$page_id">
            $data['javascripts']        = array(); // javascripts to load
            $data['stylesheets']        = array('user');  // stylesheets to load

            $id = $this->uri->segment(3);

            $defaults = $this->user_model->get_by_id($id);

            $defaults = array_shift($defaults);

            $data['default']            = $defaults;
            $data['type']               = $defaults->type;
            $data['status']             = $defaults->active;
            $data['content']            = 'admin/user/edit'; // view to load

            if($this->input->post('submit')){

                $this->form_validation->set_error_delimiters('<span class="error errorInline">', '</span>');
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
                $this->form_validation->set_message('is_natural_no_zero', 'Please select a user type', 'usertype|xss_clean');
                $this->form_validation->set_rules('usertype', 'User Type', 'trim|required|is_natural_no_zero|xss_clean');
                
                if($defaults->username != $this->input->post('username')){

                    $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|callback_username_check'); 
                
                }
                
                if($this->input->post('change_pass')){

                    $data['change_pass'] = $this->input->post('change_pass');
                    $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|callback_password_check');
                    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]|xss_clean');

                }
                
                if ($this->form_validation->run() == FALSE){

                    $data['error']      = TRUE;
                    $data['type']       = $this->input->post('usertype');
                    $data['status']     = $this->input->post('status');
                
                }else{                  

                    $data = array(
                            'username'      => $this->input->post('username'),
                            'first_name'    => $this->input->post('first_name'),
                            'last_name'     => $this->input->post('last_name'),
                            'email'         => $this->input->post('email'),
                            'type'          => $this->input->post('usertype'),
                            'created'       => date('Y-m-d H:i:s'),
                            'active'        => $this->input->post('status')
                        );

                
                    if($this->input->post('change_pass')){

                        $data['password'] = md5($this->input->post('password'));

                    }

                    $updated_id = $this->user_model->update_record($id, $data);

                    if($updated_id){

                        $data['success'] = TRUE;

                        $this->session->set_flashdata('success_message', 'User update successful.');

                        redirect('user');

                    }

                }

                $this->load->view('includes/base', $data);

            }else{

                $this->load->view('includes/base', $data);

            }
                    

        }

        public function delete(){

            $id = $this->uri->segment(3);

            $data = array( 'deleted' => 1 );

            $deleted_id = $this->user_model->update_record($id, $data);

            if($deleted_id){

                $this->session->set_flashdata('success_message', 'User successfully deleted.');

                redirect('user');

            }else{

                $this->session->set_flashdata('success_message', 'User deletion failed.');

            }
        }

        public function password_check($str){

            $id = $this->uri->segment(3);

            $defaults = $this->user_model->get_by_id($id);

            $defaults = array_shift($defaults);

            if(md5($str) != $defaults->password){

                $this->form_validation->set_message('password_check', 'Old password incorrect.');
                return FALSE;
                
            }else{

                return TRUE;
            }
        }

        public function username_check($str){

            $is_duplicate = $this->check_usernames($str);

            if ($is_duplicate){

                $this->form_validation->set_message('username_check', 'The %s field should be unique. This %s already taken.');
                return FALSE;

            }else{

                return TRUE;
            }
        }

        private function check_usernames($value){

            if($this->user_model->is_duplicate($value)){

                return $this->user_model->is_duplicate($value);

            }

        }

		private function get_users(){

            if($this->user_model->get_all_active()){

                return $this->user_model->get_all_active();

            }
            
        }

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	