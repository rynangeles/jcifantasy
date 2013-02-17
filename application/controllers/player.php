<?php 

	class Player extends My_controller{

        var $manager    = 0;
        var $team       = 0;

        function __construct(){

            parent::__construct();

            // if($this->user_type != 1){

            //     redirect('admin');

            // }

            $this->manager  = $this->session->userdata('user_id');

            $this->load->library('form_validation');

            $this->load->model('team_model');
            $this->load->model('player_model');

            if($this->team($this->manager)){

                $team = $this->team($this->manager);

                $this->team = $team->id;

            }

        }

        public function index(){

            $data = array();
            $data['page_id']        = 'player'; // <body id="$page_id">
            $data['javascripts']    = array(); // javascripts to load
            $data['stylesheets']    = array('player');  // stylesheets to load

            if($this->user_type == 1){

                $data['players']        = $this->get_players();

            }else{

                $data['players']        = $this->team_players($this->team);

            }

            $data['user_type']      = $this->user_type;

            $data['players_option'] = $this->available_players();

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

        public function add_to_team(){

            if($this->input->post('submit')){

                $data = array(
                            'team_id'      => $this->team,
                            'player_id'    => $this->input->post('player')
                        );
                $this->player_model->table = 'team_players';
                $inserted_id = $this->player_model->insert_record($data);

                if($inserted_id){

                    redirect('player');

                }
            }
        }

        private function team_players($id){

            if($this->player_model->get_team_players($id)){

                return $this->player_model->get_team_players($id);
            }

        }

        private function team($id){

            if($this->team_model->get_team_by_manager($id)){

                return $this->team_model->get_team_by_manager($id);
            }

        }

		private function get_players(){

            if($this->player_model->get_all_active()){

                return $this->player_model->get_all_active();

            }
            
        }

        private function available_players(){

            $players_raw = '';
            $players = array('0'=>'Select');

            if($this->player_model->get_available_players()){

                $players_raw = $this->player_model->get_available_players();
            }

            if($players_raw){

                foreach ($players_raw as $player) {

                    $players[$player->id] = ucfirst($player->first_name) . " " . ucfirst($player->last_name);
                }

                return $players;
                
            }

        }

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	