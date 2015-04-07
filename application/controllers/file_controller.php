<?php
	/**
	* 
	*/
	class File_controller extends CI_Controller
	{

		protected $arr_file = array();
		protected $arr_share;
		protected $_data_user = array();
		protected $_data_id;
		protected $sendmail = TRUE;
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('file_model');
			// ini ambil dari session
			$self = $this->session->userdata(sha1('idUsers'));
			$this->_data_id = $self;
		}

		public function getFile()
		{
			// $id = $this->input->post('id');
			$id = 1;
			$where = array('idUsers' => $this->_data_id);
			$data['file'] = $this->file_model->get_file($where);
			return $data;
		}

		public function file_list()
		{
			$file = $this->getFile();
			if(count($file['file']) > 0)
			{
				$i = 1;
				foreach ($file['file'] as $key => $value) {
				 	$data['data'][$key][] = $i;
				 	$data['data'][$key][] = $value['file_name'];
				 	$data['data'][$key][] = $value['file_ext'];
				 	$data['data'][$key][] = $value['time_upload'];
				 	$data['data'][$key][] = '<a href="'.site_url('pages/share_file/'.$value['file_qrcode']).'" class="btn btn-sm btn-primary btn-share btn-share-'.$value['idFile'].'" data-file="'.$value['idFile'].'"> Share </a>';
				 	$i++;
				} 
			}
			else{
				$data = array(
					'sEcho' => 1,
					'iTotalRecords' => 0,
					'iTotalDisplayRecords' => 0,
					'aaData' => []
				);
			}
			
			echo json_encode($data);
		}

		private function _upload_file($dir)
		{
			$file = $this->myfile->upload_files($dir);
			foreach ($file as $key => $value) {
				$idFile = $this->save_file($this->_data_id, $value);
				$file[$key]['idFile'] = $idFile['insert_id'];

				$this->logfile($idFile['insert_id'], 'upload');
			}
			return $file;
		}

		public function uploadfile()
		{
			$dir_save 	= './datastore/uploads/files/'.$this->_data_id;
			$file 		= $this->_upload_file($dir_save);
			return $file;
		}

		public function send_to($idtarget)
		{
			$data_save 	= './datastore/uploads/files/'.$this->_data_id;
			$file 		= $this->_upload_file($data_save);
			$target 	= $this->mycrud->read('users', '*', array('idUsers' => $idtarget));
			$this->_data_user = $target;
			foreach ($file as $key => $value) {
			 	# code...
			 	$this->arr_file = $value;
				$this->_share();
			 	$this->myfeatures->copy_to($data_save.'/'.$value['file_name'], './datastore/uploads/files/'.$target['idUsers'].'/'.$value['file_name']);
			 }
			// $this->share($idtarget, $file);
			// save into share_detail
			// save into share_log
		}
		

		///////////////////////////////////////////////////////////////// SHARE SECTION /////////////////////////////////////////////////////////////////

		public function share()
		{
			$data_save 	= './datastore/uploads/files/'.$this->_data_id;
			$target_item  	= $this->input->post('share-item');
			$file 	 		= $this->input->post('idFile');
		 	$file_attach 	= $this->mycrud->read('files', '*', array('idFile' => $file));
		 	$this->arr_file = $file_attach;	

			foreach ($target_item as $key => $value) {
				$target 			= $this->mycrud->read('users', '*', array('idUsers' => $value));
				$this->_data_user 	= $target;

				$this->_share();
			 	$this->myfeatures->copy_to($data_save.'/'.$file_attach['file_name'], './datastore/uploads/files/'.$target['idUsers'].'/'.$file_attach['file_name']);
			}
			// print_r($target_item);
		}
		private function share_file($idtarget, $file)
		{
			$target 	= $this->mycrud->read('users', '*', array('idUsers' => $idtarget));
			$this->_data_user = $target;
			foreach ($file as $key => $value) {
			 	# code...
			 	$this->arr_file = $value;
				$this->_share();
			 	$this->myfeatures->copy_to($data_save.'/'.$value['file_name'], './datastore/uploads/files/'.$target['idUsers'].'/'.$value['file_name']);
			 }
		}
		private function _share()
		{
			$data = $this->arr_file;
			$user = $this->_data_user;
			$self = $this->mycrud->read('users', 'idUsers, fname, lname', array('idUsers' => $this->_data_id));
			$share = array(
					'idFile' 		=> $data['idFile'],
					'idUsers'		=> $this->_data_id,
					'time_share' 	=> date('Y-m-d H:i:s')
				);
			$result_share = $this->mycrud->insert('share', $share);
			$this->_detail_share($result_share['insert_id']);
			
			$idFile = $this->save_file($user['idUsers'], $data);

			if($this->sendmail == TRUE){
				$unique 		= uniqid();
				$file_name 		= $data['file_name'];
				$share_name 	= $self['fname'].' '.$self['lname'];
				$link_file 		= site_url('show/file/'.$data['idFile']);
				$mail_content = 
<<<EOT
<div>
<div>ref #$unique</div>
<h3>$share_name has been shared a file with you.</h3>
you can go to <a href="$link_file"> Show $file_name </a> to open this file
</div>
EOT;
				$mail['mail_to'] 		= $user['email'];
				$mail['mail_from'] 		= 'developer@cplusco.com';
				$mail['mail_name'] 		= 'Cplusco Filesharing';
				$mail['mail_subject'] 	= 'Filesharing Notification';
				$mail['mail_text'] 		= $mail_content;
				$this->myfeatures->email($mail);
			}
		
			$this->logfile($data['idFile'], 'share');

		}

		private function _detail_share($insertid)
		{

			$target = $this->_data_user;
			$detail = array(
					'idShare' 		=> $insertid,
					'share_target' 	=> $target['idUsers'],
					'time_share' 	=> date('Y-m-d H:i:s'),
					'idAuthority' 	=> 0,
					'author' 		=> $this->_data_id
				);
			$this->mycrud->insert('detail_share', $detail);
		}

		private function logfile($insertid, $type)
		{
			$log_arr = array(
				'idFile' 	=> $insertid,
				'idUsers' 	=> $this->_data_id,
				'time_log' 	=> date('Y-m-d H:i:s'),
				'action' 	=> $type
			);
			$this->mycrud->insert('log_file', $log_arr);
		}

		private function save_file($users, $value)
		{
			$data_file = array(
				'idUsers' 		=> $users,
				'idAuthority' 	=> 0,
				'file_name' 	=> $value['file_name'],
				'file_type' 	=> $value['file_type'],
				'file_ext' 		=> $value['file_ext'],
				'file_size' 	=> $value['file_size'],
				'file_qrcode' 	=> sha1($value['file_name']),
				'caption' 		=> '',
				'time_upload' 	=> date('Y-m-d H:i:s')
			);
			$idFile = $this->mycrud->insert('files', $data_file);
			return $idFile;
		}
	}
?>