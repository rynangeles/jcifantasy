<?php 

	class Login extends CI_Controller{

		function __construct(){

            parent::__construct();

            if(is_logged_in()){ 
                
                redirect('admin'); 
            
            }

        }

        public function index(){

        	$data = array();
            $data['page_id']        = 'login'; // <body id="$page_id">
            $data['javascripts']    = array(); // javascripts to load
            $data['stylesheets']    = array('login');  // stylesheets to load
            $data['content']        = 'frontend/login'; // view to load

            if($this->input->post('submit')){

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="error inputError">', '</span>');

                //field name, error message, rules
                $this->form_validation->set_rules('username', 'Username', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE){

                }else{

                    $validate = $this->validate_credential();

                    if($validate == FALSE){ 

                        $data['invalid_login'] = 'Your username/password combination incorrect.';

                    }else{
                        
                        $this->do_login($validate);
                    
                    }

                }

            }else{

                $logout_message         = $this->session->flashdata('logout_message');
                $not_loggedin_message   = $this->session->flashdata('not_loggedin');
                $inactive_message       = $this->session->flashdata('inactive_message');

                if($inactive_message){

                    $data['inactive_message'] = $inactive_message;

                }

                if($logout_message){

                    $data['logout_message'] = $logout_message;

                }
                
                if($not_loggedin_message){

                    $data['not_loggedin_message'] = $not_loggedin_message;

                }

            }
                
            $this->load->view('includes/base', $data);
            
		}

        public function do_login($data){

            if($data['is_active']){

                $last_login = array( 'last_login' => date('Y-m-d H:i:s') );

                // update last login on this user
                $updated_id = $this->user_model->update_record($data['user_id'], $last_login);

                if($updated_id){

                    $this->session->set_userdata($data);

                    redirect('admin');

                }else{

                    redirect('login');

                } 

            }else{

                $this->session->set_flashdata('inactive_message', 'This user is inactive');

                redirect('login');
            }

        }

        private function validate_credential(){

            $validate = $this->user_model->validate();

            if(isset($validate) && $validate != FALSE){

                $data = array('user_id' => $validate['id'], 'user_type' => $validate['type'], 'is_active' => TRUE, 'logged_in' => TRUE);

                if($validate['active'] == 0){

                    $data['is_active'] = FALSE;

                }

                return $data;

            }else{

                return FALSE;

            }
        }

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	