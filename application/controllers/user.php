<?php 

	class User extends CI_Controller{

		function __construct(){
            parent::__construct();
			$this->load->model('user_model');
        }

        public function index(){
        	$data = array();
        	$users = $this->get_users();
        	if($users){
        		$data['users'] = $users;
        		/*sample display of records working!
        		foreach ($users as $user) {
	        		echo $user->first_name;
	        	}
	        	*/
        	}
		}

		private function get_users(){
            if($this->user_model->get_all_records()){
                return $this->user_model->get_all_records();
            }
        }

	}

/* End of file user.php */
/* Location: ./application/controller/user.php */
	