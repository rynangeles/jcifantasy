<?php 

	class Admin extends My_controller{

        function __construct(){

            parent::__construct();

            // if($this->user_type != 1){

            //     redirect('admin');

            // }

            $this->load->model('team_model');
            $this->load->model('player_model');
            
        }

        public function index(){
        	$data = array();
            $data['page_id']        = 'admin'; // <body id="$page_id">
            $data['javascripts']    = array(); // javascripts to load
            $data['stylesheets']    = array('admin');  // stylesheets to load

            if($this->session->flashdata('success_message')){
                
                $data['success_message'] = $this->session->flashdata('success_message');
            }

            $data['teams'] = $this->team_model->get_all_records();

            $data['content'] = 'admin/home'; // view to load
            $this->load->view('includes/base', $data);
		}

        public function randomize(){

            $available_players  = $this->get_available_players();
            $team_count         = $this->count_team();

            $count = 0;
            $seed = 26;

            $data = array();

            foreach ($available_players as $available_player) {

                $data[] = array(
                    'team_id'   => $team_count[$count]['team_id'],
                    'player_id' => $available_player->id,
                    'seed'      => $seed
                    );

                if($count == count($team_count)-1){

                    $count = 0;
                    $seed++;

                }else{

                    $count ++;

                }

            }

            $this->team_model->table = 'team_players';

            if(!$this->team_model->insert_batch_record($data)){

                $this->session->set_flashdata('success_message', 'Players randomize assignment failed');

                $this->session->unset_userdata('csv_file', '');

                redirect('admin');

            }else{

                $this->session->set_flashdata('success_message', 'Players randomize assignment success');

                redirect('admin');
            }


        }

        private function get_available_players(){

            if($this->player_model->get_available_players()){

                return $this->player_model->get_available_players();
            }
        }

        private function count_team(){

            if($this->team_model->get_team_array()){

                return $this->team_model->get_team_array();
            }
        }

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	