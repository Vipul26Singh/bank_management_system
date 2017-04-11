<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->database();
        $this->load->model('Usermodel');
		/*cash control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         

    }
         
		//Method for view login page 
		public function index(){
	    if($this->session->userdata('logged_in')==TRUE){
        redirect('Admin/dashboard');    
        }
        $data=array();
		$this->load->view('theme/login');	
	   }

	   //Method for varify login information 
	   public function varifyUser(){
        if($this->session->userdata('logged_in')==TRUE){
        redirect('Admin/dashboard');    
        }
        $email=$this->input->post('email',true);
        $password=$this->input->post('password',true);
        if($this->Usermodel->login($email,md5($password))){
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('email',$email);
           $query = $this->db->get();
           $result = $query->row();
           if($result->visited ==0){
           $this->session->set_userdata('message','Please Fill this Fields First');echo 'true,1';}
        else{echo "true";}
        }else{
        echo "False";
        }

	   }
	   
	   //Method for logout
	   public function register($action=""){
	    if(get_current_setting('user_signup')=="no"){
		  redirect('User', 'refresh');
		}
	    if($action=="create"){
			$data=array();
			$do=$this->input->post('action',true);     
			$data['user_name']=$this->input->post('username',true);
			$data['fullname']=$this->input->post('fullname',true);  
			$data['email']=$this->input->post('email',true);  
			$data['user_type']="User";  
			$data['password']=md5($this->input->post('password',true));  
			$data['creation_date']=date("Y-m-d H:i:s");
	   
			//-----Validation-----//   
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]|is_unique[user.user_name]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');
			$this->form_validation->set_rules('fullname', 'FullName', 'trim|required|min_length[6]|max_length[30]');
			if (!$this->form_validation->run() == FALSE)
			{
			  if($this->db->insert('user',$data)){
				 $this->session->set_flashdata('success', 'Registration Sucessfully, You Can Login Now');
				 redirect('User', 'refresh');
			  }else{
				 $this->session->set_flashdata('error', 'Sorry, Registration Failed ! Please try again');
				 redirect('User/register', 'refresh');
			  }
			  
			}else{
			  $this->load->view('theme/register'); 
			}

		}else{
	   	 $this->load->view('theme/register');
	    }
	   
	   }

	   
	   //Method for logout
	   public function logout(){
	   	$this->Usermodel->logout();
	   	redirect('User');
	   }


}