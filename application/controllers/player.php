<?php 

	class Player extends My_controller{

        function __construct(){

            parent::__construct();

            if($this->user_type != 1){

                redirect('admin');
                

            }

            $this->load->library('form_validation');

            $this->load->model('player_model');

        }

        public function index(){

            $data = array();
            $data['page_id']        = 'player'; // <body id="$page_id">
            $data['javascripts']    = array(); // javascripts to load
            $data['stylesheets']    = array('player');  // stylesheets to load
            $data['players']        = $this->get_players();

            $success_message        = $this->session->flashdata('success_message');

            if(isset($success_message)){

                $data['success_message'] = $success_message;
                
            }

            $data['content'] = 'admin/player/player'; // view to load
            $this->load->view('includes/base', $data);

        }

        public function create(){

            $data = array();
            $data['page_id']            = 'player-create'; // <body id="$page_id">
            $data['javascripts']        = array(); // javascripts to load
            $data['stylesheets']        = array('player');  // stylesheets to load
            $data['content']            = 'admin/player/create'; // view to load

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

		private function get_players(){

            if($this->player_model->get_all_active()){

                return $this->player_model->get_all_active();

            }
            
        }

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	