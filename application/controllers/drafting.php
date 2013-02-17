<?php 

	class Drafting extends My_controller{

        var $manager    = 0;
        var $turn       = FALSE;

        function __construct(){

            parent::__construct();

            if($this->user_type != 2){

                redirect('admin');

            }

            $this->manager = $this->session->userdata('user_id');

            $this->load->model('team_model');

            $this->load->model('player_model');

            if(is_queue($this->manager)){

                $this->turn = TRUE;

            }
            
        }

        public function index(){

            if(!$this->turn){

                redirect('drafting/queue');

            }

        	$data = array();
            $data['page_id']        = 'drafting'; // <body id="$page_id">
            $data['javascripts']    = array('jQuery/jquery-ui-1.10.0.custom'); // javascripts to load
            $data['stylesheets']    = array('drafting','jQuery/jcidrafting/jquery-ui-1.10.0.custom');  // stylesheets to load
            $data['all_players']    = $this->available_players();

            $team                   = $this->team($this->manager);
            $data['team']           = $team;
            $data['team_players']   = $this->team_players($team->id);

            $team_last_id           = $this->team_model->get_team_last_id();

            if($this->input->post('submit')){

                $data = array(
                    'team_id'          => $this->input->post('team_id'),
                    'player_id'        => $this->input->post('player_id')
                );

                $this->player_model->table = 'team_players';

                $inserted_id = $this->player_model->insert_record($data);

                if($inserted_id){
                    
                    $data = array('turn' =>  0);

                    $id = $team->id;
                    $this->team_model->table = 'team_queue';
                    $this->team_model->primary_key = 'team_id';

                    if($this->team_model->update_record($id,$data)){

                        $data = array('turn' =>  1);

                        if($team_last_id == $this->input->post('team_id')){

                            $id = 1;

                        }else{

                            $id = ($id + 1);

                        }

                        if($this->team_model->update_record($id,$data)){

                            redirect('drafting');

                        }

                    }

                }

            }

            if($this->input->post('pass')){
                
                $data = array('turn' =>  0);

                $id = $team->id;
                $this->team_model->table = 'team_queue';
                $this->team_model->primary_key = 'team_id';

                if($this->team_model->update_record($id,$data)){

                    $data = array('turn' =>  1);

                    if($team_last_id == $this->input->post('team_id')){

                        $id = 1;

                    }else{

                        $id = ($id + 1);

                    }

                    if($this->team_model->update_record($id,$data)){

                        redirect('drafting');

                    }

                }

            }

            $data['content'] = 'admin/team/drafting'; // view to load
            $this->load->view('includes/base', $data);
		}

        public function queue(){
            
            $data = array();
            $data['page_id']        = 'drafting'; // <body id="$page_id">
            $data['javascripts']    = array('jQuery/jquery-ui-1.10.0.custom'); // javascripts to load
            $data['stylesheets']    = array('drafting','jQuery/jcidrafting/jquery-ui-1.10.0.custom');  // stylesheets to load
            if($this->turn){

                $data['message'] = array('status'=>TRUE, 'message'=>'Yow! You can now enter the drafting page.Thank you for waiting.');

            }else{

                $data['message'] = array('status'=>FALSE, 'message'=>'Hey! Its not your turn yet. Please wait.');
            }

            $data['content'] = 'admin/team/queue'; // view to load
            $this->load->view('includes/base', $data);
        }

        private function team($id){

            if($this->team_model->get_team_by_manager($id)){

                return $this->team_model->get_team_by_manager($id);
            }

        }

        private function team_players($id){

            if($this->player_model->get_team_players($id)){

                return $this->player_model->get_team_players($id);
            }

        }

        private function available_players(){

            if($this->player_model->get_available_players()){

                return $this->player_model->get_available_players();
            }

        }

	}

/* End of file drafting.php */
/* Location: ./application/controller/drafting.php */