<?php
	/**
	* 
	*/
	class Crud extends CI_Model
	{
		protected $arr_cache = array();
		public function __construct()
		{
		}

		public function join($data)
		{
			$this->arr_cache[] = $data;
		}

		public function insert($table, $data)
		{
			

			$insert = $this->db->insert($table, $data);
			try {
				if($insert)
				{
					$insert_id = $this->db->insert_id();
					$result['insert_id'] = $insert_id;
					$result['callback_code'] = 200;
					$result['callback_text'] = 'data success';
				}else
				{
					throw new Exception("Error Processing Request");
				}

			} catch (Exception $e) {
				$result['callback_code'] = 500;
				$result['callback_text'] = $e->getmessage();
			}
			return $result;
		}

		public function read($table, $opt, $where)
		{
			$this->db->select($opt);
			$this->db->from($table);
			if(isset($this->arr_cache))
			{
				foreach ($this->arr_cache as $key => $value) {
					$this->db->join($value['table'], $value['condition']);
				}
			}

			if($where != NULL)
			{
				$this->db->where($where);
			}

			$query = $this->db->get();
			$sum = count($query->result_array());
			if($sum == 1)
			{
				return $query->row_array();
			}elseif($sum > 0)
			{
				return $query->result_array();
			}else
			{
				$data = array('callback_code' => 404, 'callback_text' => 'data not found');
				return $data;
			}
		}

		public function update($table, $data, $where)
		{
			$this->db->where($where);
			$this->db->update($table, $data); 
		}
		public function delete($table, $where)
		{
			$this->db->where($where);
			$this->db->delete($table);
		}
	}
?>