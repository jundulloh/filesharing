<?php
	/**
	* 
	*/
	class Login extends CI_Controller
	{
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('crud');
		}

		public function index()
		{
			$this->load->view('templates/header.php');
			$this->load->view('templates/navbar_blank.php');
			$this->load->view('login/login.php');
			$this->load->view('templates/footer.php');
		}

	}
?>

