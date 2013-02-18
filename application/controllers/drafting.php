<?php 

	class Drafting extends My_controller{

        var $manager    = 0;
        var $turn       = FALSE;
        var $turn_order = 1;

        function __construct(){

            parent::__construct();

            if($this->user_type != 2){

                redirect('admin');

            }

            $this->manager = $this->session->userdata('user_id');

            $this->load->model('team_model');

            $this->load->model('player_model');

            $this->load->model('turnorder_model');

            $this->turn_order = $this->get_turn_order();

            if(is_queue($this->manager)){

                $this->turn = TRUE;

            }
            
        }

        public function index(){

            if(!$this->turn){

                redirect('drafting/queue');

            }

            $team                   = $this->team($this->manager);
            $last_team_seed         = $this->last_team_seed(isset($team->id) ? $team->id : 0);

            $data = array();
            $data['page_id']        = 'drafting'; // <body id="$page_id">
            $data['javascripts']    = array('jQuery/jquery-ui-1.10.0.custom'); // javascripts to load
            $data['stylesheets']    = array('drafting','jQuery/jcidrafting/jquery-ui-1.10.0.custom');  // stylesheets to load
            $data['all_players']    = $this->available_players();
            
            $data['team']           = $team;
            $data['seed']           = $last_team_seed + 1;
            $data['team_players']   = $this->team_players(isset($team->id) ? $team->id : 0);

            $team_last_id           = $this->team_model->get_team_last_id();

            if($this->team_model->seed_exist(($last_team_seed+1), $team->id)){

                $data = array('turn' =>  0, 'seed' => ($last_team_seed+1));
                $this->team_model->table = 'team_queue';
                $this->team_model->primary_key = 'team_id';
                $id = $team->id;

                if($this->team_model->update_record($id,$data)){

                    $data = array('turn' =>  1);

                    if($team_last_id == $team->id && $this->turn_order == 1){

                        $id = $team->id;

                        $this->reset_turn_order('desc');


                    }elseif($team->id == 1 && $this->turn_order == -1){

                        $id = $team->id;

                        $this->reset_turn_order('asc');

                    }else{

                        $id = ($id + $this->turn_order);

                    }

                    if($this->team_model->update_record($id,$data)){

                        redirect('drafting');

                    }

                }

            }

            if($this->input->post('submit')){

                $data = array(
                    'team_id'          => $this->input->post('team_id'),
                    'player_id'        => $this->input->post('player_id'),
                    'seed'              => $this->input->post('seed')
                );

                $this->player_model->table = 'team_players';

                $inserted_id = $this->player_model->insert_record($data);

                if($inserted_id){
                    
                    $data = array('turn' =>  0, 'seed' => $this->input->post('seed'));
                    $this->team_model->table = 'team_queue';
                    $this->team_model->primary_key = 'team_id';
                    $id = $team->id;

                    if($this->team_model->update_record($id,$data)){

                        $data = array('turn' =>  1);

                        if($team_last_id == $this->input->post('team_id') && $this->turn_order == 1){

                            $id = $this->input->post('team_id');

                            $this->reset_turn_order('desc');


                        }elseif($this->input->post('team_id') == 1 && $this->turn_order == -1){

                            $id = $this->input->post('team_id');

                            $this->reset_turn_order('asc');

                        }else{

                            $id = ($id + $this->turn_order);

                        }

                        if($this->team_model->update_record($id,$data)){

                            redirect('drafting');

                        }

                    }

                }

            }

            if($this->input->post('pass')){

                $data = array(
                    'team_id'          => $this->input->post('team_id'),
                    'player_id'        => 0,
                    'seed'             => $this->input->post('seed')
                );

                $this->player_model->table = 'team_players';

                $inserted_id = $this->player_model->insert_record($data);

                if($inserted_id){

                    $data = array('turn' =>  0, 'seed' => $this->input->post('seed'));
                    $id = $team->id;
                    $this->team_model->table = 'team_queue';
                    $this->team_model->primary_key = 'team_id';

                    if($this->team_model->update_record($id,$data)){

                        $data = array('turn' =>  1);

                        if($team_last_id == $this->input->post('team_id') && $this->turn_order == 1){

                            $id = $this->input->post('team_id');

                            $this->reset_turn_order('desc');


                        }elseif($this->input->post('team_id') == 1 && $this->turn_order == -1){

                            $id = $this->input->post('team_id');

                            $this->reset_turn_order('asc');

                        }else{

                            $id = ($id + $this->turn_order);

                        }

                        if($this->team_model->update_record($id,$data)){

                            redirect('drafting');

                        }

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

        private function last_team_seed($id){

            $this->player_model->table = 'team_queue'; 
            $this->player_model->primary_key = 'team_id';

            $return = $this->player_model->get_by_id($id);

            if($return){

                $return = array_shift($return);

                return $return->seed;

            }else{

                return FALSE;

            }

        }

        private function reset_turn_order($order){

            $data = array('order'=>$order);

            $update_id = $this->turnorder_model->update_record(1,$data);

            if($update_id){

                return TRUE;

            }else{

                return FALSE;

            }
        
        }

        private function get_turn_order(){

            $order = $this->turnorder_model->get_by_id(1);

            $order = array_shift($order);

            if($order->order == 'asc'){

                return 1;

            }else{

                return -1;

            }

        }

        private function team($id){

            if($this->team_model->get_team_by_manager($id)){

                return $this->team_model->get_team_by_manager($id);

            }else{

                return FALSE;
            }

        }

        private function team_players($id){

            if($this->player_model->get_team_players($id)){

                return $this->player_model->get_team_players($id);

            }else{

                return FALSE;
            }

        }

        private function available_players(){

            if($this->player_model->get_available_players()){

                return $this->player_model->get_available_players();

            }else{

                return FALSE;
            }

        }

	}

/* End of file drafting.php */
/* Location: ./application/controller/drafting.php */