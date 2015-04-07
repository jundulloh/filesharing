<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mycrud extends CI_Loader{
	protected $CI;
	protected $arr_cache = array();

	public function __construct()
    {
    	$this->CI =& get_instance();
    	$this->CI->load->model('crud');  //<-------Load the Model first
    }


    public function insert($table, $data)
	{
		$info = $this->CI->crud->insert($table, $data);
		return $info;
	}

	public function join($table, $cond)
	{
		// JOIN table on $cond
		$this->arr_cache[] = array('table' => $table, 'condition' => $cond);
	}

	public function read($table, $get=NULL, $where=NULL)
	{
		if( $get == NULL)
		{
			$get_opt = '*';
		}else
		{
			$get_opt = $get;
		}

		if(isset($this->arr_cache))
		{
			foreach ($this->arr_cache as $key => $value) {
				$this->CI->crud->join($value);
			}
		}
		$result = $this->CI->crud->read($table, $get_opt, $where);
		return $result;
	}

	public function delete($table, $where)
	{
		$result = $this->CI->crud->delete($table, $where);
	}

	public function update($table, $data, $where)
	{
		$this->CI->crud->update($table, $data, $where);
	}
	public function test()
	{
		return 'asdasdasd';
	}
}