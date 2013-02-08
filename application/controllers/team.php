<?php 

	class Team extends My_controller{

        function __construct(){

            parent::__construct();

            if($this->user_type != 1){

                redirect('admin');

            }

        }

        public function index(){

            $data = array();
            $data['page_id']        = 'team'; // <body id="$page_id">
            $data['javascripts']    = array(); // javascripts to load
            $data['stylesheets']    = array();  // stylesheets to load
            $data['menus']          = $this->user_menu[$this->user_type]; //user menus My_controller
            //$data['teams']          = $this->get_teams();

            $data['content'] = 'admin/team/team'; // view to load
            $this->load->view('includes/base', $data);

            
        }

        public function create(){

            $data = array();
            $data['page_id']            = 'team-create'; // <body id="$page_id">
            $data['javascripts']        = array(); // javascripts to load
            $data['stylesheets']        = array();  // stylesheets to load
            $data['menus']              = $this->user_menu[$this->user_type]; //user menus My_controller
            $data['managers_option']    = $this->get_manager_options(); //returns an array for form_dropdown()

            $data['content'] = 'admin/team/create'; // view to load
            $this->load->view('includes/base', $data);
        }

		private function get_teams(){
            if($this->user_model->get_all_records()){
                return $this->user_model->get_all_records();
            }
        }

        private function get_manager_options(){

        }

	}

/* End of file team.php */
/* Location: ./application/controller/team.php */
	