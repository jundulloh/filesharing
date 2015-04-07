<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MyFeatures extends CI_Loader{
	protected $CI;
	public function __construct()
    {
    	$this->CI =& get_instance();
    	$this->CI->load->library('email');
    }	
	public function email($data)
	{
		
		if(empty($data['mail_to']) || empty($data['mail_from']) || empty($data['mail_name']) )
		{
			// var_dump($data['mail_to']);
			$result['callback_code'] = 500;
			$result['callback_text'] = 'Email not send! there are an empty requirements fields';
			return $data;
			// exit;
		}

		// ///////////////////////////////// INITIALIZE EMAIL ///////////////////////////////
		
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->CI->email->initialize($config);

		// ////////////////////////////////// END OF INITIALIZE ////////////////////////////


		$this->CI->email->clear(TRUE);
		$this->CI->email->from($data['mail_from'], $data['mail_name']);
		$this->CI->email->to($data['mail_to']); 
		// $this->email->cc('another@another-example.com'); 
		// $this->email->bcc('them@their-example.com'); 

		$this->CI->email->subject($data['mail_subject']);
		$this->CI->email->message($data['mail_text']);	
		if(isset($data['attach']))
		{
			foreach ($data['attach'] as $key => $value) {
				$this->CI->email->attach($value);
			}
		}

		$this->CI->email->send();
	}
	public function test()
	{
		return 'asdasd';
	}

	public function generate_hash()
	{
		$bytes 	= openssl_random_pseudo_bytes(mt_rand(0,11), $cstrong);
	    $hex   	= bin2hex($bytes);
		$hash 	= uniqid( strtotime(date('d-m-Y H:i:s')).$hex, true);
		return $hash; 
	} 

	public function generate_password($length = 0)
	{
		$pass = '';
		$deff = ($length == 0)?6 : $length;
		for ($i=0; $i < $deff; $i++) { 
			$pass .= rand(1,9);
		}
		return $pass;
	}

	public function copy_to($orig, $dir)
	{
		copy($orig, $dir);
	}

	public function checkdir($file)
	{

	}
}