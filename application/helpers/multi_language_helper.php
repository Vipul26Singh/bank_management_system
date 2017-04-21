<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_phrase'))
{
	function get_phrase($phrase = '', $return_val = false)
	{
		$CI	=&	get_instance();
		$CI->load->database();
		$current_language	=	$CI->session->userdata('current_language');
		
		if($current_language	==	'')
		{
			$current_language	=	strtolower(get_current_setting('language'));
			$CI->session->set_userdata('current_language' , $current_language);
		}


		$query	=	$CI->db->get_where('language' , array('phrase' => $phrase));
		$row   	=	$query->row();
	
	
		//return $row->$current_language;
		if(isset($row->$current_language) && $row->$current_language !=""){
			if($return_val == true){
				return ucwords($row->$current_language);
			}else{
				echo ucwords($row->$current_language);
			}
		}
		else{ 
			if($return_val == true){
				return ucwords(str_replace('_',' ',$phrase));
			}
			else{
				echo ucwords(str_replace('_',' ',$phrase));	
			}
		}
	}
}


