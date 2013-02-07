<?php 
	class Logout extends CI_Controller{

		public function index(){

			$this->session->sess_destroy();

			$this->set_logout_message();

		}

		private function set_logout_message(){

			$this->session->sess_create();

			$flash_message = 'you are logged out';

			$this->session->set_flashdata('logout_message', $flash_message);

			redirect('login');
		}

}



/* End of file logout.php */
/* Location: ./application/controller/logout.php */