<?php

class BankData extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Adminmodel');
		$this->load->database();
	}
	public function show_all_member($action='')
	{
		$data['data'] = $this->Adminmodel->getAllAccountDetails();
		if($action=='asyn'){  
			$this->load->view('theme/show_all_member',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/show_all_member',$data);
			$this->load->view('theme/include/footer');
		}else if($action=='search'){
                        $data=array();
                        $mobile = $this->input->get('search_mobile');
                        $name = $this->input->get('search_name');

                        $data['data']=$this->Adminmodel->getAllAccountDetails($mobile,strtoupper($name));
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/show_all_member',$data);
                        $this->load->view('theme/include/footer');

                }
	}
	public function show_all_current_saving($action='')
	{
		$data=array();
		$data['data'] = $this->Adminmodel->getAllAccountCurrentSaving();
		if($action=='asyn'){  
			$this->load->view('theme/show_all_saving_current',$data);
		}else if($action==''){
		$this->load->view('theme/include/header');
		$this->load->view('theme/show_all_saving_current',$data);
		$this->load->view('theme/include/footer');
		}
	}
	public function editMember($accounts_id,$action='')
	{
		$data=array();
		$data['edit_account']=$this->Adminmodel->getMember($accounts_id);
		$data['account_type'] = $this->Adminmodel->get_account_types();
		$data['edit_member'] = $data['edit_account'];
		$data['photo_identity'] = $this->Adminmodel->get_identity();
           
		if($action=='asyn'){
			$this->load->view('theme/add_Member',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_Member',$data);
			$this->load->view('theme/include/footer');
		}     
	}
	public function deactivateMember($member_id,$action='')
        {
		$data = array();
                $data['status'] = 0;
                $this->db->where('member_id', $member_id);
                $this->db->update('member_details', $data);
                echo 1;

        }
}
?>
