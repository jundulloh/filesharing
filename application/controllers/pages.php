<?php
	/**
	* 
	*/
	class Pages extends CI_Controller
	{
		
		public function __construct()
		{
			parent::__construct();
			$userdata = array(sha1('idUsers') => 6 );
			$this->session->set_userdata($userdata);
			$this->load->model('users_model');
			$this->load->model('file_model');
		}

		public function index()
		{
			$this->load->view('templates/header.php');
			$this->load->view('templates/navbar_blank.php');
			$this->load->view('file/dashboard.php');
			$this->load->view('templates/footer.php');
		}

		public function admin()
		{
			$this->load->view('templates/header.php');
			$this->load->view('templates/navbar_blank.php');
			$this->load->view('admin.php');
			$this->load->view('templates/footer.php');
		}

		public function check()
		{
			// $test = is_dir('./datastore/');
			$this->myfeatures->copy_to('./datastore/uploads/files/1/4088376.jpg', './datastore/uploads/files/2/4088376.jpg');


		}

		public function sent_file_to($hash_users)
		{
			$array_where = array('user_qr' => $hash_users);
			$data['user'] = $this->mycrud->read('users', '*', $array_where);
			if(isset($data['user']['callback_code']) && $data['user']['callback_code'] == 404)
			{
				show_404();
			}else
			{
				$this->load->view('templates/header.php');
				$this->load->view('templates/navbar_blank.php');
				$this->load->view('file/sent_file_to', $data);
				$this->load->view('templates/footer.php');
			}
		}

		public function share_file($file_qr)
		{
			$file_where = array('file_qrcode' => $file_qr);
			$file = $this->file_model->get_file($file_where);
			$data['file'] = $file[0];
			$data['users'] = $this->users_model->users_list();
			if(isset($data['user']['callback_code']) && $data['user']['callback_code'] == 404)
			{
				show_404();
			}else
			{
				// $this->load->view('templates/header.php');
				// $this->load->view('templates/navbar_blank.php');
				$this->load->view('file/share_file_to', $data);
				// $this->load->view('templates/footer.php');
			}
			// print_r($data['file']);
		}

		public function uploadfile()
		{
			$this->load->view('file/upload_pages');
		}
	}
?>

