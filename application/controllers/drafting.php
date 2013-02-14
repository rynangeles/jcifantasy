<?php 

	class Drafting extends My_controller{

        function __construct(){

            parent::__construct();

            if($this->user_type != 2){

                redirect('admin');

            }
            
        }

        public function index(){
        	$data = array();
            $data['page_id']        = 'drafting'; // <body id="$page_id">
            $data['javascripts']    = array('jQuery/jquery-ui-1.10.0.custom'); // javascripts to load
            $data['stylesheets']    = array('drafting','jQuery/jcidrafting/jquery-ui-1.10.0.custom');  // stylesheets to load

            $this->load->model('team_model');

            $data['teams'] = $this->team_model->get_all_records();

            $data['content'] = 'admin/team/drafting'; // view to load
            $this->load->view('includes/base', $data);
		}

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */