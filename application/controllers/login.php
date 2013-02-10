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

            if($this->input->post('submit')){

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="error inputError">', '</span>');

                //field name, error message, rules
                $this->form_validation->set_rules('username', 'Username', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE){

                }else{

                    if($this->validate_credential()){ 

                        if(is_logged_in()){ 

                            redirect('admin'); 

                        }

                    }else{

                        $data['invalid_login'] = 'Your username/password combination incorrect.';
                    
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

                $data['content'] = 'frontend/login'; // view to load
                $this->load->view('includes/base', $data);

            }
            
		}

        private function validate_credential(){

            $validate = $this->user_model->validate();

            if(isset($validate) && $validate != FALSE){

                if($validate['active'] == 0){

                    $this->session->set_flashdata('inactive_message', 'This user is inactive');

                    redirect('login');

                    return FALSE;

                }else{
                
                    $data = array('user_id' => $validate['id'], 'user_type' => $validate['type'], 'logged_in' => TRUE);

                    $this->session->set_userdata($data);

                    return TRUE;
                }
            }

            return FALSE;
        }

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	