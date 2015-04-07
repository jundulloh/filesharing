<?php
	/**
	* 
	*/
	class Form extends CI_Controller
	{
		
		public function __construct()
		{
			parent::__construct();
			$this->load->library('Ciqrcode');
			$this->load->model('users_model');
		}

		public function save_member()
		{
			$paramqr['hash'] = $this->myfeatures->generate_hash();
			$paramqr['dir']  = './datastore/qrcode/users/';
			$paramqr['name'] = $paramqr['hash'];
			$this->export_qr($paramqr);
			
			$pass = $this->myfeatures->generate_password(7);
			$data = array(
					'fname' 		=> $this->input->post('firstname'),
					'lname' 		=> $this->input->post('lastname'),
					'email' 		=> $this->input->post('email'),
					'passkey' 		=> sha1($pass),
					'handphone' 	=> $this->input->post('handphone'),
					'idJabatan' 	=> 0,
					'idDivisi' 		=> 0,
					'user_qr' 		=> $paramqr['hash'],
					'user_ava' 		=> '',
					'time_create' 	=> date('Y-m-d H:i:s')
				);
			$result_insert 	= $this->mycrud->insert('users', $data);
			mkdir('./datastore/uploads/files/'.$result_insert['insert_id']);

			$data['pass'] 	= $pass;
			$this->send_email_notification_registered($data);
			return $data;
		}

		public function export_qr($data)
		{
			$params['data'] = $data['hash'];
			$params['level'] = 'H';
			$params['size'] = 10;
			$params['savename'] = $data['dir'].$data['name'].'.png';
			$this->ciqrcode->generate($params);
		}
	
		public function send_email_notification_registered($data)
		{
			$unique = uniqid();
			$email = $data['email'];
			$pass = $data['pass'];
			$mail_content = 
<<<EOT
<div>
<div>ref #$unique</div>
<h3>Welcome to Filesharing Alpha 1.2 Pre-release</h3>
<hr>
<p>
This is a pre-launch app for share with other employments. what can you share? anything.. you can share document, photo, video and give permittion in each of file.
</p>
<p> and we Proud, we have you. you are choosen by the fate.. muehehehe... </p>
<p> and here, we will give you permission to pass into the app. </p>
<p> This is Your username : $email</p>
<p> This is Your password : $pass</p>
<p> And We also attach qrcode for next features.</p>
<p> Thank you for your support.</p>
<p> We will give our best...</p>
</div>
EOT;
			$mail['mail_to'] = $data['email'];
			$mail['mail_from'] = 'developer@cplusco.com';
			$mail['mail_name'] = 'Filesharing Greeting';
			$mail['mail_subject'] = 'Welcome in Filesharing v.1.2 Pre-release';
			$mail['mail_text'] = $mail_content;
			$mail['attach'] = array('./datastore/qrcode/users/'.$data['user_qr'].'.png');
			$this->myfeatures->email($mail);
		}



		// user SECTION

		public function get_user($id = NULL)
		{
			if($id == NULL)
			{
				$data['users'] = $this->users_model->users_list();
			}else
			{
				$where_user = array('idUsers' => $id);
				$data['users'] = $this->mycrud->read('users','*', $where_user);
			}

			if(count($data['users']) < 1)
			{
				$data['callback'] = array('callback_code' => 404, 'callback_text' => 'user_not_found', 'user_count' => count($data['users']));
			}else
			{
				$data['callback'] = array('callback_code' => 200, 'callback_text' => 'user found', 'user_count' => count($data['users']));
			}
			echo json_encode($data);
		}
	}
?>

