<?php
	/**
	* 
	*/
	class File_model extends CI_Model
	{
		protected $_data_id;	
		public function __construct()
		{
			$self = $this->session->userdata(sha1('idUsers'));
			$this->_data_id = $self;
		}

		public function get_file($where = NULL)
		{
			$this->db->select('*');
			$this->db->from('files');
			if($where !== NULL)
			{
				$this->db->where($where);
			}
			$query = $this->db->get();
			return $query->result_array();
		}	
	}
?>