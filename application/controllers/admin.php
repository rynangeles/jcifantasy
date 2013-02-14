<?php 

	class Admin extends My_controller{

        function __construct(){

            parent::__construct();

            // if($this->user_type != 1){

            //     redirect('admin');

            // }
            
        }

        public function index(){
        	$data = array();
            $data['page_id']        = 'admin'; // <body id="$page_id">
            $data['javascripts']    = array(); // javascripts to load
            $data['stylesheets']    = array('admin');  // stylesheets to load

            $this->load->model('team_model');

            $data['teams'] = $this->team_model->get_all_records();

            $data['content'] = 'admin/home'; // view to load
            $this->load->view('includes/base', $data);
		}

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	