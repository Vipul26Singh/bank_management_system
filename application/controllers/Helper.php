<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helper extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->session->userdata('logged_in')==FALSE){
			redirect('User');    
		}
		$this->load->database();
		$this->load->model('Adminmodel');
	}

	public function index()
	{   
		;	
	}

	public function fetch_loan_types(){
		$this->db->select('*');
                                $this->db->from('bank_account_types');
				$this->db->where('status', '1');
                                $query = $this->db->get();
				$result=$query->result();
				echo json_encode($result);
				return json_encode($result);
	}

	public function get_fd_maturity(){
		$result = array();
		$interest = $this->input->post('interest');
		$duration_in_mnths = $this->input->post('duration');
		$principal = floor($this->input->post('principal'));
               
		$result['maturity_amount'] = floor($principal*pow((1+($interest/(100*4))), ((4*$duration_in_mnths)/12))); 
		$result['maturity_date'] = date('Y/m/d', strtotime('+'.$duration_in_mnths.' months'));;
		$result['maturity_interest'] = floor($result['maturity_amount']-$principal);

                echo json_encode($result);
	}
	
	public function get_loan_interest(){
		$result = array();
                $interest = $this->input->post('interest')/1200;
                $duration_in_mnths = $this->input->post('duration');
                $principal = floor($this->input->post('principal'));

                $result['emi'] = ceil($interest*$principal / (1-pow((1 + $interest), (-1*$duration_in_mnths))));
		$result['amount'] = ceil($result['emi']*$duration_in_mnths);
                $result['interest'] = floor($result['amount']-$principal);

                echo json_encode($result);
	}

	
}
