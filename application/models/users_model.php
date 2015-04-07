<?php
	/**
	* 
	*/
	class Users_model extends CI_Model
	{
		protected $_data_id;
		public function __construct()
		{
			$self = $this->session->userdata(sha1('idUsers'));
			$this->_data_id = $self;
		}

		public function get_user($where = NULL)
		{
			$this->db->select('*');
			$this->db->from('users');
			if($where !== NULL)
			{
				$this->db->where($where);
			}
			$query = $this->db->get();
			return $query->result_array();
		}	

		public function users_list()
		{
			$where = array('idUsers !=' => $this->_data_id);
			$users = $this->get_user($where);
			return $users;
		}
	}
?>