<?php 

	class My_controller extends CI_Controller{

        var $user_type = '';

		function __construct(){

            parent::__construct();

            if(!is_logged_in()){ 

                $this->session->set_flashdata('not_loggedin', 'Access denied. Please login');

                redirect('login'); 
            
            }else{

                $this->user_type = $this->session->userdata('user_type');

            }

        }

	}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
	