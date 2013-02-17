<?php 

	class Team extends My_controller{

        function __construct(){

            parent::__construct();

            if($this->user_type != 1){

                redirect('admin');
                

            }


            $this->load->model('team_model');

            $this->load->library('form_validation');

        }

        public function index(){

            $data = array();
            $data['page_id']        = 'team'; // <body id="$page_id">
            $data['javascripts']    = array(); // javascripts to load
            $data['stylesheets']    = array('team');  // stylesheets to load
            $data['teams']          = $this->get_teams();

            //team creation | update 
            if($this->session->flashdata('success_message')){
                $data['success_message'] = $this->session->flashdata('success_message');
            }

            $data['content'] = 'admin/team/team'; // view to load
            $this->load->view('includes/base', $data);

            
        }

        public function create(){

            $data = array();
            $data['page_id']            = 'team-create'; // <body id="$page_id">
            $data['javascripts']        = array('ajaxupload'); // javascripts to load
            $data['stylesheets']        = array('team');  // stylesheets to load
            $data['managers_option']    = $this->get_manager_options(); //returns an array for form_dropdown()
            $data['content']            = 'admin/team/create'; // view to load

            if($this->input->post('submit')){

                $this->form_validation->set_error_delimiters('<span class="error errorInline">', '</span>');
                //$this->form_validation->set_rules('logo_image_filename', 'Team Logo', 'required');
                $this->form_validation->set_rules('team_name', 'Team Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('coach_first_name', 'Coach First Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('coach_last_name', 'Coach Last Name', 'trim|required|xss_clean');
                $this->form_validation->set_message('is_natural_no_zero', 'Please select a manager', 'manager|xss_clean');
                $this->form_validation->set_rules('manager', 'Team Manager', 'trim|required|is_natural_no_zero|xss_clean');
                
                if ($this->form_validation->run() == FALSE){

                    $data['error']      = TRUE;
                    $data['manager']    = $this->input->post('manager');
                    $data['status']     =  $this->input->post('status');
                
                }else{

                    $last_team_id   = $this->team_model->get_team_last_id();

                    $upload_logo    = $this->upload(($last_team_id+1));


                    $team_logo      = 'default.jpg';
                    $team_thumb     = 'default_thumb.jpg';

                    if(isset($upload_logo['status'])){
                        
                        if($upload_logo['status'] == TRUE){

                            $team_logo  = 'large-' . $upload_logo['data']['file_name'];
                            $team_thumb = 'thumb-' . $upload_logo['data']['file_name'];

                            $data = array(
                                    'team_name'         => $this->input->post('team_name'),
                                    'manager_id'        => $this->input->post('manager'),
                                    'coach_first_name'  => $this->input->post('coach_first_name'),
                                    'coach_last_name'   => $this->input->post('coach_last_name'),
                                    'team_logo'         => $team_logo,
                                    'team_logo_thumb'   => $team_thumb,
                                    'created'           => date('Y-m-d H:i:s'),
                                    'active'            => $this->input->post('status')
                                );

                            $inserted_id = $this->team_model->insert_record($data);

                            if($inserted_id){
                            
                                $data = array(
                                    'team_id' =>  $inserted_id
                                );

                                $this->team_model->table = 'team_queue';

                                $this->team_model->insert_record($data);

                            }

                            $data['success'] = TRUE;

                            $this->session->set_flashdata('success_message', 'Team saving successful.');

                            redirect('team');

                        }else{

                            $data['success']        = FALSE;
                            $data['manager']        = $this->input->post('manager');
                            $data['status']         =  $this->input->post('status');
                            $data['upload_error']   = $upload_logo['data'];

                        }

                    }  

                }

                $this->load->view('includes/base', $data);

            }else{

                $this->load->view('includes/base', $data);

            }
                    

        }

        public function edit(){

            $data = array();
            $data['page_id']            = 'team-create'; // <body id="$page_id">
            $data['javascripts']        = array('ajaxupload'); // javascripts to load
            $data['stylesheets']        = array('team');  // stylesheets to load
            $data['managers_option']    = $this->get_manager_options(); //returns an array for form_dropdown()
            $data['content']            = 'admin/team/edit'; // view to load


            $id = $this->uri->segment(3);

            $defaults = $this->team_model->get_by_id($id);

            $defaults = array_shift($defaults);

            $data['default']    = $defaults;
            $data['manager']    = $defaults->manager_id;
            $data['status']     = $defaults->active;

            $data['managers_option'][$defaults->manager_id] = get_manager_name($defaults->manager_id);

            if($this->input->post('submit')){

                $this->form_validation->set_error_delimiters('<span class="error errorInline">', '</span>');
                //$this->form_validation->set_rules('logo_image_filename', 'Team Logo', 'required');
                $this->form_validation->set_rules('team_name', 'Team Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('coach_first_name', 'Coach First Name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('coach_last_name', 'Coach Last Name', 'trim|required|xss_clean');
                $this->form_validation->set_message('is_natural_no_zero', 'Please select a manager', 'manager|xss_clean');
                $this->form_validation->set_rules('manager', 'Team Manager', 'trim|required|is_natural_no_zero|xss_clean');
                
                if ($this->form_validation->run() == FALSE){

                    $data['error']      = TRUE;
                    $data['manager']    = $this->input->post('manager');
                    $data['status']     =  $this->input->post('status');
                
                }else{

                    $upload_logo = $this->upload($id);

                    $team_logo  = $defaults->team_logo;
                    $team_thumb = $defaults->team_logo_thumb;

                    if(isset($upload_logo['status'])){
                        

                        if($upload_logo['status'] == TRUE){

                            $team_logo  = 'large-' . $upload_logo['data']['file_name'];
                            $team_thumb = 'thumb-' . $upload_logo['data']['file_name'];

                            $data = array(
                                'team_name'         => $this->input->post('team_name'),
                                'manager_id'        => $this->input->post('manager'),
                                'coach_first_name'  => $this->input->post('coach_first_name'),
                                'coach_last_name'   => $this->input->post('coach_last_name'),
                                'team_logo'         => $team_logo,
                                'team_logo_thumb'   => $team_thumb,
                                'active'            => $this->input->post('status')
                            );

                            $updated_id = $this->team_model->update_record($id, $data);

                            if($updated_id){
                            
                                $data['success'] = TRUE;

                                $this->session->set_flashdata('success_message', 'Team update successful.');

                                redirect('team');

                            }

                        }else{

                            $data['success']        = FALSE;
                            $data['manager']        = $this->input->post('manager');
                            $data['status']         = $this->input->post('status');
                            $data['upload_error']   = $upload_logo['data'];

                        }

                    }

                }

                $this->load->view('includes/base', $data);

            }else{

                $this->load->view('includes/base', $data);

            }

        }

        public function delete(){

            $id = $this->uri->segment(3);

            $is_deleted = $this->team_model->delete_record($id);

            if($is_deleted){

                $this->team_model->table = 'team_queue';
                $this->team_model->primary_key = 'team_id';

                $is_deleted = $this->team_model->delete_record($id);

                if($is_deleted){   

                    $this->session->set_flashdata('success_message', 'Team successfully deleted.');

                    redirect('team');

                }else{
                    
                    $this->session->set_flashdata('success_message', 'Team deletion failed.');

                }

            }else{

                $this->session->set_flashdata('success_message', 'Team deletion failed.');

            }

        }

        public function draw_lot(){

            $data = array();
            $data['page_id']            = 'team-drawlot'; // <body id="$page_id">
            $data['javascripts']        = array(); // javascripts to load
            $data['stylesheets']        = array('team');  // stylesheets to load
            $data['content']            = 'admin/team/draw_lot'; // view to load
            $data['teams']              = $this->get_unqueued_teams();  //return teams that doesnt have queue yet
            $data['turns']              = $this->get_queued_teams();  //return teams that has queue value
            $data['queue']              = $this->get_next_queue(); //returns the next queue

            if($this->input->post('submit')){

                $data = array( 'queue' => $this->input->post('queue_id'));

                $this->team_model->table        = 'team_queue';
                $this->team_model->primary_key  = 'team_id';

                $updated_id = $this->team_model->update_record($this->input->post('team_id'), $data);

                if($updated_id){

                    if($this->input->post('queue_id') == 1){

                        $data = array('turn' =>  1);

                        if($this->team_model->update_record($this->input->post('team_id'),$data)){


                            $this->session->set_flashdata('success_message', 'Draw lot successful');

                            redirect('team/draw_lot');

                        }

                    }else{


                        $this->session->set_flashdata('success_message', 'Draw lot successful');

                        redirect('team/draw_lot');

                    }
                }
            }

            $this->load->view('includes/base', $data);

        }

        private function get_next_queue(){

            $queue = $this->team_model->last_queue();

            return ($queue['queue']+1);
        }

        private function get_unqueued_teams(){

            if($this->team_model->all_unqueued_teams()){

                return $this->team_model->all_unqueued_teams();

            }
        }

        private function get_queued_teams(){

            if($this->team_model->all_queued_teams()){

                return $this->team_model->all_queued_teams();

            }

        }

        private function upload($id){

            if(isset($_FILES['team_logo']) && !empty($_FILES['team_logo']['name'])){

                return $this->team_model->do_upload($id); //returns error else upload data

            }else{

                return 'No file';
            }

        }

		private function get_teams(){

            if($this->team_model->get_all_records()){

                return $this->team_model->get_all_records();
            }
        }

        private function get_manager_options(){

            $options = array();

            $options[0] = 'Select';
            
            $managers = $this->team_model->get_all_available_manager();

            if($managers){

                foreach ($managers as $manager) {
                
                    $options[$manager->manager_id] = ucfirst($manager->manager_firstname) . ' ' . ucfirst($manager->manager_lastname);
                }

            }

            return $options;
        }

	}

/* End of file team.php */
/* Location: ./application/controller/team.php */
	