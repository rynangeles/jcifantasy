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
            $data['javascripts']        = array('jQuery/jquery-ui-1.10.0.custom'); // javascripts to load
            $data['stylesheets']        = array('jQuery/jcidrafting/jquery-ui-1.10.0.custom');  // stylesheets to load
            $data['content']            = 'admin/player/create'; // view to load

            if($this->input->post('submit')){

                $this->form_validation->set_error_delimiters('<span class="error errorInline">', '</span>');
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
                $this->form_validation->set_rules('born', 'Born', 'trim|required|xss_clean');
                $this->form_validation->set_rules('member_type', 'Member Type', 'trim|callback_member_type_check|xss_clean');
                
                if ($this->form_validation->run() == FALSE){

                    $data['error']      = TRUE;
                    $data['position']   = $this->input->post('position');
                    $data['type']       = $this->input->post('member_type');
                    $data['status']     = $this->input->post('status');
                
                }else{          

                    $data = array(
                        'first_name'    => $this->input->post('first_name'),
                        'last_name'     => $this->input->post('last_name'),
                        'member_type'   => $this->input->post('member_type'),
                        'born'          => $this->input->post('born'),
                        'last_year_rank'=> $this->input->post('last_year_rank'),
                        'mobile'        => $this->input->post('mobile'),
                        'suncell'       => $this->input->post('suncell'),
                        'position'      => $this->input->post('position'),
                        'created'       => date('Y-m-d H:i:s'),
                        'email'         => $this->input->post('email'),
                        'active'        => 1
                    );

                    $inserted_id = $this->player_model->insert_record($data);

                    $data['success'] = TRUE;

                    $this->session->set_flashdata('success_message', 'Player saving successful.');

                    redirect('player');

                }

                $this->load->view('includes/base', $data);

            }else{

                $this->load->view('includes/base', $data);

            }
                    

        }

        public function edit(){

            $data = array();
            $data['page_id']            = 'player-edit'; // <body id="$page_id">
            $data['javascripts']        = array('jQuery/jquery-ui-1.10.0.custom'); // javascripts to load
            $data['stylesheets']        = array('jQuery/jcidrafting/jquery-ui-1.10.0.custom');  // stylesheets to load
            $data['content']            = 'admin/player/edit'; // view to load

            $id = $this->uri->segment(3);

            $defaults = $this->player_model->get_by_id($id);

            $defaults = array_shift($defaults);

            $data['player']             = $defaults;
            $data['position']           = $defaults->position;
            $data['type']               = $defaults->member_type;
            $data['status']             = $defaults->active;

            if($this->input->post('submit')){

                $this->form_validation->set_error_delimiters('<span class="error errorInline">', '</span>');
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
                $this->form_validation->set_rules('born', 'Born', 'trim|required|xss_clean');
                $this->form_validation->set_rules('member_type', 'Member Type', 'trim|callback_member_type_check|xss_clean');
                
                if ($this->form_validation->run() == FALSE){

                    $data['error']      = TRUE;
                    $data['position']   = $this->input->post('position');
                    $data['type']       = $this->input->post('member_type');
                    $data['status']     = $this->input->post('status');
                
                }else{          

                    $data = array(
                        'first_name'    => $this->input->post('first_name'),
                        'last_name'     => $this->input->post('last_name'),
                        'member_type'   => $this->input->post('member_type'),
                        'born'          => $this->input->post('born'),
                        'last_year_rank'=> $this->input->post('last_year_rank'),
                        'mobile'        => $this->input->post('mobile'),
                        'suncell'       => $this->input->post('suncell'),
                        'position'      => $this->input->post('position'),
                        'created'       => date('Y-m-d H:i:s'),
                        'email'         => $this->input->post('email'),
                        'active'        => 1
                    );

                    $updated_id = $this->player_model->update_record($id, $data);

                    $data['success'] = TRUE;

                    $this->session->set_flashdata('success_message', 'Player update successful.');

                    redirect('player');

                }

                $this->load->view('includes/base', $data);

            }else{

                $this->load->view('includes/base', $data);

            }
                    

        }

        public function delete(){

            $id = $this->uri->segment(3);

            $data = array( 'deleted' => 1 );

            $deleted_id = $this->player_model->update_record($id, $data);

            if($deleted_id){

                $this->session->set_flashdata('success_message', 'Player successfully deleted.');

                redirect('user');

            }else{

                $this->session->set_flashdata('success_message', 'Player deletion failed.');

            }
        }

        public function member_type_check($str){

            if ($str == '0'){

                $this->form_validation->set_message('member_type_check', 'The %s field is require choose one.');
                return FALSE;

            }else{

                return TRUE;
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
	