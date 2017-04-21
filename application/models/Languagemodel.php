<?php

class Languagemodel extends CI_Model{

	function __construct()
    {
        parent::__construct();
    }

   
    public function get_all_language(){
	$this->load->database();
	return $this->db->list_fields('language');
	}
	
	public function get_all_phraser($language){
	$this->load->database();
	return $this->db->query("SELECT phrase_id,phrase,$language as p_value FROM language")->result();
	}

}