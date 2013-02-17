<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_csv extends My_controller {

	var $upload_path;

	function __construct(){

        parent::__construct();

        if($this->user_type != 1){

            redirect('admin');
            

        }

		$this->upload_path = realpath(APPPATH . '../uploads');

        $this->load->library('form_validation');

		$this->load->model('player_model');

    }

	public function index(){

		$data 	= array();
		$errors = array();
        $data['page_id']        = 'upload_csv'; // <body id="$page_id">
        $data['javascripts']    = array(); // javascripts to load
        $data['stylesheets']    = array('player');  // stylesheets to load
        $data['content'] 		= 'admin/upload'; // view to load

		$csv_error = $this->session->flashdata('csv_error');

		if(isset($csv_error)){

			$data['errors'] = $csv_error;

		}

		if($this->input->post('submit')){

			if(isset($_FILES['upload_csv']) && !empty($_FILES['upload_csv']['name'])){

				$is_uploaded = $this->upload_csv(); //returns error else upload data

				if($is_uploaded['status']){

					$this->session->set_userdata('csv_file', $is_uploaded['data']['full_path']);
					$this->session->set_flashdata('success_message', 'file:' . $is_uploaded['data']['orig_name'] . ' uploaded successfully!');

					redirect('upload_csv/csv_read');

				}else{

					$data['errors'] = $is_uploaded['data'];

				}

			}else{

				$data['errors'] = 'No file to upload';

			}

		}
		
        $this->load->view('includes/base', $data);

	}

	public function csv_read(){

		$data 					= array();
        $data['page_id']        = 'read_csv'; // <body id="$page_id">
        $data['javascripts']    = array(); // javascripts to load
        $data['stylesheets']    = array('player');  // stylesheets to load
        $data['content'] 		= 'admin/csv_view'; // view to load

        $csv_readable 			= $this->session->flashdata('success_message');

        if(isset($csv_readable)){

        	$data['success_message'] = $csv_readable;
        }

		$file_path = $this->session->userdata('csv_file');

		if(isset($file_path) && !empty($file_path) && file_exists($file_path)){

			$this->load->helper('file');

			$rows 		= explode("\n",read_file($file_path));

			$headers 	= explode(",",array_shift($rows));

			$lines 		= array();

			foreach ($rows as $row) {

				if(!empty($row)){

					foreach (explode(",",$row) as $key => $cell_value) {

						$associative_row[str_replace('"', '', $headers[$key])] = str_replace('"', '', $cell_value);
					}

					$lines[] = $associative_row;

				}

			}

			$data['csv_data'] = $lines;

			if($this->input->post('submit')){

				$data = array();
                foreach ($lines as $line){
                    $data[] = array(
                        'first_name' 	=> $line['FIRSTNAME'],
                        'last_name' 	=> $line['LASTNAME'],
                        'nickname' 		=> $line['NICKNAME'],
                        'member_type' 	=> $line['MEMBERTYPE'],
                        'born' 			=> $line['BORN'],
                        'last_year_rank'=> $line['LASTYEARRANK'],
                        'mobile' 		=> $line['MOBILE'],
                        'created' 		=> date('Y-m-d H:i:s'),
                        'position' 		=> $line['POSITION'],
                        'suncell' 		=> $line['SUNCELL'],
                        'email' 		=> $line['EMAIL'],
                        'active' 		=> 1
                    );

                }

                if(!$this->player_model->insert_batch_record($data)){

                	$this->session->set_flashdata('csv_error', 'Players saving via csv failed');

					$this->session->unset_userdata('csv_file', '');

                	redirect('upload_csv');

                }else{

                	$this->session->set_flashdata('success_message', 'Players saving successfully');

                	redirect('player');
                }

			}

		
        	$this->load->view('includes/base', $data);

		}else{

			$this->session->set_flashdata('csv_error', 'There is an error reading the file');
			
			redirect('upload_csv');

		}

	}

	private function upload_csv(){

		/*
		|--------------------------------------------------------
		|	Allowing CI to upload csv file
		|--------------------------------------------------------
		|
		| config/mimes.php change 'csv' value
		| array('application/vnd.ms-excel', 'text/anytext', 'text/plain', 'text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel'),
		|
		*/

		$config = array();
		$config['upload_path'] 		= $this->upload_path;
		$config['allowed_types'] 	= 'csv';
		$config['max_size'] 		= '2000';
		$config['file_name']		= 'player_csv-' . now();

		$this->load->library('upload', $config);

		$data = array();

		if ($this->upload->do_upload('upload_csv')){

			$image_data = $this->upload->data();

			$data['status'] = TRUE;
			$data['data'] 	= $image_data;

		}else{

			$error = $this->upload->display_errors('<span class="error errorInline">', '</span>');

			$data['status'] = FALSE;
			$data['data'] 	= $error;

		}

		return $data;

	}
}

/* End of file upload_csv.php */
/* Location: ./application/controllers/upload_csv.php */