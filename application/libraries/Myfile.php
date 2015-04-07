<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Myfile extends CI_Loader{
	protected $CI;
	public function __construct()
    {
    	$this->CI =& get_instance();
    	$this->CI->load->model('crud');  //<-------Load the Model first
    	$this->CI->load->helper(array('form', 'url'));
    }

    public function authorize($config)
    {
    	// if($config['']);
    }

    public function upload_files($path = './datastore/uploads/temp/')
	{
		$config['overwrite'] 		= FALSE;
		$config['upload_path'] 		= $path;
		$config['allowed_types'] 	= 'jpg|png|gif|ico|svg|JPG|JPEG|jpeg|mp4|mpeg|flv|3gp|mkv|avi|avs|wmv|mov|MOV|zip|rar|doc|docx|xls|xlsx';
		$config['max_size']			= 10000000000000000000;
		if(!is_dir($config['upload_path']))
	    {
	    	mkdir($config['upload_path'], 0777);
	    }
		$this->CI->load->library('upload', $config);
		$this->CI->load->library('image_lib'); 
		$i = 0;
		foreach ($_FILES as $value) {
			$form_data = 'file-'.$i;
			if ( ! $this->CI->upload->do_upload($form_data))
			{
				$result = array('error' => $this->CI->upload->display_errors());
				
			}
			else
			{
				$data = array('upload_data' => $this->CI->upload->data());
				$result = $this->CI->upload->data();
		
				// resize Image
				// ------------------------------------------------------------------
				if($result['is_image'] == 1)
				{
					$this->resize($result);
				}
				// ------------------------------------------------------------------
			} 
			$i++;
			$image[] = $result;
		}
			return $image;
	}

	private function resize($data)
	{
		$resize_lib['image_library'] = 'gd2';
		$resize_lib['source_image']	= './uploads/temp/'.$data['file_name'];
		$resize_lib['maintain_ratio'] = TRUE;
		$resize_lib['height']	= 225;
		$resize_lib['width']	= 200;
		$resize_lib['new_image'] = './uploads/temp/thumb/thumb_'.$data['file_name'];

	 	$this->CI->image_lib->initialize($resize_lib);
		$this->CI->image_lib->resize();
		$this->CI->image_lib->clear();
	}

	public function logfile($data)
	{
		$log = $this->CI->crud->insert('log_file', $data);
		return $log;
	}

}