<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in')==FALSE){
        redirect('User');    
        }
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->model('Languagemodel');

    }
	
	public function add_new_language(){
	
	  $this->form_validation->set_rules('language', 'Language', 'trim|required');
	  if (!$this->form_validation->run() == FALSE)
        {
		 $data=array();
		 if (!$this->db->field_exists(strtolower($this->input->post("language")), 'language')){
 
		 $this->load->dbforge();
		 $fields = array(strtolower($this->input->post("language")) => array('type' => 'TEXT'));
         $this->dbforge->add_column('language', $fields);	 
		 echo "true";
		 }else{
		  echo "Sorry, This Language Is Already Exists !";
		 }
		
		}else{
		 echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
		}
	}
	
	
	public function remove_language($column=""){
		if($column){
		 $this->dbforge->drop_column('language', $column);
		 echo "true";
		}else{
		show_404();
		}
	}
	
	public function edit_phrase($language,$action=""){
	    $data=array();
		$data['phraser']=$this->Languagemodel->get_all_phraser($language);
	    if($action=='asyn'){
          $this->load->view('theme/manage_language',$data);
        }else{    
	      $this->load->view('theme/include/header');
		  $this->load->view('theme/manage_language',$data);
		  $this->load->view('theme/include/footer');
        }
	}
	
	public function update_language($language){

	   foreach($_POST as $key => $value) 
    {
	    $data=array();
		$data[$language]=$value;
        $this->db->where('phrase',trim($key));
		$this->db->update('language',$data);
    }
	 echo "true";
	}
	
}