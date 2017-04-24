<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->session->userdata('logged_in')==FALSE){
			redirect('User');    
		}
		$this->load->database();
		$this->load->model('Adminmodel');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->library('upload');
	}

	public function index()
	{   
		$data=array();
		$this->load->model('Reportmodel');
		$data['cart_summery']=$this->Reportmodel->getIncomeExpense();
		$data['line_chart']=$this->Reportmodel->dayByDayIncomeExpense();
		$data['latest_income']=$this->Adminmodel->getTransaction(5,'Income');
		$data['latest_expense']=$this->Adminmodel->getTransaction(5,'Expense');
		$data['pie_data']=$this->Reportmodel->sumOfIncomeExpense();
		$data['financialBalance']=$this->Reportmodel->financialBalance();
		$this->load->view('theme/include/header');
		$this->load->view('theme/index',$data);
		$this->load->view('theme/include/footer');
	}

	/** Method For dashboard **/ 
	public function dashboard($action='')
	{
		$data['visited'] = 1;
		$this->db->where('user_id',$_SESSION['user_id']);
		$this->db->update('user',$data);
		$this->session->unset_userdata('message');
		$data=array();
		$this->load->model('Reportmodel');
		$data['cart_summery']=$this->Reportmodel->getIncomeExpense();
		$data['line_chart']=$this->Reportmodel->dayByDayIncomeExpense();
		$data['latest_income']=$this->Adminmodel->getTransaction(5,'Income');
		$data['latest_expense']=$this->Adminmodel->getTransaction(5,'Expense');
		$data['pie_data']=$this->Reportmodel->sumOfIncomeExpense();
		$data['financialBalance']=$this->Reportmodel->financialBalance();
		if($action=='asyn'){
			$this->load->view('theme/index',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/index',$data);
			$this->load->view('theme/include/footer');
		}
	}

	/** Method For Add New Account and Account Page View **/ 	
	public function addMember($action='',$param1='')
	{
		$data['photo_identity'] = $this->Adminmodel->get_identity();
		if($action=='asyn'){
			$this->load->view('theme/add_Member',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_Member',$data);
			$this->load->view('theme/include/footer');
		}
		//----End Page Load------//
		//----For Insert update and delete-----// 
		$do = $this->input->post('action');
		if($action=='insert'){  
			$data=array();

			//$data['user_id']=$this->session->userdata('user_id');  
			$data['member_name']=strtoupper($this->input->post('member_name')); 
			$data['residential_address']=strtoupper($this->input->post('residential_address'));  
			$data['office_address']=strtoupper($this->input->post('office_address'));
			$data['city']=strtoupper($this->input->post('city')); 
			$data['pincode']=$this->input->post('pincode'); 
			$data['pancard_number']=$this->input->post('pancard_number');  
			$data['mobile_no']=$this->input->post('mobile_no');
			$data['state']=strtoupper($this->input->post('state'));
			$age=strtoupper($this->input->post('age'));  
			$data['email_id']=$this->input->post('email_id');  
			$data['photoidentity_type']=$this->input->post('photoidentity_type');
			$data['photoidentity_number']=$this->input->post('photoidentity_number');
			$data['birth_date']=$this->input->post('birth_date'); 
			$data['active_by']=$this->input->post('active_by'); 
			$data['gender']=$this->input->post('Gender'); 
			$data['opening_date']=$this->input->post('date');    
			$data['id_card_image'] = $_FILES['id_card_image']['name'];
			$data['member_photo'] = $_FILES['member_image']['name'];
			$data['status'] = 1;
			$data['share'] = 1;
			//-----Validation-----//   
			$this->form_validation->set_rules('member_name', 'Member Name', 'trim|required|min_length[4]|max_length[30]');
			$this->form_validation->set_rules('residential_address', 'Residential Address', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('birth_date', 'Date Of birth', 'trim|required');
			$this->form_validation->set_rules('age', 'Please Select Valid Age', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('active_by', 'Active By', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('office_address', 'Office Address', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('city', 'City', 'trim|required');
			$this->form_validation->set_rules('photoidentity_number', 'Photoidentity Number', 'trim|required');
			$this->form_validation->set_rules('photoidentity_type', 'Photoidentity Type', 'trim|required');
			$this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
			$this->form_validation->set_rules('pincode','Enter valid Pincode','max_length[6]|min_length[6]');
			$this->form_validation->set_rules('pancard_number', 'PanCard No', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('Gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('state', 'State', 'trim|required');

			$this->form_validation->set_rules('email_id', 'Email Id', 'trim|required');
			if (!$this->form_validation->run() == FALSE)
			{
				if($do=='insert'){ 
					//Check Duplicate Entry  

					if(!value_exists3("member_details","email_id",$data['email_id'])){
						if(!value_exists3("member_details","mobile_no",$data['mobile_no'])){
							$this->db->trans_begin();
							$this->db->insert('member_details',$data);   
							$id = $this->db->insert_id();

							$data['id_card_image'] = '';
							$data['member_photo'] = '';
							if (!empty($_FILES)){
								$temp = $_FILES["id_card_image"]["name"];

								if(!empty($temp)){
									$path_parts = pathinfo($temp);
									move_uploaded_file($_FILES['id_card_image']['tmp_name'],
											'uploads/'.'id_card_'.$id.'.'.$path_parts['extension']);
									$data['id_card_image'] = 'uploads/'.'id_card_'.$id.'.'.$path_parts['extension'];
								}


								$temp = $_FILES["member_image"]["name"];
								if(!empty($temp)){ 
									$path_parts = pathinfo($temp);
									move_uploaded_file($_FILES['member_image']['tmp_name'],'uploads/'.'member_photo'.$id.'.'.$path_parts['extension']);
									$data['member_photo'] = 'uploads/'.'member_photo'.$id.'.'.$path_parts['extension'];
								} 
							}
							//insert Transaction Data
							$this->db->where('member_id',$id);
							$this->db->update('member_details',$data);
							
							$decrement_error = $this->Adminmodel->decrease_bank_share();
							if($decrement_error!="success"){
								echo $decrement_error;
								die();
							}

							if ($this->db->trans_status() === FALSE)
							{
								echo get_phrase("database_error", true);
								$this->db->trans_rollback();
							}
							else
							{
								echo "true&".$id;
								$this->db->trans_commit();
							}

							

						}else{
							echo "Mobile No Already Exists !"; 
						}
					}
					else{ echo "Email Already Exists !";}

				}         
			}else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}
			//----End validation----//         
		}

		else if($do=='update'){
			$data=array();
			$id = $this->input->post('member_id');
			$data['member_name']=strtoupper($this->input->post('member_name')); 
			$data['residential_address']=strtoupper($this->input->post('residential_address'));  
			$data['office_address']=strtoupper($this->input->post('office_address'));
			$data['city']=strtoupper($this->input->post('city')); 
			$data['pincode']=$this->input->post('pincode'); 
			$data['pancard_number']=$this->input->post('pancard_number');  
			$data['mobile_no']=$this->input->post('mobile_no');
			$data['state']=strtoupper($this->input->post('state')); 
			$data['email_id']=$this->input->post('email_id');  
			$data['photoidentity_type']=$this->input->post('photoidentity_type');
			$data['photoidentity_number']=$this->input->post('photoidentity_number');
			$data['birth_date']=$this->input->post('birth_date'); 
			$data['active_by']=$this->input->post('active_by'); 
			$data['opening_date']=$this->input->post('date');

			$this->form_validation->set_rules('member_name', 'Member Name', 'trim|required|min_length[4]|max_length[30]');
			$this->form_validation->set_rules('residential_address', 'Residential Address', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('birth_date', 'Date Of birth', 'trim|required');
			$this->form_validation->set_rules('age', 'Please Select Valid Age', 'trim|required|integer');
			$this->form_validation->set_rules('mobile_no', 'Mobile Number', 'trim|required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('active_by', 'Active By', 'trim|required|is_natural_no_zero');
			$this->form_validation->set_rules('office_address', 'Office Address', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('city', 'City', 'trim|required');
			$this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
			$this->form_validation->set_rules('pincode','Enter valid Pincode','max_length[6]|min_length[6]');
			$this->form_validation->set_rules('pancard_number', 'PanCard No', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('state', 'State', 'trim|required');
			$this->form_validation->set_rules('pancard_number', 'PanCard No', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('email_id', 'Email Id', 'trim|required');
			if (!$this->form_validation->run() == FALSE)
			{      

				$old_name=getOld('member_id',$id,'member_details');
				$this->db->where('member_id', $id);
				$this->db->update('member_details', $data);
				echo "true";



			}else{
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}


		}
		else if($action=='remove'){    
			$this->db->delete('member_details', array('accounts_id' => $param1));        
		}$data = array();
		$data['data'] = $this->Adminmodel->getAllAccountDetails();
		$id = $this->input->get('id');
		if($id != '' && $this->input->post('mobile_no')==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/show_all_member',$data);
			$this->load->view('theme/include/footer');
		}

	}

	public function manageShare($action='',$param1=''){

		$data['member_detail'] = $this->Adminmodel->fetch_member_detail(null, 1);
                if($action=='asyn'){
                        $this->load->view('theme/manage_share',$data);
                }else if($action==''){
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/manage_share',$data);
                        $this->load->view('theme/include/footer');
                }

        }

	public function updateShare($action='', $member_id=''){
		if($action == 'view'){
                	$data['member_detail'] = $this->Adminmodel->fetch_member_detail($member_id, 1)[0];
                       	$this->load->view('theme/include/header');
                       	$this->load->view('theme/update_share',$data);
                       	$this->load->view('theme/include/footer');
		}else if($action == 'update'){
			$member_id = $this->input->get_post('member_id');	
			$new_share = $this->input->get_post('new_share');
			$old_share = $this->input->get_post('old_share');
		
			$this->form_validation->set_rules('member_id', 'Member id', 'trim|required');
                        $this->form_validation->set_rules('new_share', 'New Share', 'trim|required|numeric|greater_than_equal_to[0]');
                        $this->form_validation->set_rules('old_share', 'Old Share', 'trim|required|numeric');

                        if ($this->form_validation->run() == FALSE){
				echo validation_errors('', '');	
				die();
			}
			$is_success = $this->Adminmodel->updateMemberShare($member_id, $old_share, $new_share);
		
			if($is_success != "success"){
				echo $is_success;
				die();
			}
			echo "success";
		}

        }

	public function transferShare($action='',$param1=''){

                if($action=='asyn'){
                        $this->load->view('theme/transfer_share');
                }else if($action==''){
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/transfer_share');
                        $this->load->view('theme/include/footer');
                }

		if($action == 'transfer'){
			$from_member_id = $this->input->post('from_member_id', true);
			$from_member_name = $this->input->post('from_member_name', true);
			$from_member_share = $this->input->post('from_member_share', true);
			$to_member_id = $this->input->post('to_member_id', true);
			$to_member_name = $this->input->post('to_member_name', true);
			$to_member_share = $this->input->post('to_member_share', true);
			$user_id = $this->input->post('active_by', true);
			$transfer_share = $this->input->post('transfer_share', true);
			$transaction_remarks = $this->input->post('transaction_remarks', true);

			
			$this->form_validation->set_rules('from_member_name', 'From Member Id', 'trim|required');
			$this->form_validation->set_rules('to_member_name', 'To Member Id', 'trim|required');
			$this->form_validation->set_rules('from_member_share', 'From Member Share', 'trim|required');
			$this->form_validation->set_rules('to_member_share', 'To Member Share', 'trim|required');
			$this->form_validation->set_rules('transfer_share', 'Transfer Share', 'trim|required');
			$this->form_validation->set_rules('transaction_remarks', 'Transaction Remarks', 'trim|required');

                        if ($this->form_validation->run() == FALSE)
                        {
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
				die();
			}

			if($from_member_id == $to_member_id){
				echo '<span class="ion-android-alert failedAlert2"> Same memeber id not allowed </span>';
				die();
			}

			if($transfer_share > $from_member_share){
				echo '<span class="ion-android-alert failedAlert2"> Member does not have sufficient fund </span>';
                                die();
			}

			$result = null;
			$result = $this->Adminmodel->transferShare($from_member_id, $to_member_id, $transfer_share, $from_member_share, $to_member_share, $transaction_remarks);

			if($result != "success"){
				echo '<span class="ion-android-alert failedAlert2">'.$result.'</span>';
				die();
			}

			echo $result;
			die();
		}
        }

	public function withdrawFixedDeposit($action='',$param1=''){
		if($action=='asyn'){
                        $this->load->view('theme/withdraw_fixed_deposit');
                }else if($action==''){
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/withdraw_fixed_deposit');
                        $this->load->view('theme/include/footer');
                }

		else if($action == 'fetch_account_detail'){
			$accnt_no = $this->input->post('account_number', true);
			$result = $this->Adminmodel->getFdAccountDetail($accnt_no);

			if(empty($result)){
				echo $result;
			}else{
				$today = Date("Y-m-d H:i:s");
				$date = $result['maturity_date'];

				if ($date > $today){
					$result['pay_amount'] = $result['principal'];
				}else{
					$result['pay_amount'] = $result['maturity_amount'];
				}
				echo json_encode($result);
			}
		}else if($action == 'fetch_service_charge'){
			$account_id = $this->input->get_post('account_id', true);
		
			$result = $this->Adminmodel->fetch_service_charge($account_id);

			if(empty($result)){
				echo json_encode(array('remaining_charge'=>'0'));
			}else{
				echo json_encode($result[0]);
			}
		}else if($action == 'withdraw'){

			$account_number = $this->input->post('account_number', true);
			$pay_amount = $this->input->post('net_pay_amount', true);
			$service_charge = $this->input->post('service_charge', true);
			$member_id = $this->input->post('member_id', true);
			$maturity_amount = $this->input->post('maturity_amount', true);
			$transaction_remarks = $this->input->post('transaction_remarks', true);
			$current_user = $this->session->userdata('user_id');
			


			$this->form_validation->set_rules('account_number', 'Account Number', 'trim|required');
                        $this->form_validation->set_rules('member_id', 'Member Id', 'trim|required');
                        $this->form_validation->set_rules('net_pay_amount', 'Net Pay Amount', 'trim|required');
                        $this->form_validation->set_rules('maturity_amount', 'Maturity amount', 'trim|required');
                        $this->form_validation->set_rules('transaction_remarks', 'Transaction remarks', 'trim|required');

                        if ($this->form_validation->run() == FALSE)
                        {
                                echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
                                die();
                        }

			$account_detail = $this->Adminmodel->fetch_account_detail($account_number);
		
                        if(empty($account_detail)){
                                echo '<span class="ion-android-alert failedAlert2"> Invalid account number </span>';
                                die();
                        }


                        if($account_detail['status'] == 0){
                                echo '<span class="ion-android-alert failedAlert2"> Already withdrawn or account is inactive </span>';
                                die();
                        }

                        $account_type_detail = $this->Adminmodel->fetch_account_type_detail($account_detail['bank_account_id'])[0];

			if($account_type_detail['html_id']!=FD_SHORT_CODE){
				echo '<span class="ion-android-alert failedAlert2"> Account is not a fixed deposit </span>';
                                die();
			}

			$today = Date('Y-m-d H:i:s');

			$this->db->trans_begin();


			$this->db->set('status', '0');
			$this->db->set('deactivation_date', $today);
			$this->db->set('deactivated_by', $current_user);
			$this->db->set('deactivation_reason', $transaction_remarks);
			$this->db->where('bank_account_number', $account_number);
			$this->db->update('bank_accounts');

			$reference_id = $this->Adminmodel->logFundTrasaction($account_number, $member_id, $account_detail['bank_account_id'], $account_type_detail['html_id'], $account_type_detail['tbl_id'], FD_WITHDRAW, $pay_amount, null, $maturity_amount, 0, $transaction_remarks, null, TRANSACTION_MODE_CASH, null, null, null, null);


			$this->Adminmodel->deduct_fd_service($account_detail['id'], $service_charge);


			$this->Adminmodel->deactivate_service($account_detail['id']);


			if ($this->db->trans_status() === FALSE)
                	{
                        	$return['error'] = true;
                        	$return['error_message'][] = get_phrase('database_error', true);
                        	$this->db->trans_rollback();
                	}
                	else
                	{
                        	$this->db->trans_commit();
                	}		

			echo "success";

		}
	}


	public function transferFund($action='',$param1=''){

		if($action=='asyn'){
			$this->load->view('theme/transfer_fund');
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/transfer_fund');
			$this->load->view('theme/include/footer');
		}

		if($action == 'transfer'){

			$from_account_number = $this->input->post('from_account_number', true);
			$to_account_number = $this->input->post('to_account_number', true);
			$from_member_id = $this->input->post('from_member_id', true);
			$to_member_id = $this->input->post('to_member_id', true);
			$from_account_balance = $this->input->post('from_account_balance', true);
			$to_account_balance = $this->input->post('to_account_balance', true);
			$from_account_id = $this->input->post('from_account_id', true);
			$to_account_id = $this->input->post('to_account_id', true);
			$transfer_amount = $this->input->post('transfer_amount', true);
			$transaction_remarks = $this->input->post('transaction_remarks', true);


			$this->form_validation->set_rules('from_account_number', 'From Account Number', 'trim|required');
			$this->form_validation->set_rules('to_account_number', 'To Account Number', 'trim|required');
			$this->form_validation->set_rules('from_member_id', 'From Member Id', 'trim|required');
			$this->form_validation->set_rules('to_member_id', 'To Member Id', 'trim|required');
			$this->form_validation->set_rules('from_account_balance', 'From Account Number', 'trim|required');
			$this->form_validation->set_rules('to_account_balance', 'To Account Number', 'trim|required');
			$this->form_validation->set_rules('transfer_amount', 'Transfer Amount', 'trim|required');
			$this->form_validation->set_rules('transaction_remarks', 'Transaction Remarks', 'trim|required');

			if ($this->form_validation->run() == FALSE)
			{
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
				die();
			}

			if($from_account_number == $to_account_number){
				echo '<span class="ion-android-alert failedAlert2"> Tranfer within same account not allowed </span>';
				die();
			}

			if($transfer_amount < 1){
                                echo '<span class="ion-android-alert failedAlert2"> Tranfer amount can\'t be less than 1 </span>';
                                die();
                        }

			if($transfer_amount > $from_account_balance){
				echo '<span class="ion-android-alert failedAlert2"> Member does not have sufficient fund </span>';
				die();
			}

			$from_account_detail = $this->Adminmodel->fetch_account_detail($from_account_number);
			$to_account_detail = $this->Adminmodel->fetch_account_detail($to_account_number);

			if(empty($from_account_detail) || empty($to_account_detail)){
				echo '<span class="ion-android-alert failedAlert2"> Invalid account number </span>';
                                die();
			}

			if($from_account_detail['status'] == 0 || $to_account_detail['status'] == 0){
                                echo '<span class="ion-android-alert failedAlert2"> Account is inactive </span>';
                                die();
                        }

			$from_account_type_detail = $this->Adminmodel->fetch_account_type_detail($from_account_detail['bank_account_id'])[0];
			$to_account_type_detail = $this->Adminmodel->fetch_account_type_detail($to_account_detail['bank_account_id'])[0];


			$result = null;
			$result = $this->Adminmodel->transferFund($from_account_number, $from_member_id, $to_member_id, $to_account_number, $transfer_amount, $transaction_remarks, $from_account_balance, $to_account_balance, $from_account_id, $to_account_id, $from_account_type_detail['html_id'], $to_account_type_detail['html_id'], $from_account_type_detail['tbl_id'], $to_account_type_detail['tbl_id']);

			if($result != "success"){
				echo '<span class="ion-android-alert failedAlert2">'.$result.'</span>';
				die();
			}

			echo $result;
			die();
		}
	}

	public function addAccount($action='',$param1='')
        {

                $data['services'] = $this->Adminmodel->get_services();
                $data['account_type'] = $this->Adminmodel->get_account_types();
                $data['interest_detail'] = $this->Adminmodel->get_interest_detail();
		$data['fd_duration'] = $this->Adminmodel->get_general_detail('fd_duration');
		$data['loan_category_detail'] = $this->Adminmodel->get_general_detail('loan_category');

                if($action=='asyn'){
                        $this->load->view('theme/add_account',$data);
                }else if($action==''){
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/add_account',$data);
                        $this->load->view('theme/include/footer');
                }

		if($action=='insert'){
                        $data=array();
			$data['bank_account_id']=$this->input->post('bank_account_type',true);
			$this->form_validation->set_rules('bank_account_type', get_phrase('bank_account_type', true), 'trim|required');

                        if ($this->form_validation->run() == TRUE)
                        {
				$account_types = $this->Adminmodel->get_account_types();
				foreach($account_types as $account){
					if($data['bank_account_id'] == $account->tbl_id){
						switch ($account->html_id){
                                                        case "saving":
								$saving_data['bank_account_id'] = $data['bank_account_id'];
								$is_joint = $this->input->post('saving_joint',true);
								if($is_joint == "saving_joint"){
									$saving_data['is_joint'] = "YES";
								}else{
									$saving_data['is_joint'] = "NO";
								}
								$saving_data['member_id'] = $this->input->post('saving_member_id',true);
								$saving_data['member_name'] = $this->input->post('saving_member_name',true);
								$saving_data['member_id_2'] = $this->input->post('saving_member_id_2',true);
								$saving_data['member_name_2'] = $this->input->post('saving_member_name_2',true);
								$temp = $this->input->post('saving_interest', true);
                                                                if(!empty($temp)){
                                                                $temp_interest = json_decode($temp, true);

                                                                $saving_data['interest'] = $temp_interest['id'];
                                                                }else{
                                                                        $saving_data['interest'] = null;
                                                                }
								$saving_data['account_balance'] = $this->input->post('saving_account_balance',true);
								$saving_data['opening_date'] = $this->input->post('date',true);
								$saving_data['user_id'] = $this->input->post('active_by',true); 

								$val = $this->add_saving_acccount($saving_data);

								if($val['error'] ===  true){
									$val['error'] = "true";
									$error_json['error'] = "true";
									$error_json['error_message'] = "";
									foreach($val['error_message'] as $error){
										$error_json['error_message'] = $error_json['error_message'].'<span class="ion-android-alert failedAlert2"> ' . $error . '</span>';
									}
									echo json_encode($error_json);
								}else{
									$val['error'] = "false";
									echo json_encode($val);
								}
                                                                break;
                                                        case "current":
								$current_data['bank_account_id'] = $data['bank_account_id'];
                                                                $is_joint = $this->input->post('current_joint',true);

                                                                if($is_joint == "current_joint"){
                                                                        $current_data['is_joint'] = "YES";
                                                                }else{
                                                                        $current_data['is_joint'] = "NO";
                                                                }
                                                                $current_data['member_id'] = $this->input->post('current_member_id',true);
                                                                $current_data['member_name'] = $this->input->post('current_member_name',true);
                                                                $current_data['member_id_2'] = $this->input->post('current_member_id_2',true);
                                                                $current_data['member_name_2'] = $this->input->post('current_member_name_2',true);
								$temp = $this->input->post('current_interest', true);
								if(!empty($temp)){
								$temp_interest = json_decode($temp, true);
								
                                                               	$current_data['interest'] = $temp_interest['id'];
								}else{
									$current_data['interest'] = null;
								}
                                                                $current_data['account_balance'] = $this->input->post('current_account_balance',true);
                                                                $current_data['opening_date'] = $this->input->post('date',true);
                                                                $current_data['user_id'] = $this->input->post('active_by',true);

                                                                $val = $this->add_current_acccount($current_data);

                                                                if($val['error'] ===  true){
									$val['error'] = "true";
                                                                        $error_json['error'] = "true";
                                                                        $error_json['error_message'] = "";
                                                                        foreach($val['error_message'] as $error){
                                                                                $error_json['error_message'] = $error_json['error_message'].'<span class="ion-android-alert failedAlert2"> ' . $error . '</span>';
                                                                        }
                                                                        echo json_encode($error_json);

                                                                }else{
									$val['error'] = "false";
									echo json_encode($val);
                                                                }

                                                                break;
                                                        case "loan":
								$loan_data['bank_account_id'] = $data['bank_account_id'];
                                                                $is_joint = $this->input->post('loan_joint',true);
                                                                if($is_joint == "loan_joint"){
                                                                        $loan_data['is_joint'] = "YES";
                                                                }else{
                                                                        $loan_data['is_joint'] = "NO";
                                                                }
                                                                $loan_data['member_id'] = $this->input->post('loan_member_id',true);
                                                                $loan_data['member_name'] = $this->input->post('loan_member_name',true);
                                                                $loan_data['member_id_2'] = $this->input->post('loan_member_id_2',true);
                                                                $loan_data['member_name_2'] = $this->input->post('loan_member_name_2',true);
								$loan_data['introducer_1_id'] = $this->input->post('loan_introducer_id',true);
								$loan_data['introducer_1_name'] = $this->input->post('loan_introducer_name',true);
								$loan_data['introducer_2_id'] = $this->input->post('loan_introducer_id_2',true);
								$loan_data['introducer_2_name'] = $this->input->post('loan_introducer_name_2',true);
								$loan_data['loan_category'] = $this->input->post('loan_category',true);
                                                                $temp = $this->input->post('loan_interest', true);
                                                                if(!empty($temp)){
                                                                $temp_interest = json_decode($temp, true);

                                                                $loan_data['interest'] = $temp_interest['id'];
                                                                }else{
                                                                        $loan_data['interest'] = null;
                                                                }
                                                                $loan_data['principal'] = $this->input->post('loan_amount',true);
								$loan_data['duration_in_months'] = $this->input->post('loan_tenure',true);
                                                                $loan_data['remarks'] = $this->input->post('loan_remarks',true);
                                                                $loan_data['monthly_emi'] = $this->input->post('loan_emi',true);
								$loan_data['payable_amount'] = $this->input->post('loan_amount_payable',true);
								$loan_data['billing_date'] = $this->input->post('loan_billing_date',true);
								$loan_data['pay_by_days'] = $this->input->post('loan_pay_by_days',true);
								$loan_data['auto_deduct'] = $this->input->post('loan_auto_deduct',true);
								$loan_data['linked_account'] = $this->input->post('loan_linked_account',true);
                                                                $loan_data['opening_date'] = $this->input->post('date',true);
                                                                $loan_data['user_id'] = $this->input->post('active_by',true);
								$loan_data['amount_paid'] = $loan_data['payable_amount'];
                                                                $val = $this->add_loan_account($loan_data);
                                                                if($val['error'] ===  true){
                                                                        $val['error'] = "true";
                                                                        $error_json['error'] = "true";
                                                                        $error_json['error_message'] = "";
                                                                        foreach($val['error_message'] as $error){
                                                                                $error_json['error_message'] = $error_json['error_message'].'<span class="ion-android-alert failedAlert2"> ' . $error . '</span>';
                                                                        }
                                                                        echo json_encode($error_json);
                                                                }else{
                                                                        $val['error'] = "false";
                                                                        echo json_encode($val);
                                                                }

                                                                break;
                                                        case "fd":
								$fd_data['bank_account_id'] = $data['bank_account_id'];
                                                                $is_joint = $this->input->post('fd_joint',true);

                                                                if($is_joint == "fd_joint"){
                                                                        $fd_data['is_joint'] = "YES";
                                                                }else{
                                                                        $fd_data['is_joint'] = "NO";
                                                                }
                                                                $fd_data['member_id'] = $this->input->post('fd_member_id',true);
                                                                $fd_data['member_name'] = $this->input->post('fd_member_name',true);
                                                                $fd_data['member_id_2'] = $this->input->post('fd_member_id_2',true);
                                                                $fd_data['member_name_2'] = $this->input->post('fd_member_name_2',true);
								$temp = $this->input->post('fd_interest', true);
                                                                if(!empty($temp)){
                                                                $temp_interest = json_decode($temp, true);

                                                                $fd_data['interest'] = $temp_interest['id'];
                                                                }else{
                                                                        $fd_data['interest'] = null;
                                                                }

                                                                $fd_data['principal'] = $this->input->post('fd_account_balance',true);
                                                                $fd_data['opening_date'] = $this->input->post('date',true);
                                                                $fd_data['user_id'] = $this->input->post('active_by',true);
								$fd_data['duration_in_months'] = $this->input->post('fd_duration',true);
								$fd_data['maturity_date'] = $this->input->post('fd_maturity_date',true);
								$fd_data['maturity_amount'] = $this->input->post('fd_maturity_amount',true);

                                                                $val = $this->add_fd_acccount($fd_data);

                                                                if($val['error'] ===  true){
									$val['error'] = "true";
                                                                        $error_json['error'] = "true";
                                                                        $error_json['error_message'] = "";
                                                                        foreach($val['error_message'] as $error){
                                                                                $error_json['error_message'] = $error_json['error_message'].'<span class="ion-android-alert failedAlert2"> ' . $error . '</span>';
                                                                        }
                                                                        echo json_encode($error_json);

                                                                }else{
									$val['error'] = "false";
                                                                	echo json_encode($val);
								}
                                                                break;
							case "rd":

								break;
                                                        default:
								echo json_encode(array('error'=>'true', 'error_message'=>'<span class="ion-android-alert failedAlert2"> Invalid account type </span>'));	
                                                }  
					} 
				}

			}else{
				echo json_encode(array('error'=>'true', 'error_message'=>validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>')));

                        }
                }
        }

	private function add_saving_acccount($data){
		$return = array();
		$return['error'] = false;
		$return['error_message'] = array();

		if(empty($data['member_name'])){
			$return['error'] = true;
			$return['error_message'][] = get_phrase('invalid_member_id', true);	
		}


		if($data['is_joint'] == "YES"){
			if(empty($data['member_name_2'])){
				$return['error'] = true; 
				$return['error_message'][] = get_phrase('invalid_second_member_id', true);
			}

			if($data['member_id'] == $data['member_id_2']){
				$return['error'] = true; 
                                $return['error_message'][] = get_phrase('same_joint_member', true);
			}
		}

		if(empty($data['interest'])){
			$return['error'] = true; 
			$return['error_message'][] = get_phrase('select_interest', true);
		}

		if(empty($data['account_balance']) || !is_numeric($data['account_balance'])){
			$return['error'] = true;
			$return['error_message'][] = get_phrase('invalid_account_balance', true);
		}

		if(empty($data['user_id'])){
			$return['error'] = true;
			$return['error_message'][] = get_phrase('select_acive_by', true);
		}

		if($return['error'] == true){
			return $return;
		}

		$accnt_prefix = $this->Adminmodel->get_general_detail('accnt_gen', 'saving');
		
		$number_prefix = $this->Adminmodel->get_sequence('saving');

		$accnt_number = $accnt_prefix.$number_prefix; 

		if(empty($accnt_number) || strlen($accnt_number) < 10){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('internal_error', true);
			return $return;
                }

		$accnt_data['user_id'] = $data['user_id'];
		$accnt_data['bank_account_id'] = $data['bank_account_id'];
		$accnt_data['bank_account_number'] = $accnt_number; 
		$accnt_data['opening_date'] = date("Y-m-d H:i:s");
		$accnt_data['status'] = 1;
		
		$saving_data['interest_id'] = $data['interest']; 
		$saving_data['balance'] = $data['account_balance'];
		

		if($data['is_joint'] == "YES"){
			$accnt_data['joint'] = 1;
		}else{
			$accnt_data['joint'] = 0;
		}

		$member_data['allotment_date'] = date("Y-m-d H:i:s");



	
		$this->db->trans_begin();


		$this->db->insert('bank_accounts', $accnt_data);




		$accnt_id = $this->db->insert_id();
		$saving_data['account_id'] = $accnt_id;
		$this->db->insert('bank_account_saving', $saving_data);
		$member_data['account_id'] = $accnt_id;
		$member_data['member_id'] = $data['member_id'];
		$this->db->insert('bank_member_account', $member_data);


		if($data['is_joint'] == "YES"){
			$member_data['member_id'] = $data['member_id_2'];
			$this->db->insert('bank_member_account', $member_data);
		}
		if ($this->db->trans_status() === FALSE)
		{
			$return['error'] = true;
                        $return['error_message'][] = get_phrase('database_error', true);
        		$this->db->trans_rollback();
		}
		else
		{
        		$this->db->trans_commit();
		}

		$return['accnt_no'] = $accnt_number;
		
		return $return;
	}

	private function add_current_acccount($data){
                $return = array();
                $return['error'] = false;
                $return['error_message'] = array();
		$return['accnt_no'] = null;

                if(empty($data['member_name'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_member_id', true);
                }

                if($data['is_joint'] == "YES"){
                        if(empty($data['member_name_2'])){
                                $return['error'] = true;
                                $return['error_message'][] = get_phrase('invalid_second_member_id', true);
                        }

                        if($data['member_id'] == $data['member_id_2']){
                                $return['error'] = true;
                                $return['error_message'][] = get_phrase('same_joint_member', true);
                        }
                }

                if(empty($data['interest'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('select_interest', true);
                }

                if(empty($data['account_balance']) || !is_numeric($data['account_balance'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_account_balance', true);
                }

                if(empty($data['user_id'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('select_acive_by', true);
                }

                if($return['error'] == true){
                        return $return;
                }
		$accnt_prefix = $this->Adminmodel->get_general_detail('accnt_gen', 'current');
                $number_prefix = $this->Adminmodel->get_sequence('current');

                $accnt_number = $accnt_prefix.$number_prefix;

                if(empty($accnt_number) || strlen($accnt_number) < 10){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('internal_error', true);
                        return $return;
                }

                $accnt_data['user_id'] = $data['user_id'];
                $accnt_data['bank_account_id'] = $data['bank_account_id'];
                $accnt_data['bank_account_number'] = $accnt_number;
                $accnt_data['opening_date'] = date("Y-m-d H:i:s");
                $accnt_data['status'] = 1;

                $current_data['interest_id'] = $data['interest'];
                $current_data['balance'] = $data['account_balance'];


                if($data['is_joint'] == "YES"){
                        $accnt_data['joint'] = 1;
                }else{
                        $accnt_data['joint'] = 0;
                }

                $member_data['allotment_date'] = date("Y-m-d H:i:s");

                $this->db->trans_begin();
                $this->db->insert('bank_accounts', $accnt_data);
                $accnt_id = $this->db->insert_id();
                $current_data['account_id'] = $accnt_id;
                $this->db->insert('bank_account_current', $current_data);
                $member_data['account_id'] = $accnt_id;
                $member_data['member_id'] = $data['member_id'];
                $this->db->insert('bank_member_account', $member_data);

                if($data['is_joint'] == "YES"){
                        $member_data['member_id'] = $data['member_id_2'];
                        $this->db->insert('bank_member_account', $member_data);
                }

		if ($this->db->trans_status() === FALSE)
                {
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('database_error', true);
                        $this->db->trans_rollback();
                }
                else
                {
                        $this->db->trans_commit();
                }

		$return['accnt_no'] = $accnt_number;
                return $return;
        }


	private function add_fd_acccount($data){
                $return = array();
                $return['error'] = false;
                $return['error_message'] = array();


                if(empty($data['member_name'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_member_id', true);
                }

                if($data['is_joint'] == "YES"){
                        if(empty($data['member_name_2'])){
                                $return['error'] = true;
                                $return['error_message'][] = get_phrase('invalid_second_member_id', true);
                        }

                        if($data['member_id'] == $data['member_id_2']){
                                $return['error'] = true;
                                $return['error_message'][] = get_phrase('same_joint_member', true);
                        }
                }

                if(empty($data['interest'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('select_interest', true);
                }

                if(empty($data['principal']) || !is_numeric($data['principal'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_deposit_amount', true);
                }

                if(empty($data['user_id'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('select_acive_by', true);
                }

		if(empty($data['duration_in_months'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('missing_duration', true);
                }

		if(empty($data['maturity_date'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_maturity_date', true);
                }

		if(empty($data['maturity_amount'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('missing_maturity_amount', true);
                }

                if($return['error'] == true){
                        return $return;
                }



		$accnt_prefix = $this->Adminmodel->get_general_detail('accnt_gen', 'fd');
                $number_prefix = $this->Adminmodel->get_sequence('fd');

                $accnt_number = $accnt_prefix.$number_prefix;

                if(empty($accnt_number) || strlen($accnt_number) < 10){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('internal_error', true);
                        return $return;
                }

                $accnt_data['user_id'] = $data['user_id'];
                $accnt_data['bank_account_id'] = $data['bank_account_id'];
                $accnt_data['bank_account_number'] = $accnt_number;
                $accnt_data['opening_date'] = date("Y-m-d H:i:s");
                $accnt_data['status'] = 1;

                $fd_data['interest_id'] = $data['interest'];
                $fd_data['principal'] = $data['principal'];
		$fd_data['duration_in_months'] = $data['duration_in_months'];
		$fd_data['maturity_date'] = $data['maturity_date'];
		$fd_data['maturity_amount'] = $data['maturity_amount'];


                if($data['is_joint'] == "YES"){
                        $accnt_data['joint'] = 1;
                }else{
                        $accnt_data['joint'] = 0;
                }

                $member_data['allotment_date'] = date("Y-m-d H:i:s");

                $this->db->trans_begin();
                $this->db->insert('bank_accounts', $accnt_data);
                $accnt_id = $this->db->insert_id();
                $fd_data['account_id'] = $accnt_id;
                $this->db->insert('bank_account_fd', $fd_data);
                $member_data['account_id'] = $accnt_id;
                $member_data['member_id'] = $data['member_id'];
		$this->db->insert('bank_member_account', $member_data);

                if($data['is_joint'] == "YES"){
                        $member_data['member_id'] = $data['member_id_2'];
                        $this->db->insert('bank_member_account', $member_data);
                }

		if ($this->db->trans_status() === FALSE)
                {
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('database_error', true);
                        $this->db->trans_rollback();
                }
                else
                {
                        $this->db->trans_commit();
                }

		$return['accnt_no'] = $accnt_number;
                return $return;
        }

	public function add_loan_account($data){
		$return = array();
                $return['error'] = false;
                $return['error_message'] = array();


                if(empty($data['member_name']) || !is_numeric($data['member_id'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_member_id', true);
                }

                if($data['is_joint'] == "YES"){
                        if(empty($data['member_name_2']) || !is_numeric($data['member_id_2'])){
                                $return['error'] = true;
                                $return['error_message'][] = get_phrase('invalid_second_member_id', true);
                        }

                        if($data['member_id'] == $data['member_id_2']){
                                $return['error'] = true;
                                $return['error_message'][] = get_phrase('same_joint_member', true);
                        }
                }

		if(empty($data['introducer_1_name']) || !is_numeric($data['introducer_1_id'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_introducer_id', true);
                }

		if(empty($data['introducer_2_name']) || !is_numeric($data['introducer_2_id'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_second_introducer_id', true);
                }


		$all_member = array($data['member_id'], $data['member_id_2'], $data['introducer_1_id'], $data['introducer_2_id']);

		for ($i = 0; $i < count($all_member)-1; $i++) {
			if($all_member[$i] == $all_member[$i+1]){
				$return['error'] = true;
				$return['error_message'][] = get_phrase('conflict_in_introducer_and_account_holder', true);
				break;
			}
		}

		if(empty($data['loan_category'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('select_loan_type', true);
                }

                if(empty($data['interest']) || !is_numeric($data['interest'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_interest', true);
                }

                if(empty($data['principal']) || !is_numeric($data['principal'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_loan_amount', true);
                }

                if(empty($data['user_id'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('select_acive_by', true);
                }

                if(empty($data['duration_in_months']) || !is_numeric($data['duration_in_months'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('missing_duration', true);
                }

		if(empty($data['monthly_emi'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('missing_monthly_emi', true);
                }

                if(empty($data['payable_amount'])){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('missing_payable_amount', true);
                }

		if(empty($data['billing_date']) || !is_numeric($data['billing_date']) || $data['billing_date']<1 || $data['billing_date']>28){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('missing_billing_date', true);
                }

		if(empty($data['pay_by_days']) || !is_numeric($data['pay_by_days']) || $data['pay_by_days']<0 || $data['pay_by_days']>28 ){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('select_pay_by_days_less_than_15', true);
                }

		if(!empty($data['auto_deduct']) && (empty($data['linked_account']) || !$this->Adminmodel->is_linked_account($data['member_id'], $data['linked_account'], 'saving'))){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_linked_account', true);
                }

		if(empty($data['amount_paid']) || !is_numeric($data['amount_paid'])){
			$return['error'] = true;
                        $return['error_message'][] = get_phrase('invalid_amount_paid', true);
		} 

                if($return['error'] == true){
                        return $return;
                }

		if(!empty($data['auto_deduct'])){
			$linked_account_id = $this->Adminmodel->fetch_account_detail($data['linked_account']);
			$data['linked_account_id'] = $linked_account_id['id'];
			if(empty($data['linked_account_id'])){
				$return['error'] = true;
				$return['error_message'][] = get_phrase('invalid_linked_account', true);
				return $return;
			}
		}

		



                $accnt_prefix = $this->Adminmodel->get_general_detail('accnt_gen', 'loan');
                $number_prefix = $this->Adminmodel->get_sequence('loan');

                $accnt_number = $accnt_prefix.$number_prefix;

                if(empty($accnt_number) || strlen($accnt_number) < 10){
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('internal_error', true);
                        return $return;
                }

                $accnt_data['user_id'] = $data['user_id'];
                $accnt_data['bank_account_id'] = $data['bank_account_id'];
                $accnt_data['bank_account_number'] = $accnt_number;
                $accnt_data['opening_date'] = date("Y-m-d H:i:s");
                $accnt_data['status'] = 1;


		$loan_data['interest_id'] = $data['interest'];
                $loan_data['principal'] = $data['principal'];
                $loan_data['payable_amount'] = $data['payable_amount'];
                $loan_data['duration_in_months'] = $data['duration_in_months'];
                $loan_data['introducer_1_id'] = $data['introducer_1_id'];
                $loan_data['introducer_2_id'] = $data['introducer_2_id'];
                $loan_data['loan_category'] = $data['loan_category'];
                $loan_data['monthly_emi'] = $data['monthly_emi'];
                $loan_data['billing_date'] = $data['billing_date'];
                $loan_data['pay_by_days'] = $data['pay_by_days'];
		$loan_data['amount_paid'] = $data['amount_paid'];
		if(!empty($data['auto_deduct'])){
			$loan_data['linked_account_id'] = $data['linked_account_id'];
                }

		if(empty($data['remarks'])){
			$loan_data['remarks'] = null;
		}else{
			$loan_data['remarks'] = null;
		}

		if(!empty($data['auto_deduct'])){
			$loan_data['auto_deduct'] = 1;
		}else{
			$loan_data['auto_deduct'] = 0;
		}

		if($data['is_joint'] == "YES"){
                        $accnt_data['joint'] = 1;
                }else{
                        $accnt_data['joint'] = 0;
                }

                $member_data['allotment_date'] = date("Y-m-d H:i:s");


                $this->db->trans_begin();



                $this->db->insert('bank_accounts', $accnt_data);
                $accnt_id = $this->db->insert_id();


		$loan_data['account_closing_date'] = date('Y/m/d');
		//$loan_data['account_closing_date'] = date('Y/m/d', strtotime($this->Adminmodel->generate_loan_installments($accnt_id, $loan_data['billing_date'], $loan_data['pay_by_days'], $loan_data['monthly_emi'], $loan_data['duration_in_months'])));
		$this->Adminmodel->generate_loan_installments($accnt_id, $loan_data['billing_date'], $loan_data['pay_by_days'], $loan_data['monthly_emi'], $loan_data['duration_in_months']);

                $loan_data['account_id'] = $accnt_id;
                $this->db->insert('bank_account_loan', $loan_data);

                $member_data['account_id'] = $accnt_id;
                $member_data['member_id'] = $data['member_id'];
                	$this->db->insert('bank_member_account', $member_data);
                if($data['is_joint'] == "YES"){
                        $member_data['member_id'] = $data['member_id_2'];
                        	$this->db->insert('bank_member_account', $member_data);
		}


		if ($this->db->trans_status() === FALSE)
                {
                        $return['error'] = true;
                        $return['error_message'][] = get_phrase('database_error', true);
                        $this->db->trans_rollback();
                }
                else
                {
                        $this->db->trans_commit();
                }

                $return['accnt_no'] = $accnt_number; 
                return $return;
		
	}



	public function addAccount_old($action='',$param1='')
	{

		$data['services'] = $this->Adminmodel->get_services();
		$data['account_type'] = $this->Adminmodel->get_account_types();
		$data['interest_detail'] = $this->Adminmodel->get_interest_detail();
		if($action=='asyn'){
			$this->load->view('theme/add_account',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_account',$data);
			$this->load->view('theme/include/footer');
		}
		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){ 
			$data=array();
			$this->db->select('COUNT(*) as row');
			$this->db->from('bank_accounts');
			$query = $this->db->get();
			$row_return=$query->row();
			if($row_return->row == 0){
				$data['bank_account_number'] = $this->id_gen('110','',0);}
			else{
				$this->db->select('bank_account_number');
				$this->db->from('bank_accounts');
				$this->db->order_by('bank_account_number','desc');
				$this->db->limit(1);
				$query = $this->db->get();
				$bank_account_number = $query->row();
				$data['bank_account_number'] = $this->id_gen('110',$bank_account_number->bank_account_number,1);}
			$do=$this->input->post('action',true);     
			$data['member_id']=$this->input->post('member_id',true);
			$data['user_id']=$this->session->userdata('user_id');
			$data['bank_account_type']=$this->input->post('bank_account_type',true);  
			//$data['bank_account_number']=$this->input->post('bank_account_number',true);  
			$data['account_balance']=$this->input->post('account_balance',true);
			//$data['share_id']=$data['member_id'];
			$data['opening_date'] = Date('Y-m-d');
			//-----Validation-----//   
			$this->form_validation->set_rules('member_id', 'Member Id', 'trim|required|min_length[1]|max_length[30]');
			$this->form_validation->set_rules('bank_account_type', 'Bank Account Type', 'trim|required');
			//$this->form_validation->set_rules('bank_account_number', 'Bank Account Number', 'trim|required');
			$this->form_validation->set_rules('account_balance', 'Account Balance', 'trim|required');

			if (!$this->form_validation->run() == FALSE)
			{
				if($do=='insert'){ 
					//Check Duplicate Entry  
					$data['status']=1;
					if(!$this->invalid_account($data['member_id'], $data['bank_account_type'])){        

						$this->db->trans_begin();
						$this->db->insert('bank_accounts',$data);
						$this->db->insert_id();
						$data1['share_id'] = $data['member_id'];
						$data1['member_id'] = $data['member_id'];
						$data1['share_amount'] = 0;
						$data1['payment_type'] = 0;
						$data1['date'] = Date('Y-m-d');
						$this->db->insert('bank_share',$data1);   
						//insert Transaction Data
						$this->db->trans_complete();
						if ($this->db->trans_status() === FALSE)
						{
							$this->db->trans_rollback();
						}
						else
						{
							echo "true";
							$this->db->trans_commit();
						}

					}else{
						echo "This Account Is Already Exists !"; 
					}
				}         
			}else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}
			//----End validation----//         
		}
		else if($action=='update'){
			$id=$this->input->post('member_id',true);
			$data = array();
			$data['bank_account_type']= $this->input->post('bank_account_type');
			$data['bank_account_number']=$this->input->post('bank_account_number');
			$data['account_balance']=$this->input->post('account_balance');

			$this->form_validation->set_rules('bank_account_type','Bank Account Type','trim|required');

			if(!$this->form_validation->run()==FALSE){
				$this->db->where('member_id', $id);
				$this->db->update('bank_accounts', $data);
				//transaction table
				// $data1=array();
				// $this->db->where('member_id', $id);
				// $this->db->update('transaction', $data1);

				// //repeat transaction table
				// $data2=array();
				// $data2['member_name']=$this->input->get('member_name');
				// $this->db->where('member_name', $old_name->accounts_name);
				// $this->db->where('member_id', $id);
				// $this->db->update('repeat_transaction', $data2);

				echo "true";


			}else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}


		}
		else if($action=='deactivate'){    
			$data = array();
			$data['status'] = 0;
			$this->db->where('member_id', $param1);
			$this->db->update('bank_accounts', $data);   
			echo 1;
		}
		else if($action=='activate'){ 
			$data = array();
			$data['status'] = 1;
			$this->db->where('member_id', $param1);
			$this->db->update('bank_accounts', $data);
			echo 0 ;
		}
	}

	/** Method For insert Transaction when new account create **/ 
	public function insertTransaction($account,$amount)
	{
		$data=array();
		$data['accounts_name']=$account; 
		$data['trans_date']=date("Y-m-d");
		$data['type']='Transfer'; 
		$data['category']=''; 
		$data['amount']=$amount; 
		$data['payer']='System'; 
		$data['payee']=''; 
		$data['p_method']=''; 
		$data['ref']=''; 
		$data['note']='Opening Balance';  
		$data['dr']=0;  
		$data['cr']=$amount;
		$data['bal']=$amount;
		$data['user_id']=$this->session->userdata('user_id');		
		$this->db->insert('transaction',$data);

	}

	public function manageAccountService($action='', $accnt_id='', $service_id=''){
		$data=array();
                if($action=='asyn'){
                        $data['accounts']=$this->Adminmodel->get_account_service_detail(null, null, null, '1', '1');
                        $this->load->view('theme/manage_account_service',$data);
                }else if($action==''){
			$data['accounts']=$this->Adminmodel->get_account_service_detail(null, null, null, '1', '1');
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/manage_account_service',$data);
                        $this->load->view('theme/include/footer');
                }else if($action == 'deactivate'){
			$this->Adminmodel->deactivate_service($accnt_id, $service_id);
                        echo 1;
                }else if($action == 'view'){
			$data['accounts']=$this->Adminmodel->get_account_service_detail($accnt_id, null, $service_id, '1', '1');
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/view_account_service',$data);
                        $this->load->view('theme/include/footer');
                }else if($action=='search'){
                        $data=array();
                        $account_number = $this->input->get_post('search_account_number');
                        $member_name = $this->input->get_post('search_member_name');


				$data['accounts']=$this->Adminmodel->get_account_service_detail(null, null, null, '1', '1', null, $account_number, $member_name);
                                $this->load->view('theme/include/header');
                                $this->load->view('theme/manage_account_service',$data);
                                $this->load->view('theme/include/footer');

                }
	}
	/** Method For view Manage Account Page **/ 

	public function manageAccount($action='', $accnt_no='', $status = '1')
	{
		$empty_str = '';
		$data=array();  
		if($action=='asyn'){ 
			$data['accounts']=$this->Adminmodel->fetch_account_view_detail($empty_str, $empty_str, '1');
			$this->load->view('theme/manage_account',$data);   
		}else if($action==''){
			$data['accounts']=$this->Adminmodel->fetch_account_view_detail($empty_str, $empty_str, '1');
			$this->load->view('theme/include/header');
			$this->load->view('theme/manage_account',$data);
			$this->load->view('theme/include/footer');
		}else if($action == 'deactivate'){
			$data = array();
                	$data['status'] = 0;
                	$this->db->where('bank_account_number', $accnt_no);
                	$this->db->update('bank_accounts', $data);
                	echo 1;
		}else if($action == 'activate'){
                        $data = array();
                        $data['status'] = 1;
                        $this->db->where('bank_account_number', $accnt_no);
                        $this->db->update('bank_accounts', $data);
                        echo 1;
                }else if($action == 'view'){
			$data['accounts']=$this->Adminmodel->fetch_account_view_detail($accnt_no, $empty_str, $status);	
			$this->load->view('theme/include/header');
                        $this->load->view('theme/view_account',$data);
                        $this->load->view('theme/include/footer');
		
		}else if($action == 'deactivateList'){
			$data['accounts']=$this->Adminmodel->fetch_account_view_detail($empty_str, $empty_str, '0');
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/manage_deactivated_account',$data);
                        $this->load->view('theme/include/footer');
		}else if($action=='search'){
			$data=array();
			$id = strtoupper($this->input->get('search'));
			$name = strtoupper($this->input->get('search_name'));

				$data['accounts']=$this->Adminmodel->fetch_account_view_detail(null, null, null, null, $id, $name);
				$this->load->view('theme/include/header');
				$this->load->view('theme/manage_account',$data);
				$this->load->view('theme/include/footer');

		}
	}

	

	public function manageMember($action='')
	{
		$data=array();
		$data['accounts']=$this->Adminmodel->getAllAccounts();
		if($action=='asyn'){
			$this->load->view('theme/manage_member',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/manage_member',$data);
			$this->load->view('theme/include/footer');
                }
	}


	/** Method For get account information for Account Edit **/ 
	public function editAccount($accounts_id,$action='')
	{
		$data=array();
		$data['edit_account']=$this->Adminmodel->getAccount('','',$accounts_id);
		$data['account_type'] = $this->Adminmodel->get_account_types();
		$data['edit_account'] = $data['edit_account'][0];
		if($action=='asyn'){
			$this->load->view('theme/add_account',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_account',$data);
			$this->load->view('theme/include/footer');
		}     
	}

	
	
	/** Method For Income Page And Create New Income **/ 
	public function creditAccount($action='',$param1='')
	{
		$data=array();
		$data['credit_account_type'] = $this->Adminmodel->get_general_detail('creditable_account_type');
		$data['available_payment_mode'] = $this->Adminmodel->get_general_detail('payment_mode');
		if($action=='asyn'){  
			$this->load->view('theme/credit_account',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/credit_account',$data);
			$this->load->view('theme/include/footer');
		}

		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){  
			$data=array();

			$data['member_name'] = $this->input->post('member_name', true);
			$transaction_data['member_id'] = $this->input->post('member_id', true);
			$account_type = json_decode($this->input->post('credit_account_type', true), true);
			$transaction_data['account_type_short_code'] = $account_type['short_code']; 
			$transaction_data['account_type_id'] = $account_type['id'];
			
			$transaction_data['account_number']=$this->input->post('account_number', true);
			$transaction_data['account_id'] = $this->input->post('account_id', true);
			$transaction_data['credit_debit'] = TRANSACTION_TYPE_CREDIT;
			$transaction_data['amount'] = $this->input->post('credit_amount', true);
			$transaction_data['user_id'] = $this->input->post('active_by', true);
			
			$credit_payment_mode= json_decode($this->input->post('credit_payment_mode', true), true);

			$extra_detail = $credit_payment_mode['extra_detail'];
			
			$payment_data['payment_mode'] = $credit_payment_mode['value'];
			
			$transaction_data['account_balance_before'] = $this->input->post('account_balance', true);
			$transaction_data['account_balance_after'] = $transaction_data['account_balance_before']+$transaction_data['amount'];
			$transaction_data['transaction_remarks'] = $this->input->post('transaction_remarks', true);
			$transaction_data['day'] = date("d");
			$transaction_data['month'] = date("m");
			$transaction_data['year'] = date("Y");
			$transaction_data['transaction_time'] = date("Y-m-d H:i:s");
			$transaction_data['reference_id'] = $this->Adminmodel->get_general_detail('accnt_gen', 'credit_reference') . $this->Adminmodel->get_sequence('credit_reference');
			$payment_data['reference_id'] = $transaction_data['reference_id'];
			

			if($extra_detail == "1"){
                                $payment_data['payment_mode_no'] = $this->input->post('credit_payment_number', true);
                                $payment_data['bank_ifsc'] = $this->input->post('credit_payment_bank_ifsc', true);
                                $payment_data['bank_name'] = $this->input->post('credit_payment_bank_name', true);
                                $payment_data['bank_branch'] = $this->input->post('credit_payment_bank_branch', true);
                        }	
		
			

			//-----Validation-----//   
			$this->form_validation->set_rules('member_name', 'Member Id', 'trim|required');
			$this->form_validation->set_rules('credit_account_type', 'Account type', 'trim|required');
			$this->form_validation->set_rules('account_number', 'Account Number', 'trim|required');
			$this->form_validation->set_rules('credit_payment_mode', 'Payment mode', 'trim|required');
			$this->form_validation->set_rules('credit_amount', 'Credit Amount', 'trim|required');

			if($extra_detail == "1"){
				$this->form_validation->set_rules('credit_payment_bank_ifsc', 'Bank Ifsc', 'trim|required');
				$this->form_validation->set_rules('credit_payment_number','Payment Mode Number','trim|required');
			}

			$this->form_validation->set_rules('transaction_remarks', 'Transaction Remarks', 'trim|required');

			if ($this->form_validation->run() == FALSE)
			{   
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
				die();
			}

			if(empty($transaction_data['reference_id'])){
				echo '<span class="ion-android-alert failedAlert2"> '.'Unable to generate reference id'.'</span>';
				echo '<span class="ion-android-alert failedAlert2"> '.'Contact technical team'.'</span>';
				die();
			}
			//----End validation----//    
			 
			$this->db->trans_begin();
                		$this->db->insert('bank_transaction_detail', $transaction_data);
                		$this->db->insert('bank_transaction_payment_mode_detail', $payment_data);
				switch($transaction_data['account_type_short_code']){
					case "saving":
						$this->db->set('balance', $transaction_data['account_balance_after'], FALSE);
						$this->db->where('account_id', $transaction_data['account_id']);
						$this->db->update('bank_account_saving');
						break;
					case "current":
						$this->db->set('balance', $transaction_data['account_balance_after'], FALSE);
                                                $this->db->where('account_id', $transaction_data['account_id']);
                                                $this->db->update('bank_account_current');
						break;
					default:
						echo "Invalid account type";
						$this->db->trans_rollback();
						die();
				}

			if ($this->db->trans_status() === FALSE)
                	{
                        	echo get_phrase('database_error', true);
                        	$this->db->trans_rollback();
				die();
                	}
                	else
                	{
                        	$this->db->trans_commit();
                	}
				
			echo json_encode(array('error'=>'false', 'transaction_number'=>$transaction_data['reference_id']));
		}
	}

	/** Method For Income Page And Create New Income **/
        public function debitAccount($action='',$param1='')
        {
                $data=array();
                $data['debit_account_type'] = $this->Adminmodel->get_general_detail('debitable_account_type');
                $data['available_debit_mode'] = $this->Adminmodel->get_general_detail('debit_mode');
                if($action=='asyn'){
                        $this->load->view('theme/debit_account',$data);
                }else if($action==''){
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/debit_account',$data);
                        $this->load->view('theme/include/footer');
                }

                //----End Page Load------//
                //----For Insert update and delete-----// 
                if($action=='insert'){
                        $data=array();

                        $data['member_name'] = $this->input->post('member_name', true);
			$transaction_data['member_id'] = $this->input->post('member_id', true);
                        $account_type = json_decode($this->input->post('debit_account_type', true), true);
                        $transaction_data['account_type_short_code'] = $account_type['short_code'];
                        $transaction_data['account_type_id'] = $account_type['id'];

                        $transaction_data['account_number']=$this->input->post('account_number', true);
                        $transaction_data['account_id'] = $this->input->post('account_id', true);
                        $transaction_data['credit_debit'] = TRANSACTION_TYPE_DEBIT;
                        $transaction_data['amount'] = $this->input->post('debit_amount', true);
                        $transaction_data['user_id'] = $this->input->post('active_by', true);

                        $debit_payment_mode= json_decode($this->input->post('debit_payment_mode', true), true);

                        $extra_detail = $debit_payment_mode['extra_detail'];

                        $payment_data['payment_mode'] = $debit_payment_mode['value'];

                        $transaction_data['account_balance_before'] = $this->input->post('account_balance', true);
                        $transaction_data['account_balance_after'] = $transaction_data['account_balance_before']-$transaction_data['amount'];

                        $transaction_data['transaction_remarks'] = $this->input->post('transaction_remarks', true);
                        $transaction_data['day'] = date("d");
			$transaction_data['month'] = date("m");
                        $transaction_data['year'] = date("Y");
                        $transaction_data['transaction_time'] = date("Y-m-d H:i:s");
                        $transaction_data['reference_id'] = $this->Adminmodel->get_general_detail('accnt_gen', 'debit_reference') . $this->Adminmodel->get_sequence('debit_reference');
                        $payment_data['reference_id'] = $transaction_data['reference_id'];


                        if($extra_detail == "1"){
                                $payment_data['payment_mode_no'] = $this->input->post('debit_payment_number', true);
                                $payment_data['bank_ifsc'] = $this->input->post('debit_payment_bank_ifsc', true);
                                $payment_data['bank_name'] = $this->input->post('debit_payment_bank_name', true);
                                $payment_data['bank_branch'] = $this->input->post('debit_payment_bank_branch', true);
                        }



                        //-----Validation-----//   
                        $this->form_validation->set_rules('member_name', 'Member Id', 'trim|required');
                        $this->form_validation->set_rules('debit_account_type', 'Account type', 'trim|required');
                        $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required');
                        $this->form_validation->set_rules('debit_payment_mode', 'Payment mode', 'trim|required');
                        $this->form_validation->set_rules('debit_amount', 'Debit Amount', 'trim|required');

			if($transaction_data['account_balance_after'] < 0){
				echo get_phrase('insufficient_fund', true);
				die();
			}

                        if($extra_detail == "1"){
                                $this->form_validation->set_rules('debit_payment_bank_ifsc', 'Bank Ifsc', 'trim|required');
                                $this->form_validation->set_rules('debit_payment_number','Payment Mode Number','trim|required');
                        }

                        $this->form_validation->set_rules('transaction_remarks', 'Transaction Remarks', 'trim|required');

                        if ($this->form_validation->run() == FALSE)
                        {
                                echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
                                die();
                        }
			if(empty($transaction_data['reference_id'])){
                                echo '<span class="ion-android-alert failedAlert2"> '.'Unable to generate reference id'.'</span>';
                                echo '<span class="ion-android-alert failedAlert2"> '.'Contact technical team'.'</span>';
                                die();
                        }
                        //----End validation----//    

                        $this->db->trans_begin();
				//echo $this->db->set($transaction_data)->get_compiled_insert('bank_transaction_detail');
				//echo $this->db->set($payment_data)->get_compiled_insert('bank_transaction_payment_mode_detail');
                                $this->db->insert('bank_transaction_detail', $transaction_data);
                                $this->db->insert('bank_transaction_payment_mode_detail', $payment_data);
                                switch($transaction_data['account_type_short_code']){
                                        case "saving":
                                                $this->db->set('balance', $transaction_data['account_balance_after'], FALSE);
                                                $this->db->where('account_id', $transaction_data['account_id']);
                                                $this->db->update('bank_account_saving');
                                                break;
                                        case "current":
                                                $this->db->set('balance', $transaction_data['account_balance_after'], FALSE);
                                                $this->db->where('account_id', $transaction_data['account_id']);
                                                $this->db->update('bank_account_current');
                                                break;
                                        default:
                                                echo "Invalid account type";
                                                $this->db->trans_rollback();
                                                die();
                                }

			if($transaction_data['account_balance_after'] < $this->Adminmodel->get_general_detail('share_management', 'minimum_balance')){

				$this->Adminmodel->revoke_share($transaction_data['member_id']);
			}

			if ($this->db->trans_status() === FALSE)
                        {
                                echo get_phrase('database_error', true);
                                $this->db->trans_rollback();
                                die();
                        }
                        else 
                        {
                                $this->db->trans_commit();
                        }
                        echo json_encode(array('error'=>'false', 'transaction_number'=>$transaction_data['reference_id']));
                }
        }






	/** Method For Expense Page And Create New Expense **/ 
	public function addExpense($action='',$param1='')
	{
		$data=array();
		$data['accounts']=$this->Adminmodel->getAllAccounts();
		$data['category']=$this->Adminmodel->getChartOfAccountByType('Expense');
		$data['payee']=$this->Adminmodel->getPayeryAndPayeeByType('Payee');
		$data['p_method']=$this->Adminmodel->getAllPaymentmethod();
		$data['t_data']=$this->Adminmodel->getTransaction(20,'Expense');
		if($action=='asyn'){  
			$this->load->view('theme/add_expense',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_expense',$data);
			$this->load->view('theme/include/footer');
		}

		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){  
			$data=array();
			$do=$this->input->post('action',true);     
			// $data['accounts_name']=$this->input->post('account',true);
			$data['member_id']=$this->input->post('member_id'); 
			$data['trans_date']=Date('Y-m-d'); 
			$data['type']='Expense'; 		
			$data['amount']=$this->input->post('amount',true); 
			$data['p_method']=$this->input->post('p-method',true); 
			$data['ref']=$this->input->post('reference',true); 
			$data['note']=$this->input->post('note',true);  
			$data['dr']=$this->input->post('amount',true); 
			$data['cr']=0;
			$data['cheque_no']= $this->input->post('cheque_no',true);
			$data['user_id']=$this->session->userdata('user_id');
			// $data['accounts_name'] = $this->input->post('member_name');
			// $data['member_id']=$this->input->post('member_id'); 
			// $data['trans_date']=$this->input->post('expense-date',true); 
			// $data['type']='Expense'; 
			// $data['category']=$this->input->post('expense-type',true); 
			// $data['amount']=$this->input->post('amount',true); 
			// $data['payer']='';
			// $data['payee']=$this->input->post('payee',true); 
			// $data['p_method']=$this->input->post('p-method',true); 
			// $data['ref']=$this->input->post('reference',true); 
			// $data['note']=$this->input->post('note',true);  
			// $data['dr']=$this->input->post('amount',true); 
			// $data['cr']=0;
			// $data['user_id']=$this->session->userdata('user_id');
			if($data['p_method']=='CHEQUE'){$this->form_validation->set_rules('cheque_no','Cheque','trim|required');}
			//-----Validation-----//  
			$this->form_validation->set_rules('member_id', 'Member Id', 'trim|required');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('p-method', 'Payment Method', 'trim|required');
			$this->form_validation->set_rules('reference', 'Reference No', 'trim|required');
			$this->form_validation->set_rules('note', 'Note', 'trim|required|min_length[8]');

			if (!$this->form_validation->run() == FALSE)
			{
				$status = $this->Adminmodel->get_account_status($data['member_id']);
				if($status[0]->status){
					$bal = $this->Adminmodel->getBalance('',$data['amount'],'user',$this->input->post('member_id'));
					if($bal){
						$data['bal']=$this->Adminmodel->getBalance('',$data['amount'],"sub", $this->input->post('member_id'));  

						if($do=='insert'){ 

							if($this->db->insert('transaction',$data)){
								echo "true";
							}

						}else if($do=='update'){
							$id=$this->input->post('trans_id',true);
							$this->db->where('trans_id', $id);
							$this->db->update('transaction', $data);
							echo "true";

						}         
					}
					else{
						echo "Insufficient Balance";
					}
				}
				else{
					echo "Account Deactivated";
				}

			}else{
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
			}
			//----End validation----//         
		}
		else if($action=='remove'){    
			$this->db->delete('transaction', array('trans_id' => $param1));        
		}
	}

	/** Method For Transfer Page and create new transfer **/ 
	public function transfer($action='',$param1='')
	{
		$data=array();

		if($action=='asyn'){  
			$this->load->view('theme/add_transfer',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_transfer',$data);
			$this->load->view('theme/include/footer');
		}

		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){  
		}

	}

	/** Method For view manage Income page **/ 
	public function manageIncome($action='')
	{

		$data=array();
		$data['income_list']=$this->Adminmodel->getTransaction('all','Income');
		if($action=='asyn'){
			$this->load->view('theme/manage_income',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/manage_income',$data);
			$this->load->view('theme/include/footer');
		}

	}

	/** Method For view manage Expense page **/ 
	public function manageExpense($action='')
	{
		$data=array();
		$data['expense_list']=$this->Adminmodel->getTransaction('all','Expense');
		if($action=='asyn'){
			$this->load->view('theme/manage_expense',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/manage_expense',$data);
			$this->load->view('theme/include/footer');
		}
	}

	/** Method For get data for edit transaction **/ 
	public function editTransaction($trans_id,$action='')
	{
		$data=array();
		$data['transaction']=$this->Adminmodel->getSingleTransaction($trans_id);
		$data['p_method']=$this->Adminmodel->getAllPaymentmethod();
		if($action=='asyn'){
			$this->load->view('theme/edit_transaction',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/edit_transaction',$data);
			$this->load->view('theme/include/footer');
		}
	}

	/** Method For Update Transaction **/ 
	public function updateTransaction()
	{
		$data=array();
		$id=$this->input->post('trans_id',true);
		$data['trans_date']=$this->input->post('date',true);
		$data['p_method']=$this->input->post('p-method',true);
		$data['ref']=$this->input->post('reference',true);
		$data['amount']=$this->input->post('amount',true);
		$data['note']=$this->input->post('note',true);

		$this->db->where('trans_id', $id);
		$this->db->update('transaction', $data);
		echo "true";

	}

	/** Method For View Repeat Income page **/ 
	public function repeatIncome($action='')
	{
		$data=array();
		$data['accounts']=$this->Adminmodel->getAllAccounts();
		$data['category']=$this->Adminmodel->getChartOfAccountByType('Income');
		$data['payers']=$this->Adminmodel->getPayeryAndPayeeByType('Payer');
		$data['p_method']=$this->Adminmodel->getAllPaymentmethod();

		if($action=='asyn'){
			$this->load->view('theme/repeat_income',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/repeat_income',$data);
			$this->load->view('theme/include/footer');
		}

		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){  
			$data=array();
			$do=$this->input->post('action',true);     
			$data['account']=$this->input->post('account',true); 
			$data['date']=$this->input->post('income-date',true); 
			$data['type']='Income'; 
			$data['category']=$this->input->post('income-type',true); 
			$data['amount']=$this->input->post('amount',true); 
			$data['payer']=$this->input->post('payer',true); 
			$data['payee']=''; 
			$data['p_method']=$this->input->post('p-method',true); 
			$data['ref']=$this->input->post('reference',true); 
			$data['status']='pending';
			$data['description']=$this->input->post('note',true);  
			$data['user_id']=$this->session->userdata('user_id');

			//-----Validation-----//   
			$this->form_validation->set_rules('account', 'Account Name', 'trim|required');
			$this->form_validation->set_rules('income-date', 'Date', 'trim|required');
			$this->form_validation->set_rules('rotation-income', 'Rotation', 'numeric|required');
			$this->form_validation->set_rules('income-type', 'Income Type', 'trim|required');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('payer', 'Payer', 'trim|required');
			$this->form_validation->set_rules('p-method', 'Payment Method', 'trim|required');
			$this->form_validation->set_rules('reference', 'Reference No', 'trim|required');
			$this->form_validation->set_rules('note', 'Note', 'trim|required|min_length[8]');

			if (!$this->form_validation->run() == FALSE)
			{
				if($do=='insert'){ 
					$increment=$this->input->post('rotation',true);      
					$loop=$this->input->post('rotation-income',true);    
					$this->db->trans_begin();
					for($i=0;$i<$loop;$i++){   
						$this->db->insert('repeat_transaction',$data);
						$date=$data['date'];
						$data['date']=date('Y-m-d', strtotime($date.' + '.$increment.' days'));
					}

					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
					}else{
						echo "true";    
						$this->db->trans_commit();    
					}

				}         
			}else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
			}
			//----End validation----//         
		}

	}

	/** Method For View repeat Expense Page **/ 
	public function repeatExpense($action='')
	{
		$data=array();
		$data['accounts']=$this->Adminmodel->getAllAccounts();
		$data['category']=$this->Adminmodel->getChartOfAccountByType('Expense');
		$data['payee']=$this->Adminmodel->getPayeryAndPayeeByType('Payee');
		$data['p_method']=$this->Adminmodel->getAllPaymentmethod();
		if($action=='asyn'){
			$this->load->view('theme/repeat_expense',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/repeat_expense',$data);
			$this->load->view('theme/include/footer');
		}

		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){  
			$data=array();
			$do=$this->input->post('action',true);     
			$data['account']=$this->input->post('account',true); 
			$data['date']=$this->input->post('expense-date',true); 
			$data['type']='Expense'; 
			$data['category']=$this->input->post('expense-type',true); 
			$data['amount']=$this->input->post('amount',true); 
			$data['payer']=''; 
			$data['payee']=$this->input->post('payee',true); 
			$data['p_method']=$this->input->post('p-method',true); 
			$data['ref']=$this->input->post('reference',true); 
			$data['status']='unpaid';
			$data['description']=$this->input->post('note',true);  
			$data['user_id']=$this->session->userdata('user_id');

			//-----Validation-----//   
			$this->form_validation->set_rules('account', 'Account Name', 'trim|required');
			$this->form_validation->set_rules('expense-date', 'Date', 'trim|required');
			$this->form_validation->set_rules('rotation-expense', 'Rotation', 'numeric|required');
			$this->form_validation->set_rules('expense-type', 'Expense Type', 'trim|required');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('payee', 'Payee', 'trim|required');
			$this->form_validation->set_rules('p-method', 'Payment Method', 'trim|required');
			$this->form_validation->set_rules('reference', 'Reference No', 'trim|required');
			$this->form_validation->set_rules('note', 'Note', 'trim|required|min_length[8]');

			if (!$this->form_validation->run() == FALSE)
			{
				if($do=='insert'){ 
					$increment=$this->input->post('rotation',true);      
					$loop=$this->input->post('rotation-expense',true);    
					$this->db->trans_begin();
					for($i=0;$i<$loop;$i++){   
						$this->db->insert('repeat_transaction',$data);
						$date=$data['date'];
						$data['date']=date('Y-m-d', strtotime($date.' + '.$increment.' days'));
					}

					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
					}else{
						echo "true";    
						$this->db->trans_commit();    
					}

				}         
			}else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
			}
			//----End validation----//         
		}


	}

	/** Method For view Process Income page  **/ 
	public function processIncome($action='')
	{
		$data=array();
		$data['repeat_income']=$this->Adminmodel->getRepeatTransaction('Income','pending'); 
		if($action=='asyn'){
			$this->load->view('theme/process_repeat_income',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/process_repeat_income',$data);
			$this->load->view('theme/include/footer');
		}
	}

	/** Method For view Process Expense page  **/
	public function processExpense($action='')
	{
		$data=array();
		$data['repeat_expense']=$this->Adminmodel->getRepeatTransaction('Expense','unpaid'); 
		if($action=='asyn'){
			$this->load->view('theme/process_repeat_expense',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/process_repeat_expense',$data);
			$this->load->view('theme/include/footer');
		}
	}

	/** Method For get data for edit repeat transaction  **/
	public function editRepeatTransaction($trans_id,$action='')
	{
		$data=array();
		$data['transaction']=$this->Adminmodel->getSingleRepeatTransaction($trans_id);
		$data['p_method']=$this->Adminmodel->getAllPaymentmethod();
		if($action=='asyn'){
			$this->load->view('theme/edit_repeat_transaction',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/edit_repeat_transaction',$data);
			$this->load->view('theme/include/footer');
		}
	}

	/** Method For Update repeat Transaction  **/
	public function updateRepeatTransaction()
	{
		$data=array();
		$id=$this->input->post('trans_id',true);
		$data['date']=$this->input->post('date',true);
		$data['p_method']=$this->input->post('p-method',true);
		$data['ref']=$this->input->post('reference',true);
		$data['description']=$this->input->post('note',true);

		$this->db->where('trans_id', $id);
		$this->db->update('repeat_transaction', $data);
		echo "true";

	}
	/** Method For view Income Calender page  **/
	public function incomeCalender($action='')
	{ 
		$data=array();
		$data['repeat_income']=$this->Adminmodel->getRepeatTransaction('Income','pending','receive'); 
		if($action=='asyn'){
			$this->load->view('theme/income_calendar',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/income_calendar',$data);
			$this->load->view('theme/include/footer');
		}
	}

	/** Method For view Expense Calender page  **/
	public function expenseCalender($action='')
	{
		$data=array();
		$data['repeat_expense']=$this->Adminmodel->getRepeatTransaction('Expense','unpaid','paid'); 
		if($action=='asyn'){
			$this->load->view('theme/expense_calendar',$data);    
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/expense_calendar',$data);
			$this->load->view('theme/include/footer');
		}
	}
	public function get_service_by_id()
	{
		$id = $this->input->post('id');
		$data=$this->Adminmodel->get_service_by_id($id); 
		echo json_encode($data);
	}

	/** Method For process repeat Transaction  **/
	public function processRepeatTransaction($trans_id,$status)
	{
		if($this->Adminmodel->processRepeatTransaction($trans_id,$status)){
			echo "true";  
		}else{
			echo "false"; 
		}

	}

	/** Method For View,insert, update and delete Chart of accounts  **/
	public function chartOfAccounts($action='',$param1='')
	{
		$data=array();  
		$data['accountList']=$this->Adminmodel->getAllChartOfAccounts();
		//----For ajax load-----//
		if($action=='asyn'){
			$this->load->view('theme/chart_of_accounts',$data);
		}else if($action==''){  
			$this->load->view('theme/include/header');
			$this->load->view('theme/chart_of_accounts',$data);
			$this->load->view('theme/include/footer');
		}
		//----End Page Load------//
		//----For Insert update and delete-----//
		if($action=='insert'){
			$data=array();
			$do=$this->input->post('action',true);     
			$data['accounts_name']=$this->input->post('account',true); 
			$data['accounts_type']=$this->input->post('account-type',true); 
			$data['user_id']=$this->session->userdata('user_id');
			//-----Validation-----//    
			if($data['accounts_name']!="" && $data['accounts_type']!="" && 
					strlen($data['accounts_name'])<=30 && strlen($data['accounts_type'])<=7){
				if($do=='insert'){
					//Check Duplicate Entry    
					if(!value_exists2("chart_of_accounts","accounts_name",$data['accounts_name'],"accounts_type",$data['accounts_type'])){    
						if($this->db->insert('chart_of_accounts',$data)){
							$last_id=$this->db->insert_id();    
							echo '{"result":"true", "action":"insert", "last_id":"'.$last_id.'"}';
						}
					}else{
						echo '{"result":"false", "message":"This Name Is Already Exists !"}';;
					}
				}else if($do=='update'){
					$id=$this->input->post('chart_id',true); 
					//Check Duplicate Entry  
					if(!value_exists2("chart_of_accounts","accounts_name",$data['accounts_name'],"accounts_type",$data['accounts_type'],"chart_id",$id)){  
						$this->db->where('chart_id', $id);
						$this->db->update('chart_of_accounts', $data);
						echo '{"result":"true","action":"update"}'; 
					}else{
						echo '{"result":"false", "message":"This Name Is Already Exists !"}';;
					}      
				}    
			}else{
				echo '{"result":"false", "message":"All Field Must Required With Valid Length !"}';
			}
			//----End validation----//

		}else if($action=='remove'){    
			$this->db->delete('chart_of_accounts', array('chart_id' => $param1));        
		}  

	}

	/** Method For View,insert, update and delete payee And Payers  **/
	public function payeeAndPayers($action='',$param1='')
	{
		$data=array();  
		$data['p_list']=$this->Adminmodel->getAllPayeryAndPayee();
		//----For ajax load-----//    
		if($action=='asyn'){
			$this->load->view('theme/Payee_Payers',$data);
		}else if($action==''){    
			$this->load->view('theme/include/header');
			$this->load->view('theme/Payee_Payers',$data);
			$this->load->view('theme/include/footer');
		}
		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){
			$data=array();
			$do=$this->input->post('action',true);     
			$data['payee_payers']=$this->input->post('p-name',true); 
			$data['type']=$this->input->post('p-type',true); 
			$data['user_id']=$this->session->userdata('user_id');
			//-----Validation-----//    
			if($data['payee_payers']!="" && $data['type']!="" && 
					strlen($data['payee_payers'])<=30 && strlen($data['type'])<=5){
				if($do=='insert'){  
					//Check Duplicate Entry     
					if(!value_exists2("payee_payers","payee_payers",$data['payee_payers'],"type",$data['type'])){       
						if($this->db->insert('payee_payers',$data)){
							$last_id=$this->db->insert_id();    
							echo '{"result":"true", "action":"insert", "last_id":"'.$last_id.'"}';
						} 
					}else{
						echo '{"result":"false", "message":"This Name Is Already Exists !"}';;
					}
				}else if($do=='update'){
					$id=$this->input->post('trace_id',true);  
					//Check duplicate Entry   
					if(!value_exists2("payee_payers","payee_payers",$data['payee_payers'],"type",$data['type'],"trace_id",$id)){     
						$this->db->where('trace_id', $id);
						$this->db->update('payee_payers', $data);  
						echo '{"result":"true", "action":"update"}';  
					}else{
						echo '{"result":"false", "message":"This Name Is Already Exists !"}';
					}        
				}

			}else{
				echo '{"result":"false", "message":"All Field Must Required With Valid Length !"}';
			}
			//----End validation----//

		}else if($action=='remove'){    
			$this->db->delete('payee_payers', array('trace_id' => $param1));        
		}    


	}

	/** Method For View,insert, update and delete payment method  **/
	public function paymentMethod($action='',$param1='')
	{
		$data=array();  
		$data['p_list']=$this->Adminmodel->getAllPaymentmethod();    
		//----For ajax load-----//     
		if($action=='asyn'){
			$this->load->view('theme/payment_method',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/payment_method',$data);
			$this->load->view('theme/include/footer');
		}
		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){  
			$data=array();
			$do=$this->input->post('action',true);     
			$data['p_method_name']= strtoupper($this->input->post('p-method',true)); 
			$data['user_id']=$this->session->userdata('user_id');
			//-----Validation-----//    
			if($data['p_method_name']!="" && strlen($data['p_method_name'])<=20){
				if($do=='insert'){
					//Check Duplicate Entry     
					if(!value_exists3("payment_method","p_method_name",$data['p_method_name'])){      
						if($this->db->insert('payment_method',$data)){
							$last_id=$this->db->insert_id();    
							echo '{"result":"true", "action":"insert", "last_id":"'.$last_id.'"}';
						}
					}else{
						echo '{"result":"false", "message":"This Payment Method Is Already Exists !"}';
					}    
				}else if($do=='update'){
					$id=$this->input->post('p_method_id',true);  
					//Check Duplicate Entry  
					if(!value_exists3("payment_method","p_method_name",$data['p_method_name'],"p_method_id",$id)){  
						$this->db->where('p_method_id', $id);
						$this->db->update('payment_method', $data);
						$last_id=$this->db->insert_id();    
						echo '{"result":"true", "action":"update"}';
					}else{
						echo '{"result":"false", "message":"This Payment Method Is Already Exists !"}';
					}      

				}

			}else{
				echo '{"result":"false", "message":"All Field Must Required With Valid Length !"}';
			}
			//----End validation----//

		}else if($action=='remove'){    
			$this->db->delete('payment_method', array('p_method_id' => $param1));
			echo '{"result":"true", "action":"remove"}';       
		}    

	}

	/** Method For User Management page  **/
	public function userManagement($action='',$param1='')
	{
		checkPermission('User');
		$data=array();  
		$data['users']=$this->Adminmodel->getAllUsers();    
		//----For ajax load-----//      
		if($action=='asyn'){
			$this->load->view('theme/user_management',$data);
		}else if($action==''){    
			$this->load->view('theme/include/header');
			$this->load->view('theme/user_management',$data);
			$this->load->view('theme/include/footer');
		}
		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){  
			$data=array();
			$do=$this->input->post('action',true);     
			$data['user_name']=$this->input->post('username',true);
			$data['fullname']=$this->input->post('fullname',true);  
			$data['email']=$this->input->post('email',true);  
			$data['user_type']=$this->input->post('user-type',true);  
			$data['password']=$this->input->post('user-password',true);  
			$data['creation_date']=date("Y-m-d H:i:s");

			//-----Validation-----//   
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]');
			$this->form_validation->set_rules('user-password', 'Password', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('fullname', 'FullName', 'trim|required|min_length[6]|max_length[30]');


			if (!$this->form_validation->run() == FALSE)
			{
				if($do=='insert'){ 
					//Check Duplicate Entry  
					if(!value_exists("user","user_name",$data['user_name'])){ 
						if(!value_exists("user","email",$data['email'])){     
							$data['password']=md5($data['password']);       
							if($this->db->insert('user',$data)){
								$last_id=$this->db->insert_id();    
								echo '{"result":"true", "action":"insert", "last_id":"'.$last_id.'"}';    
							}
						}else{echo '{"result":"false", "message":"This Email Is Already Exists !"}'; }
					}else{
						echo '{"result":"false", "message":"Username Is Already Exists !"}';
					}
				}else if($do=='update'){
					$id=$this->input->post('user_id',true);
					if(!value_exists("user","user_name",$data['user_name'],"user_id",$id)){
						if(!value_exists("user","email",$data['email'],"user_id",$id)){ 
							//if password change
							if(strlen($this->input->post('user-password',true))<=15){
								$data['password']=md5($data['password']);   
							}      
							$this->db->where('user_id', $id);
							$this->db->update('user', $data);
							echo '{"result":"true", "action":"update"}';
						}else{echo '{"result":"false", "message":"This Email Is Already Exists !"}'; }
					}else{
						echo '{"result":"false", "message":"Username Is Already Exists !"}'; 
					}    
				}

			}else{

				echo json_encode(validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>'));
			}
			//----End validation----//

		}
		else if($action=='remove'){    
			$this->db->delete('user', array('user_id' => $param1));        
		}      

	}
	/** Method For get user information for edit  **/
	public function getUser($user_id)
	{
		$this->db->select('*');
		$this->db->from('user');  
		$this->db->where("user_id",$user_id);    
		$query_result=$this->db->get();
		$result=$query_result->row();
		echo json_encode($result);
	}  
	/** Method For add new language  **/
	public function addLanguage($action='')
	{
		checkPermission('User');

		$data=array();
		$this->load->model('Languagemodel');
		$data['language_list']=$this->Languagemodel->get_all_language();
		if($action=='asyn'){
			$this->load->view('theme/add_language',$data);
		}else{    
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_language',$data);
			$this->load->view('theme/include/footer');
		}
	}

	/** Method For general settings page  **/
	public function generalSettings($action='')
	{
		checkPermission('User');
		$data=array();  
		$this->load->model('Languagemodel');
		$data['language_list']=$this->Languagemodel->get_all_language();
		$data['settings']=$this->Adminmodel->getAllSettings();
		$data['timezone']=timezone_list();
		if($action=='asyn'){
			$this->load->view('theme/General_settings',$data);
		}else if($action==''){    
			$this->load->view('theme/include/header');
			$this->load->view('theme/General_settings',$data);
			$this->load->view('theme/include/footer');
		}

		//update general Settings 
		if($action=='update'){
			$data = array(
					array(
						'settings' => 'company_name' ,
						'value' => $this->input->post("company-name",true)
					     ),
					array(
						'settings' => 'language' ,
						'value' => $this->input->post("language",true)
					     ),
					array(
						'settings' => 'currency_code' ,
						'value' => $this->input->post("cur-symbol",true)
					     ),
					array(
						'settings' => 'email_address' ,
						'value' => $this->input->post("email",true)
					     ),
					array(
						'settings' => 'address' ,
						'value' => $this->input->post("address",true)
					     ),
					array(
							'settings' => 'phone' ,
							'value' => $this->input->post("phone",true)
					     ),
					array(
							'settings' => 'website' ,
							'value' => $this->input->post("website",true)
					     ),
					array(
							'settings' => 'timezone' ,
							'value' => $this->input->post("timezone",true)
					     ),
					array(
							'settings' => 'user_signup' ,
							'value' => $this->input->post("user-signup",true)
					     )
						);
			//-----Validation-----//   
			$this->form_validation->set_rules('company-name', 'Company Name', 'trim|required|min_length[2]|max_length[50]');
			if (!$this->form_validation->run() == FALSE)
			{
				//Update Code
				$this->db->update_batch('settings', $data, 'settings');
				echo "true";
				//Finish Update Code
			}else{
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
			}

		}

	}

	/** Method For upload new logo  **/
	public function uploadLogo()
	{

		if ( ! move_uploaded_file($_FILES['logo']['tmp_name'],
					'uploads/'.$_FILES['logo']['name']))
		{
			echo $this->upload->display_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
		}
		else
		{
			$object=array();
			$object['value']=$_FILES['logo']['name'];
			$this->db->where('settings','logo_path');
			if($this->db->update('settings', $object)){
				echo "true";
			}
		} 

	}


	/** Method For backup database  **/
	public function backupDatabase($action='',$table='')
	{
		checkPermission('User');
		if($action=='asyn'){
			$this->load->view('theme/backup_database');
		}else if($action==''){    
			$this->load->view('theme/include/header');
			$this->load->view('theme/backup_database');
			$this->load->view('theme/include/footer');
		}

		if($action=='backup'){
			$this->load->model('Datamodel');
			$this->Datamodel->backup($table);
		}
		/*
		   else if($action=='delete'){
		   $this->load->model('Datamodel');
		   $this->Datamodel->truncate($table);
		   }*/

	}

	/** Method For update profile  **/
	public function updateProfile(){
		$data=array();
		//-----Validation-----//   
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('fullname', 'FullName', 'trim|required|min_length[6]|max_length[30]');

		if (!$this->form_validation->run() == FALSE)
		{    
			$data['user_name']=$this->input->post('username',true);
			$data['fullname']=$this->input->post('fullname',true);
			$data['email']=$this->input->post('email',true);

			$id=$this->session->userdata('user_id');
			if(!value_exists("user","user_name",$data['user_name'],"user_id",$id)){
				if(!value_exists("user","email",$data['email'],"user_id",$id)){       
					$this->db->where('user_id', $id);
					$this->db->update('user', $data);
					//update session
					$this->session->set_userdata('username',$data['user_name']);
					$this->session->set_userdata('fullname',$data['fullname']);
					$this->session->set_userdata('email',$data['email']);

					echo "true";
				}else{echo "Sorry, This Email Is Already Exists !"; }
			}else{
				echo "Sorry, Username Is Already Exists !"; 
			} 
		}else{
			//echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');    
			echo "All Field Must Required With Valid Information !";

		}  

	}

	/** Method For change password  **/ 
	public function changePassword(){
		$this->form_validation->set_rules('new-password', 'Password', 'trim|required|min_length[5]');
		if (!$this->form_validation->run() == FALSE)
		{
			$data=array();    
			$data['password']=md5($this->input->post('new-password',true)); 
			$cp=md5($this->input->post('confrim-password',true)); 
			if($data['password']!=$cp){
				echo "New Password And Confrim Password Has Not Match !";
			}else{
				//update Password
				$id=$this->session->userdata('user_id');    
				$this->db->where('user_id',$id);
				$this->db->update('user',$data);
				echo "true";
			}   
		}else{
			echo "The Password field must be at least 5 characters in length";
		}    

	}
	public function get_user(){

		$id = $this->input->post('id');
		$this->db->select('*');
		$this->db->from('member_details');  
		$this->db->where("member_id",$id);    
		$query_result=$this->db->get();
		$result=$query_result->row();
		echo json_encode($result);
	}
	public function get_late_fees1(){
		$data = $this->Adminmodel->get_late_fees1();
		echo json_encode($data);
	}
	public function add_fixed_deposit($action='',$param1='')
	{
		$data['duration'] = $this->Adminmodel->get_duration();
		if($action=='asyn'){
			$this->load->view('theme/add_fixed_deposit',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_fixed_deposit',$data);
			$this->load->view('theme/include/footer');
		}$do=$this->input->post('action');
		if($action =='insert'){
			$data['member_id'] = $this->input->post('member_id');
			$data['user_id']=$this->session->userdata('user_id');
			$data['fixed_deposit_amount'] = $this->input->post('fixed_deposit_amount');
			$data['duration'] = $this->input->post('duration');
			$data['maturity_date'] = $this->input->post('maturity_date');
			$data['maturity_amount'] = $this->input->post('maturity_amount');
			$data['active_by'] = $this->input->post('active_by');                   
			$data['date'] = $this->input->post('date');
			$data['interest'] = $this->input->post('interest');
			$data['taken'] = 0;
			$thisTime = strtotime('+1 month',strtotime(Date('Y-m-d')));
			$endTime = strtotime($data['maturity_date']);

			$this->form_validation->set_rules('member_id', 'Member Id', 'trim|required|min_length[1]|max_length[30]');
			$this->form_validation->set_rules('member_id', 'Member Id', 'trim|required');
			$this->form_validation->set_rules('fixed_deposit_amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('duration', 'Duration', 'trim|required');
			$this->form_validation->set_rules('active_by', 'Active By', 'trim|required');
			if(!value_exists5('bank_accounts','member_id',$data['member_id'])){
				if (!$this->form_validation->run() == FALSE)
				{
					$status = $this->Adminmodel->get_account_status($data['member_id']);
					if($status[0]->status){
						$remain = $this->Adminmodel->getBalance_remain($data['member_id'],$data['fixed_deposit_amount'],'');
						if($remain){
							$this->Adminmodel->getBalance('',$data['fixed_deposit_amount'],'sub',$data['member_id']);
							if($do=='insert'){ 	

								$data1=array();
								$data1['type']='Fixed'; 
								$data1['amount']= $data['fixed_deposit_amount']; 
								$data1['p_method']=''; 
								$data1['ref']=''; 
								$data1['note']='';  
								$data1['dr']=$this->input->post('fixed_deposit_amount',true);  
								$data1['cr']=0;
								$data1['user_id']=$this->session->userdata('user_id');
								$data1['member_id']=$this->input->post('member_id');
								$data1['trans_date']=Date('Y-m-d');
								$bal = $this->Adminmodel->get_balance($data['member_id']);
								$data1['bal']=$bal->account_balance - $data['fixed_deposit_amount'];
								$this->db->insert('transaction',$data1);
								$this->db->trans_begin();
								$this->db->insert('bank_fixed_deposit',$data);   
								$fd_id = $this->db->insert_id();

								while($thisTime <= $endTime)
								{	
									$data1 = array();
									$data1['date'] = date('Y-m-d', $thisTime);
									$data1['member_id'] = $data['member_id'];
									$data1['fd_id'] = $fd_id;
									$thisTime = strtotime('+3 month', $thisTime); // increment for loop
									$this->db->insert('user_fixed_deposits',$data1); 
								}
								//insert Transaction Data

								$this->db->trans_complete();
								if ($this->db->trans_status() === FALSE)
								{
									$this->db->trans_rollback();
								}
								else
								{
									echo "true";
									$this->db->trans_commit();
								}


							}else if($do=='update'){
								$id=$this->input->post('accounts_id',true);
								if(!value_exists("member_details","accounts_name",$data['accounts_name'],"accounts_id",$id)){       
									$old_name=getOld('accounts_id',$id,'accounts');

									$this->db->where('accounts_id', $id);
									$this->db->update('member_details', $data);

									//transaction table
									$data1=array();
									$data1['accounts_name']=$data['accounts_name'];
									$this->db->where('accounts_name', $old_name->accounts_name);
									$this->db->where('user_id', $this->session->userdata('user_id'));
									$this->db->update('transaction', $data1);

									//repeat transaction table
									$data2=array();
									$data2['account']=$data['accounts_name'];
									$this->db->where('member_details', $old_name->accounts_name);
									$this->db->where('user_id', $this->session->userdata('user_id'));
									$this->db->update('repeat_transaction', $data2);


									echo "true";
								}else{
									echo "This Account Is Already Exists !";  
								}    
							} 

						} 
						else{
							echo "Insuficiant Account Balance !";  
						}           
					}else{
						//echo "All Field Must Required With Valid Length !";
						echo "Account Deactivated";

					}

				}else{
					//echo "All Field Must Required With Valid Length !";
					echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

				}
			}
			else{echo "Add Account First";}
			//----End validation----//         
		}


		else if($action=='remove'){    
			$this->db->delete('member_details', array('accounts_id' => $param1));        
		}
	}

	public function add_bank_loan($action='',$param1='')
	{
		$data1['data'] = $this->Adminmodel->get_loan_interest();
		if($action=='asyn'){
			$this->load->view('theme/add_loan',$data1);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_loan',$data1);
			$this->load->view('theme/include/footer');
		} 
		$do=$this->input->post('action');
		if($action =='insert'){
			$data['member_id'] = $this->input->post('member_id');
			$data['introducer_1_id'] = $this->input->post('enter_introducer_1_id') ? $this->input->post('enter_introducer_1_id') : 0;
			$data['introducer_1_name'] = $this->input->post('introducer_1_name') ;
			$data['introducer_1_bankAccount_balance'] = $this->input->post('introducer_1_bankAccount_balance') ? $this->input->post('introducer_1_bankAccount_balance') : 0;
			$data['user_id']=$this->session->userdata('user_id');
			$data['introducer_1_share'] = $this->input->post('introducer_1_share') ? $this->input->post('introducer_1_share') : 0;
			$data['loan_amount'] = $this->input->post('loan_amount');
			$data['interest_rate'] = $this->input->post('interest');
			$data['year'] = $this->input->post('year');
			$data['remark'] = $this->input->post('remark');
			$data['member_name'] = $this->input->post('member_name');
			$data['introducer_2_id'] = $this->input->post('enter_introducer_2_id')? $this->input->post('enter_introducer_2_id') : 0;
			$data['introducer_2_name'] = $this->input->post('introducer_2_name');
			$data['introducer_2_bankAccount_balance'] = $this->input->post('introducer_2_bankAccount_balance')? $this->input->post('introducer_2_bankAccount_balance') : 0;
			$data['select_loan_type'] = $this->input->post('select_loan_type');
			$data['final_loan_amount'] = $this->input->post('total_loan_amount');
			$data['total_loan_amount_with_interest'] = $this->input->post('total_loan_amount');
			$data['monthly_emi'] = $this->input->post('emi');
			$data['active_by'] = $this->input->post('active_by');
			$data['date'] = Date('Y-m-d');

			$year =  date('Y-m-d', strtotime('+'.$data['year'].' year'));

			$this->form_validation->set_rules('member_id', 'Member Id', 'trim|required|min_length[1]|max_length[30]');
			$this->form_validation->set_rules('enter_introducer_1_id','Introducer Id 1','trim|required');
			$this->form_validation->set_rules('loan_amount','Loan Amount','trim|required');
			$this->form_validation->set_rules('interest','Interest Rate','trim|required');
			$this->form_validation->set_rules('year','Duration','trim|required');
			$this->form_validation->set_rules('introducer_1_name','Introducer 1 Dont have Account','trim|required');
			$this->form_validation->set_rules('enter_introducer_2_id','Introducer Id 2','trim|required');
			$this->form_validation->set_rules('introducer_2_name','Introducer 2 Dont have Account','trim|required');
			$this->form_validation->set_rules('select_loan_type','Select Loan Type','trim|required');
			$this->form_validation->set_rules('active_by','Active By','trim|required');
			if (!$this->form_validation->run() == FALSE)
			{
				if($data['introducer_1_id']!=$data['introducer_2_id']&&$data['introducer_1_id']!=$data['member_id']&&$data['introducer_2_id']!=$data['member_id']){
					if($do=='insert'){ 
						//Check Duplicate Entry 

						$status = $this->Adminmodel->get_account_status($data['member_id']);
						if(!empty($status)){if($status[0]->status){
							$status = $this->Adminmodel->get_account_status($data['introducer_1_id']);
							if($status[0]->status){

								$status = $this->Adminmodel->get_account_status($data['introducer_2_id']);
								if($status[0]->status){
									if(!value_exists6("bank_emi","paid",$data['member_id'],0)){  
										$this->Adminmodel->getBalance('',$data['loan_amount'],"add", $this->input->post('member_id'));
										$this->db->trans_begin();
										$this->db->insert('bank_loan',$data);   
										//insert Transaction Data
										$insert_id = $this->db->insert_id();
										$thisTime = strtotime('+1 month',strtotime(Date('Y-m-d')));
										$endTime = strtotime($year);
										while($thisTime <= $endTime)
										{	
											$data1 = array();
											$data1['date'] = date('Y-m-d', $thisTime);
											$data1['member_id'] = $data['member_id'];
											$data1['emi_amount'] = $data['monthly_emi'];
											$data1['paid'] = 0;
											$data1['loan_id'] = $insert_id;
											$data1['extra_amount'] = 0;
											$data1['paid_date'] =  Date('Y-m-d'); 

											$thisTime = strtotime('+1 month', $thisTime); // increment for loop
											$this->db->insert('bank_emi',$data1);
										}
										$data1['type']='Loan'; 
										$data2['amount']= $data['loan_amount']; 
										$data2['p_method']=''; 
										$data2['ref']=''; 
										$data2['trans_date'] = Date('Y-m-d');
										$data2['note']='';  
										$data2['dr']=0;  
										$data2['cr']=$data['loan_amount'];
										$data2['user_id']=$this->session->userdata('user_id');
										$data2['member_id']=$this->input->post('member_id');
										$bal = $this->Adminmodel->get_balance($data['member_id']);
										$data2['bal']=$bal->account_balance + $data['loan_amount'];
										$this->db->insert('transaction',$data2);
										$this->db->trans_complete();
										if ($this->db->trans_status() === FALSE)
										{
											$this->db->trans_rollback();
										}
										else
										{
											echo "true";
											$this->db->trans_commit();
										}

									}else{echo "Loan Already Taken";}
								}else{echo " Introducer ".$data['introducer_2_id']." is Deactivated";}
							}else{echo " Introducer ".$data['introducer_1_id']." is Deactivated";}
						}else{echo "Member Account Deactivated";}
						}else{echo "Member Not  Found";}
					}       
					else if($do=='update'){
						$id=$this->input->post('accounts_id',true);
						if(!value_exists("member_details","accounts_name",$data['accounts_name'],"accounts_id",$id)){       
							$old_name=getOld('accounts_id',$id,'accounts');

							$this->db->where('accounts_id', $id);
							$this->db->update('member_details', $data);

							//transaction table
							$data1=array();
							$data1['accounts_name']=$data['accounts_name'];
							$this->db->where('accounts_name', $old_name->accounts_name);
							$this->db->where('user_id', $this->session->userdata('user_id'));
							$this->db->update('transaction', $data1);

							//repeat transaction table
							$data2=array();
							$data2['account']=$data['accounts_name'];
							$this->db->where('member_details', $old_name->accounts_name);
							$this->db->where('user_id', $this->session->userdata('user_id'));
							$this->db->update('repeat_transaction', $data2);


							echo "true";
						}else{
							echo "This Account Is Already Exists !";  
						}    
					}         

				}else {
					echo ('Cannot Select Same Introducer');
				}
			}else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}



		}
	}        
	public function get_introducer(){
		$id = $this->input->post('id');
		$result = $this->Adminmodel->get_introducer($id);
		echo json_encode($result);
	}
	public function get_description(){
		$id = $this->input->post('id');
		$data=array();
		$data['accounts']=$this->Adminmodel->getAllAccounts();
		$data['category']=$this->Adminmodel->getChartOfAccountByType('Expense');
		$data['payee']=$this->Adminmodel->getPayeryAndPayeeByType('Payee');
		$data['p_method']=$this->Adminmodel->getAllPaymentmethod();
		$data['t_data']=$this->Adminmodel->getSingleTransaction1($id);

		$this->load->view('theme/add_expense',$data);    

	}
	public function get_balance(){
		$member_id = $this->input->post('member_id');
		$user_id = $this->input->post('user_id');
		$data = $this->Adminmodel->get_balance($member_id,$user_id);
		echo json_encode($data);
	}
	public function getAccount(){
		$member_id = $this->input->post('member_id');
		$user_id = $this->input->post('user_id');
		$data = $this->Adminmodel->getAccount($member_id);
		echo json_encode($data);
	}
	public function getFd(){
		$fd_id = $this->input->post('fd_id');
		$data = $this->Adminmodel->getFd($fd_id);
		echo json_encode($data);
	}
	public function get_loan(){
		$member_id = $this->input->post('member_id');
		$user_id = $this->input->post('user_id');
		$data = $this->Adminmodel->get_loan($member_id,$user_id);
		echo json_encode($data);
	}
	public function get_share(){
		$member_id = $this->input->post('member_id');
		$data = $this->Adminmodel->get_share($member_id,'');
		echo json_encode($data);
	}


	
	public function payLoan($action='', $account_number='', $account_id=''){
		$data['available_payment_mode'] = $this->Adminmodel->get_general_detail('loan_payment_mode');
		if($action=='asyn'){  
			$this->load->view('theme/pay_loan',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/pay_loan',$data);
			$this->load->view('theme/include/footer');
		}else if($action=='fetch_loan_account_detail'){
			$result1= null;
			$result2= array();

			if(empty($account_number)){
				echo "Account number is empty";
			}

			$result = $this->Adminmodel->getAccountDetail(null,  "bank_account_loan", "1", $account_number);
			
			if(!empty($result)){
				$result['account_number'] = $result['bank_account_number'];
				$result['duration'] = $result['duration_in_months'];

				$result1 = $this->Adminmodel->fetch_loan_account_summary($result['account_id']); 
				//late_fee, last_payment_date, total_due_amount
			}else{
				echo "Account not found";
				die();
			}
			echo json_encode(array_merge($result1, $result));
		}else if($action=='pay_installment'){
			$account_id = $this->input->post('account_id', true);
			$total_due_amount = $this->input->post('total_due_amount', true);
			$amount_payed = $this->input->post('amount_payed', true);
			$member_id = $this->input->post('member_id', true);
			$account_number = $this->input->post('account_number', true);
			$payment_mode = $this->input->post('payment_mode', true);

			$this->form_validation->set_rules('member_name','Member Name', 'trim|required');
                        $this->form_validation->set_rules('monthly_emi','Monthly EMI', 'trim|required');
                        $this->form_validation->set_rules('account_id','Account Number', 'trim|required');
			$this->form_validation->set_rules('total_due_amount','Total due amount', 'trim|required');
			$this->form_validation->set_rules('amount_payed','Amount payed', 'trim|required|number');


			if($payment_mode == TRANSACTION_MODE_TRANSFER){
				$this->form_validation->set_rules('linked_account','Linked account', 'trim|required');
				$linked_account_number = $this->input->post('linked_account_number', true);
			}

			if($payment_mode == TRANSACTION_MODE_CHEQUE){
				$payment_mode_no = $this->input->post('credit_payment_number', true);
                                $bank_ifsc = $this->input->post('credit_payment_bank_ifsc', true);
                                $bank_name = $this->input->post('credit_payment_bank_name', true);
                                $bank_branch = $this->input->post('credit_payment_bank_branch', true);
	
				$this->form_validation->set_rules('credit_payment_number', 'Payment mode number', 'trim|required');	
				$this->form_validation->set_rules('bank_ifsc', 'Bank IFSC', 'trim|required');
			}
                        if ($this->form_validation->run() == FALSE)
                        {
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
				die();
			}

			if($amount_payed > $total_due_amount){
                                echo '<span class="ion-android-alert failedAlert2"> Amount payed can not be greater than total due amount. </span>';
                                die();
                        }

			if(!$this->Adminmodel->is_linked_account($member_id, $account_number)){
				echo '<span class="ion-android-alert failedAlert2"> Account does not belong to the member </span>';
                                die();
			}

			if(!empty($linked_account_number) && !$this->Adminmodel->is_linked_account($member_id, $linked_account_number)){
				echo '<span class="ion-android-alert failedAlert2"> Linked account does not belong to the member </span>';
                                die();
			}

			$account_detail = $this->Adminmodel->fetch_account_view_detail($accnt_no, '', '1')[0];


			if(!($account_detail['html_id']==SAVING_SHORT_CODE || $account_detail['html_id']==CURRENT_SHORT_CODE)){
				echo '<span class="ion-android-alert failedAlert2"> Linked account not of current or saving type </span>';
                                die();
			}

			$this->db->trans_begin();
			$query_status = $this->Adminmodel->payLoanInstallment($account_id, $amount_payed);

			if($query_status != "success"){
				$this->db->trans_rollback();
				echo get_phrase('database_error', true);
				die();
			}

		
			if($account_detail['html_id']==SAVING_SHORT_CODE){
				if($this->Adminmodel->deduct_saving_service($account_id, $amount_payed)!="true"){
                                        $this->db->trans_rollback();
                                        echo get_phrase('database_error', true);
                                        die();
                                }

			}else if($account_detail['html_id']==CURRENT_SHORT_CODE){
				if($this->Adminmodel->deduct_current_service($account_id, $amount_payed)!="true"){
					$this->db->trans_rollback();
                                	echo get_phrase('database_error', true);
                                	die();
				}	
			}	

			if ($this->db->trans_status() === FALSE)
                        {
                       	 	$this->db->trans_rollback();
                        }
                        else
                        {
                                $this->db->trans_commit();
				echo "success";
				die();
                        }
			
		}
	}

	public function fdManagement($action='',$param1='')
	{
		$data1['data'] = $this->Adminmodel->get_fixed_d();
		if($action=='asyn'){  
			$this->load->view('theme/fdManagement',$data1);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/fdManagement',$data1);
			$this->load->view('theme/include/footer');
		}
		$data['fd_interest'] = $this->input->post('interest');
		$data['fd_duration'] = $this->input->post('duration');
		$data['fd_name'] = $this->input->post('name');

		$id = $this->input->post('trace_id');


		if($action=='insert'){

			$this->form_validation->set_rules('interest','Interest','required');
			$this->form_validation->set_rules('duration','Duration','required');
			$this->form_validation->set_rules('name','Name','required');

			if (!$this->form_validation->run() == FALSE)
			{
				$do=$this->input->post('action',true);     
				if($do=='insert'){ 
					//Check Duplicate Entry     

					if($this->db->insert('fixed_deposit',$data)){
						$last_id=$this->db->insert_id();    
						echo "true";
					}

				}else if($do=='update'){
					$id=$this->input->post('trace_id',true);  
					//Check Duplicate Entry  
					$this->db->where('fd_id', $id);
					$this->db->update('fixed_deposit', $data);
					$last_id=$this->db->insert_id();    
					echo "true";


				}

			}
			else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}
		}
		else if($action=='update'){

		}

		else if($action=='remove'){
			$this->db->delete('fixed_deposit', array('fd_id' => $param1));        
		}

	}

	public function interestManagement($action='',$param1='')
        {
                $data1['data'] = $this->Adminmodel->get_interest_detail();
		$data1['account_type'] = $this->Adminmodel->get_account_types();

                if($action=='asyn'){
                        $this->load->view('theme/interestManagement',$data1);
                }else if($action==''){
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/interestManagement',$data1);
                        $this->load->view('theme/include/footer');
                }
	
                $data['name'] = $this->input->post('name');
                $data['interest'] = $this->input->post('interest');
		$data['account_type_id'] = $this->input->post('bank_account_type');


		if($action=='insert'){
                        $this->form_validation->set_rules('interest','Interest','required');
                        $this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('bank_account_type','Account type','required');

                        if ($this->form_validation->run() != FALSE)
                        {
                                $do=$this->input->post('action',true);
                                if($do=='insert'){
                                        //Check Duplicate Entry     

                                        if($this->db->insert('interest_management',$data)){
                                                $last_id=$this->db->insert_id();
                                                echo "true";
                                        }
                                }

                        }
                        else{
                                //echo "All Field Must Required With Valid Length !";
                                echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

                        }
                }
                else if($action=='update'){
			$id=$this->input->post('trace_id');;
                                        //Check Duplicate Entry  
                                        $this->db->where('id', $id);
                                        $this->db->update('interest_management', $data);
                                        $last_id=$this->db->insert_id();
                                        echo "true";
                }
		else if($action=='remove'){
                        $this->db->delete('interest_management', array('id' => $param1));
                }
        }

	public function loanSetup($action='',$param1='')
	{
		$data['data'] = $this->Adminmodel->get_loan_setup();
		if($action=='asyn'){  
			$this->load->view('theme/loan_setup',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/loan_setup',$data);
			$this->load->view('theme/include/footer');
		}
		$data1['name'] = strtoupper($this->input->post('loan_type'));
		$data1['value'] = $this->input->post('loan_interest');
		$this->form_validation->set_rules('loan_type','personal loan','required');
		$this->form_validation->set_rules('loan_interest','other loan ','required');
		if($action=='insert'){
			$do=$this->input->post('action');
			if (!$this->form_validation->run() == FALSE)
			{     
				if($do=='action'){
					$this->db->trans_begin();
					$this->db->insert('loan_setup',$data1);   
					//insert Transaction Data
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
					}
					else
					{
						echo "true";
						$this->db->trans_commit();
					}
				}
				else if($do=='update'){
					$id=$this->input->post('trace_id',true);  
					//Check Duplicate Entry  
					$this->db->where('tbl_id', $id);
					$this->db->update('loan_setup', $data1);
					$last_id=$this->db->insert_id();    
					echo "true";


				}


			}
			else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}
		}

		else if($action=='remove'){
			$this->db->delete('loan_setup', array('tbl_id' => $param1));        
		}
	}

	public function depositShare($action=''){
		$data['p_method']=$this->Adminmodel->getAllPaymentmethod();
		if($action=='asyn'){  
			$this->load->view('theme/deposit_share',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/deposit_share',$data);
			$this->load->view('theme/include/footer');
		}
		if($action=='insert'){
			$data = array();
			$do=$this->input->post('action');
			$data['member_id'] = $this->input->post('member_id');
			$data['share_id'] = $this->input->post('share_account_no');
			$data['payment_type'] = $this->input->post('p-method');
			$data['share_amount'] = $this->input->post('share_amount');
			$data['date'] = Date('y-m-d');

			$data1['type']="Share"; 
			$data1['amount']= $data['share_amount']; 
			$data1['p_method']=$data['payment_type']; 
			$data1['ref']=''; 
			$data1['note']='';  
			$data1['dr']=0;  
			$data1['cr']=$this->input->post('share_amount',true);
			$data1['user_id']=$this->session->userdata('user_id');
			$data1['member_id']=$this->input->post('member_id');
			$data1['trans_date']=Date('Y-m-d');
			$bal = $this->Adminmodel->get_balance($data['member_id']);
			$data1['bal']=$bal->account_balance - $data1['amount'];
			$this->db->insert('transaction',$data1);
			$this->form_validation->set_rules('member_id','Member Id','required');
			$this->form_validation->set_rules('p-method','Payment Type','required');
			$this->form_validation->set_rules('share_amount','Share Amount','required');
			if(!value_exists5('bank_accounts','member_id',$data['member_id'])){
				if (!$this->form_validation->run() == FALSE)
				{
					$status = $this->Adminmodel->get_account_status($data['member_id']);
					if($status[0]->status){
						$bal = $this->Adminmodel->getBalance('',$data['share_amount'],'user',$this->input->post('member_id'));
						if($bal){

							$this->Adminmodel->getBalance('',$data['share_amount'],'sub',$data['member_id']);
							$this->Adminmodel->get_share($data['member_id'],$data['share_amount'],'add');
							$this->db->trans_begin();
							$this->db->insert('bank_share_transactions',$data);   
							//insert Transaction Data
							$this->db->trans_complete();
							if ($this->db->trans_status() === FALSE)
							{
								$this->db->trans_rollback();
							}
							else
							{
								echo "true";
								$this->db->trans_commit();
							}   
						}else{
							echo "Insufficient Balance";
						}
					}
					else{
						echo "Account Deactive";
					}
				}
				else{
					//echo "All Field Must Required With Valid Length !";
					echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

				}
			}
			else{echo "Member Account Does Not Exist";}
		}
	}

	public function accountTypes($action='',$param1=''){
		$data['account_types'] = $this->Adminmodel->get_account_types();
		if($action=='asyn'){  
			$this->load->view('theme/accountTypes',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/accountTypes',$data);
			$this->load->view('theme/include/footer');
		}
		if($action=='insert'){
			$data = array();
			$data['account_name'] = $this->input->post('p-method');
			$data['joint_account'] = $this->input->post('allow_joint_account');
			$data['status'] = $this->input->post('activate_account_type');
			$this->form_validation->set_rules('p-method','Account Type','required|trim');

			if (!$this->form_validation->run() == FALSE)
			{
				$do=$this->input->post('action',true);     
				if($do=='insert'){
					//Check Duplicate Entry     
					if(!value_exists3("bank_account_types","account_name",$data['account_name'])){      
						if($this->db->insert('bank_account_types',$data)){
							$last_id=$this->db->insert_id();    
							echo 'true';
						}
					}else{
						echo "This Payment Method Already Exists !";
					}    
				}else if($do=='update'){
					$id=$this->input->post('p_method_id',true);  
					//Check Duplicate Entry  
					if(!value_exists3("bank_account_types","account_name",$data['account_name'],"tbl_id",$id)){  
						$this->db->where('tbl_id', $id);
						$this->db->update('bank_account_types', $data);
						$last_id=$this->db->insert_id();    
						echo 'true';
					}else{
						echo "This Payment Method Is Already Exists !";
					}      

				}

			}
			else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}
		}
		else if($action=='update'){

		}

		else if($action=='remove'){
			$this->input->get('');    
			$this->db->delete('bank_account_types', array('tbl_id' => $param1));        
		}
	}
	public function addPhotoIdentity($action='',$param1=''){
		$data['identity'] = $this->Adminmodel->get_identity();
		if($action=='asyn'){  
			$this->load->view('theme/addPhotoIdentity',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/addPhotoIdentity',$data);
			$this->load->view('theme/include/footer');
		}	
		if($action=='insert'){
			$data = array();
			$data['name'] = $this->input->post('identity_type');

			$this->form_validation->set_rules('identity_type','Identity Type','required');

			if (!$this->form_validation->run() == FALSE)
			{
				$do=$this->input->post('action',true);     
				if($do=='insert'){ 
					//Check Duplicate Entry     

					if($this->db->insert('photo_identity_types',$data)){
						$last_id=$this->db->insert_id();    
						echo "true";
					}

				}else if($do=='update'){
					$id=$this->input->post('identity',true);  
					//Check Duplicate Entry  
					$this->db->where('tbl_id', $id);
					$this->db->update('photo_identity_types', $data);
					$last_id=$this->db->insert_id();    
					echo "true";


				}

			}
			else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}
		}
		else if($action=='update'){

		}

		else if($action=='remove'){
			$this->input->get('');    
			$this->db->delete('photo_identity_types', array('tbl_id' => $param1));        
		}

	}

	public function withdrawAll($action='',$param1=''){
		$data['services'] = $this->Adminmodel->get_services();
		if($action=='asyn'){  
			$this->load->view('theme/withdraw_from_all',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/withdraw_from_all',$data);
			$this->load->view('theme/include/footer');
		}



		if($action=='withdraw'){
			$data = array();

			$data['service_id'] = $this->input->post('service_name');
			$data['service_amount'] = $this->input->post('service_amount');

			$this->form_validation->set_rules('service_name','Select Service','required');

			if (!$this->form_validation->run() == FALSE)
			{
				$result = $this->Adminmodel->getBalance($data['service_id'],$data['service_amount'],'service');
				if($result){echo 'true';}
			}
			else{ 
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');}
		}
	}
	public function withdraw_from_single_user($action='',$param1=''){
		$data['accounts']=$this->Adminmodel->getAccount();

		if($action=='asyn'){  
			$this->load->view('theme/withdraw_single_service_charge',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/withdraw_single_service_charge',$data);
			$this->load->view('theme/include/footer');
		}
		else if($action=='search'){
			$data=array();
			$id = $this->input->get('search');
			$name = $this->input->get('search_name');

			if(!empty($id)||!empty($name)){
				$data['accounts']=$this->Adminmodel->getAccount($id,strtoupper($name));
				if($data['accounts']==null){
					$data['accounts']=$this->Adminmodel->getAllAccounts();
					$this->load->view('theme/include/header');
					$this->load->view('theme/withdraw_single_service_charge',$data);
					$this->load->view('theme/include/footer');
				}
				else{
					$this->load->view('theme/include/header');
					$this->load->view('theme/manage_account',$data);
					$this->load->view('theme/include/footer');
				}
			}
			else{
				$data['accounts']=$this->Adminmodel->getAllAccounts();
				$this->load->view('theme/include/header');
				$this->load->view('theme/manage_account',$data);
				$this->load->view('theme/include/footer');
			}
		}
		else if($action == 'withdraw'){
			$id = $this->input->post('id');
			$service = $this->input->post('service');
			$result = $this->Adminmodel->getBalance($service,'','service_user',$id);
			if($result){echo 'true';}else{echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');}

		}
	}


	public function assignService($action='',$param1=''){
		if($action=='asyn'){
                        $data['services'] = $this->Adminmodel->get_services('1', 1);
                        $this->load->view('theme/assign_service',$data);
                }else if($action==''){
                        $data['services'] = $this->Adminmodel->get_services('1', 1);
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/assign_service',$data);
                        $this->load->view('theme/include/footer');
                }else if($action=='insert'){

			$valid = true;
                        $member_name = $this->input->post('member_name', true);
                        $data['account_id'] = $this->input->post('account_id', true);
			$bank_account_id = $this->input->post('account_type_id', true);
                        $service_id = $this->input->post('service_id', true);
			

                        if(empty($member_name) || empty($data['account_id']) || empty($bank_account_id)){
                                $valid = false;
                                echo '<span class="ion-android-alert failedAlert2"> Invalid Account Number </span>';                 
                        }

                        if(empty($service_id)){
                                $valid = false;
                                echo '<span class="ion-android-alert failedAlert2"> Service is mandatory </span>';
                        }

                        if(!$valid){
                                die();
                        }


			$service_id = json_decode($service_id, true);

			$data['service_id'] = $service_id['id'];

			$data['application_date'] = Date('Y-m-d H:i:s');
			$data['user_id'] = $this->input->post('active_by', true);

			$summary_data['account_id'] = $data['account_id'];
			$summary_data['modification_date'] = Date('Y-m-d H:i:s');

				
			$account_type_detail = $this->Adminmodel->fetch_account_type_detail($bank_account_id);

                	$account_type_detail = $account_type_detail[0];
			$account_type_short_code = $account_type_detail['html_id'];

			if($service_id['frequency'] == FREQUENCY_ONETIME){
				$summary_data['remaining_charge'] = 0;
				$data['status'] = '0';
			}else{
				$summary_data['remaining_charge'] = $service_id['charge'];
				$data['status'] = '1';
			}


			$insert = false;
			if(empty($this->Adminmodel->getRemainingServiceCharge($data['account_id']))){
				$insert = true;	
			}


			if($service_id['frequency'] != FREQUENCY_ONETIME && !empty($this->Adminmodel->getAccountService($data['account_id'], $data['service_id'], 1))){
				echo '<span class="ion-android-alert failedAlert2">'."Service already Assigned ".'</span>';
				die();
			}


			$this->db->trans_begin();


                           $this->db->insert('bank_account_service', $data);


			
                          if($insert){
				$this->db->insert('bank_account_service_charge_summary', $summary_data);
			}else{
				$this->db->set('remaining_charge', 'remaining_charge+'.$summary_data['remaining_charge'] , FALSE)->where('account_id', $data['account_id'])->update('bank_account_service_charge_summary');
			}

			if($service_id['frequency'] == FREQUENCY_ONETIME){
				switch($account_type_short_code){
					case SAVING_SHORT_CODE:
						$res = $this->Adminmodel->deduct_saving_service($data['account_id'], $service_id['charge']);
						if($res!="true"){
							echo '<span class="ion-android-alert failedAlert2"> '. $res .'</span>';
							die();
						}
						break;
					case CURRENT_SHORT_CODE:
						$res = $this->Adminmodel->deduct_current_service($data['account_id'], $service_id['charge']);
						if($res!="true"){
                                                        echo '<span class="ion-android-alert failedAlert2"> '. $res .'</span>';
							die();
                                                }
						break;
					case LOAN_SHORT_CODE:
						$res = $this->Adminmodel->deduct_loan_service($data['account_id'], $service_id['charge']);
						if($res!="true"){
                                                        echo '<span class="ion-android-alert failedAlert2"> '. $res .'</span>';
							die();
                                                }
						break;
					case FD_SHORT_CODE:
						$res = $this->Adminmodel->deduct_fd_service($data['account_id'], $service_id['charge']);
						if($res!="true"){
                                                        echo '<span class="ion-android-alert failedAlert2"> '. $res .'</span>';
							die();
                                                }
						break;
					default:
						echo '<span class="ion-android-alert failedAlert2"> Acconut type not supported </span>';
						die();
				}



			}


			if ($this->db->trans_status() === FALSE)
                                                        {
                                                                echo get_phrase("database_error", true);
                                                                $this->db->trans_rollback();
                                                        }
                                                        else
                                                        {
                                                                $this->db->trans_commit();
								echo "success";
                                                        }
		}
		
	}

	public function serviceSetup($action='',$param1=''){

                if($action=='asyn'){  
			$data['services'] = $this->Adminmodel->get_services('1');
                        $this->load->view('theme/service_master',$data);
                }else if($action==''){
			$data['services'] = $this->Adminmodel->get_services('1');
                        $this->load->view('theme/include/header');
                        $this->load->view('theme/service_master',$data);
                        $this->load->view('theme/include/footer');
                }

                else if($action=='insert'){
			$valid = true;
                        $data['name'] = strtoupper($this->input->get_post('service_name', true));
                        $data['charge'] = $this->input->get_post('service_amount', true);
                        $data['description'] = $this->input->get_post('description', true);
                        $data['frequency'] = $this->input->get_post('frequency', true);
                        $data['status'] = '1';


			if(empty($data['name'])){
				$valid = false;
				echo '<span class="ion-android-alert failedAlert2"> Service Name is Mandatory </span>'; 		
			}

			if(empty($data['charge']) || !is_numeric($data['charge'])){
                                $valid = false;
                                echo '<span class="ion-android-alert failedAlert2"> Invalid Service Amount </span>';
                        }

			if(empty($data['frequency'])){
                                $valid = false;
                                echo '<span class="ion-android-alert failedAlert2"> Frequency is Mandatory </span>';
                        }


			if(!$valid){
				die;
			}


                                        $this->db->insert('bank_service_setup', $data);
					echo "success";
                                 
                }
                else if($action=='deactivate'){
			
			$this->db->set('status', '0')->where('id', $param1)->update('bank_service_setup');	
			echo "success";

                }
	}



	public function add_item($action='',$param1=''){
		$data['items'] = $this->Adminmodel->get_item();
		if($action=='asyn'){  
			$this->load->view('theme/add_item',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_item',$data);
			$this->load->view('theme/include/footer');
		}

		if($action=='insert'){
			$data = array();
			$data['item_name'] = strtoupper($this->input->post('item_name'));
			$data['amount'] = $this->input->post('item_amount');

			$this->form_validation->set_rules('item_name','Service Name','required');
			$this->form_validation->set_rules('item_amount','Service Amount','required');
			if(!value_exists3('bank_items','item_name',$data['item_name'])){
				if (!$this->form_validation->run() == FALSE)
				{
					$do=$this->input->post('action',true);     
					if($do=='insert'){ 
						//Check Duplicate Entry     
						if($this->db->insert('bank_items',$data)){
							$last_id=$this->db->insert_id();    
							echo "true";
						}

					}else if($do=='update'){
						$id=$this->input->post('trace_id',true);  
						//Check Duplicate Entry  
						$this->db->where('tbl_id', $id);
						$this->db->update('bank_items', $data);
						$last_id=$this->db->insert_id();    
						echo "true";


					}

				}
				else{
					//echo "All Field Must Required With Valid Length !";
					echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

				}
			}
			else{
				echo "Service Name Already Exist !";
			}
		}
		else if($action=='update'){

		}

		else if($action=='remove'){
			$this->input->get('');    
			$this->db->delete('bank_items', array('tbl_id' => $param1));        
		}

	}
	public function service_management($action='',$param1=''){
		$data['accounts']=$this->Adminmodel->getAccount();

		if($action=='asyn'){  
			$this->load->view('theme/service_management',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/service_management',$data);
			$this->load->view('theme/include/footer');
		}
		else if($action=='search'){
			$data=array();
			$id = $this->input->get('search');
			$name = $this->input->get('search_name');

			if(!empty($id)||!empty($name)){
				$data['accounts']=$this->Adminmodel->getAccount($id,strtoupper($name));
				if($data['accounts']==null){
					$data['accounts']=$this->Adminmodel->getAllAccounts();
					$this->load->view('theme/include/header');
					$this->load->view('theme/service_management',$data);
					$this->load->view('theme/include/footer');
				}
				else{
					$this->load->view('theme/include/header');
					$this->load->view('theme/manage_account',$data);
					$this->load->view('theme/include/footer');
				}
			}
			else{
				$data['accounts']=$this->Adminmodel->getAllAccounts();
				$this->load->view('theme/include/header');
				$this->load->view('theme/manage_account',$data);
				$this->load->view('theme/include/footer');
			}

		}
		else if($action == 'manage'){
			$id = $this->input->get('id');
			$data = array();
			$data['services'] = $this->Adminmodel->get_services();

			$customer_data = $this->Adminmodel->get_customer_services($id);
			foreach($data['services'] as $value){
				foreach ($customer_data as $customers_data) {	
					if($customers_data->service_id == $value->tbl_id){

						$value->checked=1;
						$value->start_date=$customers_data->start_date;
						$value->end_date=$customers_data->end_date;
					}

				}}

			$this->load->view('theme/include/header');
			$this->load->view('theme/manage_service',$data);
			$this->load->view('theme/include/footer');

		}
		else if($action == 'insert'){

			$id = $this->input->post('member_id');
			$status = $this->Adminmodel->get_account_status($id);
			if($status[0]->status){
				$data['services'] = $this->Adminmodel->get_services();
				if(!empty($data['services'])){
					foreach ($data['services'] as $key) {
						$tag = $this->input->post('tag_'.$key->tbl_id);
						$start_date = $this->input->post('start_date_'.$key->tbl_id);
						$end_date = $this->input->post('end_date_'.$key->tbl_id);

						if($tag){

							$tag1 =  'tag_'.$key->tbl_id;
							$service_id = explode('_',$tag1);

							$data1 = ['member_id'=>$id,'service_id'=>$service_id[1],'start_date'=>$start_date,'end_date'=>$end_date];
							$result = $this->db->insert('service_management',$data1);

						}
					}

				}if(!empty($result)){echo 'true';}
				if(empty($result)){foreach ($data['services'] as $key) { 
					$start_date = $this->input->post('start_date_'.$key->tbl_id);
					$end_date = $this->input->post('end_date_'.$key->tbl_id);
					$service_id = $this->input->post('service_id_'.$key->tbl_id);
					$data1 = ['start_date'=>$start_date,'end_date'=>$end_date];
					$array = ['member_id'=>$id,'service_id'=>$service_id];
					$this->db->where($array);
					$result1 = $this->db->update('service_management',$data1);

				}
				}if(!empty($result1)){echo 'true';}
			}else {echo "Account Deacivated";}	 
		}

	}
	public function item_management($action='',$param1=''){
		$data['accounts']=$this->Adminmodel->getAccount();

		if($action=='asyn'){  
			$this->load->view('theme/item_management',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/item_management',$data);
			$this->load->view('theme/include/footer');
		}
		else if($action=='search'){
			$data=array();
			$id = $this->input->get('search');
			$name = $this->input->get('search_name');

			if(!empty($id)||!empty($name)){
				$data['accounts']=$this->Adminmodel->getAccount($id,strtoupper($name));
				if($data['accounts']==null){
					$data['accounts']=$this->Adminmodel->getAllAccounts();
					$this->load->view('theme/include/header');
					$this->load->view('theme/item_management',$data);
					$this->load->view('theme/include/footer');
				}
				else{
					$this->load->view('theme/include/header');
					$this->load->view('theme/manage_account',$data);
					$this->load->view('theme/include/footer');
				}
			}
			else{
				$data['accounts']=$this->Adminmodel->getAllAccounts();
				$this->load->view('theme/include/header');
				$this->load->view('theme/manage_account',$data);
				$this->load->view('theme/include/footer');
			}
		}
		else if($action == 'manage'){
			$id = $this->input->get('id');
			$data = array();
			$data['member_id'] = $id;
			$data['items'] = $this->Adminmodel->get_item();
			$customer_data = $this->Adminmodel->get_customer_items($id);
			foreach($data['items'] as $value){
				foreach ($customer_data as $customers_data) {	
					if($customers_data->item_id == $value->tbl_id){
						$value->checked=1;
						$value->issue_date=$customers_data->issue_date;
					}}}
			$this->load->view('theme/include/header');
			$this->load->view('theme/manage_item',$data);
			$this->load->view('theme/include/footer');

		}
		else if($action == 'insert'){
			$id = $this->input->post('member_id');
			$status = $this->Adminmodel->get_account_status($id);
			$bal = $this->Adminmodel->get_balance($id);
			if($status[0]->status && $bal->account_balance != 0){


				$data['items'] = $this->Adminmodel->get_item();
				if(!empty($data['items'])){
					foreach ($data['items'] as $key) {
						$tag = $this->input->post('tag_'.$key->tbl_id);
						$issue_date = $this->input->post('issue_date'.$key->tbl_id);
						if($tag){
							$tag1 =  'tag_'.$key->tbl_id;
							$item_id = explode('_',$tag1);
							$data1 = ['member_id'=>$id,'item_id'=>$item_id[1],'issue_date'=>$issue_date];

							$result = $this->db->insert('item_management',$data1);
							$result1 = $this->Adminmodel->get_balance($id);
							$this->db->select('amount');
							$this->db->from('bank_items');
							$this->db->where('tbl_id',$item_id[1]);
							$query = $this->db->get();
							$result2 = $query->row();
							if($result1->account_balance >= $result2->amount){
								$data2['account_balance'] = $result1->account_balance - $result2->amount;
								$this->db->where('member_id',$id);
								$result = $this->db->update('bank_accounts',$data2);                                       
							}
						}}if(!empty($result)){echo 'true';}} 
				if(empty($result)){foreach ($data['items'] as $key) { 

					$issue_date= $this->input->post('issue_date'.$key->tbl_id);
					$item_id= $this->input->post('service_id_'.$key->tbl_id);
					$data1 = ['member_id'=>$id,'item_id'=>$item_id,'issue_date'=>$issue_date];
					$array = ['member_id'=>$id,'item_id'=>$item_id];
					$this->db->where($array);
					$result1 = $this->db->update('item_management',$data1);
					$this->db->select('amount');
					$this->db->from('bank_items');
					$this->db->where('tbl_id',$item_id);
					$query = $this->db->get();
					$result2 = $query->row();
					$result1 = $this->Adminmodel->get_balance($id);
					if($result1->account_balance >= $result2->amount){
						$data2['account_balance'] = $result1->account_balance - $result2->amount;
						$this->db->where('member_id',$id);
						$result = $this->db->update('bank_accounts',$data2);                                       
					}
				} if(!empty($result1)){echo 'true';}}

			}else{echo "Account Deactivated Or Have Insufficient Balance";}

		}

	}            

	public function take_fixed_deposit($action='')
	{
		$data['services'] = $this->Adminmodel->get_services();
		$data['account_type'] = $this->Adminmodel->get_account_types();
		if($action=='asyn'){
			$this->load->view('theme/take_fixed_deposit',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/take_fixed_deposit',$data);
			$this->load->view('theme/include/footer');
		}
		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='take'){  
			$data=array();
			$do=$this->input->post('action',true);     
			$data['member_id']=$this->input->post('member_id',true);
			$data['fixed_deposit_amount']=$this->input->post('fixed_deposit_amount',true);  
			$data['maturity_amount']=$this->input->post('maturity_amount',true);  
			$data['maturity_date']=$this->input->post('maturity_date',true);
			$fd_id=$this->input->post('fd_id',true);
			$data['taken_on']=$this->input->post('taken_on',true);
			$data['duration']=$this->input->post('duration',true);
			$data['interest']=$this->input->post('interest',true);
			$data['fd_id']=$this->input->post('fd_id',true);
			//-----Validation-----//   


			$this->form_validation->set_rules('member_id', 'Member Id', 'trim|required|min_length[1]|max_length[30]');
			if (!$this->form_validation->run() == FALSE)
			{
				$status = $this->Adminmodel->get_account_status($data['member_id']);
				if($status[0]->status){
					if(!value_exists4('bank_fixed_deposit','taken',$data['member_id'])){
						//Check Duplicate Entry  
						//if(!value_exists("bank_accounts","member_id",$data['member_id'])){ 
						$response = $this->Adminmodel->select_fixed_deposit($data['member_id'],$data['fd_id']); 
						$response = $response[0]->N;
						$data3['bal'] = $data['fixed_deposit_amount']*pow((1 + ($data['interest']/100)/$response),$data['duration']*$response);


						$data1['type']='Fixed'; 
						$data1['amount']= $data['fixed_deposit_amount']; 
						$data1['p_method']=''; 
						$data1['ref']=''; 
						$data1['note']='';  
						$data1['dr']=0;  
						$data1['cr']=$data['fixed_deposit_amount'];
						$data1['user_id']=$this->session->userdata('user_id');
						$data1['member_id']=$this->input->post('member_id');
						$bal = $this->Adminmodel->get_balance($data['member_id']);
						$data1['bal']=$bal->account_balance + $balance;
						$data3['account_balance'] = $balance+$data['fixed_deposit_amount'];
						$this->db->insert('transaction',$data1);
						$this->db->where('member_id',$data['member_id']);
						$this->db->update('bank_accounts',$data3);
						$array = ['fd_id'=>$fd_id,'member_id'=>$data['member_id']];
						$data2['taken'] = 1;
						$this->db->where($array);
						$this->db->update('bank_fixed_deposit',$data2);
						echo 'true';



						// }else{
						// 	echo "This Account Is Already Exists !"; 
						// }
					}
					else{
						echo "Fd Taken Already !";
					}        
				}
				else{
					echo "Account Deactive!";
				}        
			}else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}
			//----End validation----//         
		}
		else if($action=='update'){
			$id=$this->input->post('member_id',true);
			$data = array();
			$data['bank_account_type']= $this->input->post('bank_account_type');
			$data['bank_account_number']=$this->input->post('bank_account_number');
			$data['account_balance']=$this->input->post('account_balance');

			$this->form_validation->set_rules('bank_account_type','Bank Account Type','trim|required');
			if(!$this->form_validation->run()==FALSE){

				$this->db->where('member_id', $id);
				$this->db->update('bank_accounts', $data);
				//transaction table
				// $data1=array();
				// $this->db->where('member_id', $id);
				// $this->db->update('transaction', $data1);

				// //repeat transaction table
				// $data2=array();
				// $data2['member_name']=$this->input->get('member_name');
				// $this->db->where('member_name', $old_name->accounts_name);
				// $this->db->where('member_id', $id);
				// $this->db->update('repeat_transaction', $data2);
			}else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

			}
			$data['account_type'] = $this->Adminmodel->get_account_types();
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_account',$data);
			$this->load->view('theme/include/footer');

		}
		else if($action=='remove'){    
			$this->db->delete('bank_accounts', array('member_id' => $param1));        
		}
	}
	public function get_user_fd(){
		$member_id = $this->input->post('id');
		$data = $this->Adminmodel->get_user_fd($member_id);
		echo json_encode($data);
	}
	public function late_fees_charges($action='',$param1=''){
		$data['charges'] = $this->Adminmodel->get_late_fees();
		if($action=='asyn'){  
			$this->load->view('theme/late_fee_charges',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/late_fee_charges',$data);
			$this->load->view('theme/include/footer');
		}

		if($action=='insert'){
			$this->db->select('COUNT(*) as row');
			$this->db->from('late_fees');
			$query = $this->db->get();
			$row_return=$query->row();
			if($row_return->row ==0){
				$data = array();
				$data['amount'] = strtoupper($this->input->post('amount'));

				$this->form_validation->set_rules('amount','amount','required');
				if (!$this->form_validation->run() == FALSE)
				{
					$do=$this->input->post('action',true);     
					if($do=='insert'){ 
						//Check Duplicate Entry     
						if($this->db->insert('late_fees',$data)){
							$last_id=$this->db->insert_id();    
							echo "true";
						}

					}else if($do=='update'){
						$id=$this->input->post('trace_id',true);  
						//Check Duplicate Entry  
						$this->db->where('tbl_id', $id);
						$this->db->update('late_fees', $data);
						$last_id=$this->db->insert_id();    
						echo "true";


					}

				}
				else{
					//echo "All Field Must Required With Valid Length !";
					echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

				}
			}else{
				//echo "All Field Must Required With Valid Length !";
				echo "Operation not allowed";

			}
		}
		else if($action=='update'){

		}

		else if($action=='remove'){
			$this->input->get('');    
			$this->db->delete('late_fees', array('tbl_id' => $param1));        
		}

	}
	public function get_user_late_fee(){

		$id = $this->input->post('member_id');

		$data = $this->Adminmodel->get_user_late_fee($id);
		echo json_encode($data);
	}
	public function get_current_emi(){
		$loan_id = $this->input->post('loan_id');
		$id = $this->input->post('member_id');
		$data = $this->Adminmodel->get_current_emi($id,$loan_id);
		echo json_encode($data);
	}
	public function loan_reminder(){
		$data = $this->Adminmodel->loan_reminder();
		echo json_encode($data);
	}
	public function process_data($action='',$param1=''){
		$data['accounts']=$this->Adminmodel->getAccount();

		if($action=='asyn'){  
			$this->load->view('theme/process_data',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/process_data',$data);
			$this->load->view('theme/include/footer');
		}

		else if($action == 'manage'){
			$data['services'] = $this->Adminmodel->get_services();

			$customer_data = $this->Adminmodel->get_customer_services($id);
			foreach($data['services'] as $value){
				foreach ($customer_data as $customers_data) {	
					if($customers_data->service_id == $value->tbl_id){

						$value->checked=1;
						$value->start_date=$customers_data->start_date;
						$value->end_date=$customers_data->end_date;
					}

				}}

			$this->load->view('theme/include/header');
			$this->load->view('theme/manage_service',$data);
			$this->load->view('theme/include/footer');

		}
		else if($action == 'insert'){
			$id = $this->input->post('member_id');
			$data['services'] = $this->Adminmodel->get_services();
			foreach ($data['services'] as $key) {
				$tag = $this->input->post('tag_'.$key->tbl_id);
				$start_date = $this->input->post('start_date_'.$key->tbl_id);
				$end_date = $this->input->post('end_date_'.$key->tbl_id);
				if($tag){

					$tag1 =  'tag_'.$key->tbl_id;
					$service_id = explode('_',$tag1);
					$data1 = ['member_id'=>$id,'service_id'=>$service_id[1],'start_date'=>$start_date,'end_date'=>$end_date];
					$result = $this->db->insert('service_management',$data1);
				}

			}

			if($result){echo 'true';};

		}

	}
	public function get_user_last_emi(){

		$id = $this->input->post('member_id');
		$data = $this->Adminmodel->get_user_last_emi($id);
		echo json_encode($data);
	}

	public function id_gen($identifier,$prev,$mode)
	{
		if($mode==0)
		{
			$id=$identifier."0000001";
		}
		else
		{
			$temp= substr($prev,3)+1;
			$id=$identifier.str_repeat("0",7-strlen($temp)).$temp;

		}
		return $id;
	}

	private function invalid_account($member_id, $account_type){
		return $this->Adminmodel->get_account_count($member_id, $account_type);
		
	}

	public function get_account_detail(){
		$account_number = $this->input->post('account_number', true);
		$account_detail = $this->Adminmodel->fetch_account_detail($account_number);
		
		if(empty($account_detail)){
			echo null;
		}

		$account_type_detail = $this->Adminmodel->fetch_account_type_detail($account_detail['bank_account_id']);
                $account_type_detail = $account_type_detail[0];

		
	
		if(!empty($this->input->post('account_type_id'))){
                        $account_type_id = $this->input->post('account_type_id', true);
                }else{
                        $account_type_id = $account_detail['bank_account_id'];
                }


		$account_type_short_code = null;	
		if(!empty($this->input->post('account_type_short_code'))){
			$account_type_short_code = $this->input->post('account_type_short_code', true);
		}else{
			$account_type_short_code = $account_type_detail['html_id'];
		}

		$status=null;

		if(!empty($this->input->post('account_status'))){
                        $status = $this->input->post('account_status', true);
                }else{
                        $status = 1;
                }
	
		$result = $this->Adminmodel->get_account_member_detail($account_number, $status, $account_type_id, $account_type_short_code);
		
		if(empty($result)){
			echo null;
		}else{
			echo json_encode($result[0]);
		}

		
	}


	 public function deactivateMember($member_id,$action='')
        {
                $this->db->select('*');
                $this->db->from('member_details');
                $this->db->where("member_id",$member_id);
                $result=$this->db->get()->result_array()[0];

		$this->db->set('share', '0');
                $this->db->where('member_id', $member_id);
                $this->db->update('member_details');
		

                $share = $result['share'];

                $this->db->set('value', 'value+'.$share, FALSE);
                $this->db->where('module_id', 'share_management');
                $this->db->where('name', 'total_share');
                $this->db->update('general_detail');
                

                $data = array();
                $data['status'] = 0;
                $this->db->where('member_id', $member_id);
                $this->db->update('member_details', $data);
                echo 1;

        }

	public function activateMember($member_id,$action='')
        {
                $data = array();
                $data['status'] = 1;
                $this->db->where('member_id', $member_id);
                $this->db->update('member_details', $data);
                echo 1;

        }



}
