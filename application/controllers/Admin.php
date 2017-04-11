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

							$this->db->trans_complete();
							if ($this->db->trans_status() === FALSE)
							{
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

	public function addAccount($action='',$param1='')
	{

		$data['services'] = $this->Adminmodel->get_services();
		$data['account_type'] = $this->Adminmodel->get_account_types();
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

	/** Method For view Manage Account Page **/ 
	public function manageAccount($action='')
	{
		$data=array();  
		$data['accounts']=$this->Adminmodel->getAllAccounts();
		if($action=='asyn'){ 
			$this->load->view('theme/manage_account',$data);   
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/manage_account',$data);
			$this->load->view('theme/include/footer');
		}
		else if($action=='search'){
			$data=array();
			$id = $this->input->get('search');
			$name = $this->input->get('search_name');

			if(!empty($id)||!empty($name)){
				$data['accounts']=$this->Adminmodel->getAccount($id,strtoupper($name));
				$this->load->view('theme/include/header');
				$this->load->view('theme/manage_account',$data);
				$this->load->view('theme/include/footer');
			}
			else{
				$data['accounts']=$this->Adminmodel->getAllAccounts();
				$this->load->view('theme/include/header');
				$this->load->view('theme/manage_account',$data);
				$this->load->view('theme/include/footer');
			}

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
	public function addIncome($action='',$param1='')
	{
		$data=array();
		$data['accounts']=$this->Adminmodel->getAllAccounts();
		$data['category']=$this->Adminmodel->getChartOfAccountByType('Income');
		$data['payers']=$this->Adminmodel->getPayeryAndPayeeByType('Payer');
		$data['p_method']=$this->Adminmodel->getAllPaymentmethod();
		$data['t_data']=$this->Adminmodel->getTransaction(20,'Income');
		if($action=='asyn'){  
			$this->load->view('theme/add_income',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/add_income',$data);
			$this->load->view('theme/include/footer');
		}

		//----End Page Load------//
		//----For Insert update and delete-----// 
		if($action=='insert'){  
			$data=array();
			$do=$this->input->post('action',true);     
			$data['trans_date']=Date('Y-m-d'); 
			$data['type']='Income'; 
			$data['amount']=$this->input->post('amount',true); 
			$data['p_method']=$this->input->post('p-method',true); 
			$data['ref']=$this->input->post('reference',true); 
			$data['note']=$this->input->post('note',true);  
			$data['dr']=0;  
			$data['cr']=$this->input->post('amount',true);
			$data['user_id']=$this->session->userdata('user_id');
			$data['member_id']=$this->input->post('member_id');
			$data['cheque_no']=$this->input->post('cheque_no');
			// $data['trans_date']=Date('Y-m-d'); 
			// $data['type']='Income'; 
			// $data['category']=$this->input->post('income-type',true); 
			// $data['amount']=$this->input->post('amount',true); 
			// $data['payer']=$this->input->post('payer',true); 
			// $data['payee']=''; 
			// $data['p_method']=$this->input->post('p-method',true); 
			// $data['ref']=$this->input->post('reference',true); 
			// $data['note']=$this->input->post('note',true);  
			// $data['dr']=0;  
			// $data['cr']=$this->input->post('amount',true);
			// $data['user_id']=$this->session->userdata('user_id');
			// $data['member_id']=$this->input->post('member_id');

			//-----Validation-----//   
			$this->form_validation->set_rules('member_id', 'Member Id', 'trim|required');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('p-method', 'Payment Method', 'trim|required');
			$this->form_validation->set_rules('reference', 'Reference No', 'trim|required');
			$this->form_validation->set_rules('note', 'Note', 'trim|required|min_length[8]');
			$this->form_validation->set_rules('account_balance','Create Member Account First','trim|required');
			if($data['p_method']=='CHEQUE'){$this->form_validation->set_rules('cheque_no','Cheque','trim|required');}
			if (!$this->form_validation->run() == FALSE)
			{   
				$status = $this->Adminmodel->get_account_status($data['member_id']);

				if($status[0]->status){
					$data['bal']=$this->Adminmodel->getBalance('',$data['amount'],"add", $this->input->post('member_id'));      

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

				}else{
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
		$data['accounts']=$this->Adminmodel->getAllAccounts();
		$data['p_method']=$this->Adminmodel->getAllPaymentmethod();

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
			$data=array();
			$do=$this->input->post('action',true);  
			$data['member_id']=$this->input->post('from-account',true);    
			$data['trans_date']=$this->input->post('transfer-date',true); 
			$data['type']='Transfer'; 
			$data['amount']=$this->input->post('amount',true);  
			$data['p_method']=$this->input->post('p-method',true); 
			$data['ref']=$this->input->post('reference',true); 
			$data['note']=$this->input->post('note',true);  
			$data['dr']=$this->input->post('amount',true); 
			$data['cheque_no']=$this->input->post('cheque_no',true); 
			$data['cr']=0;
			$data['user_id']=$this->session->userdata('user_id');		
			//          $do=$this->input->post('action',true);     
			// $to_account=$this->input->post('to-account',true); 
			// $data['accounts_name']=$this->input->post('from-account',true); 
			// $data['trans_date']=$this->input->post('transfer-date',true); 
			// $data['type']='Transfer'; 
			// $data['category']=''; 
			// $data['amount']=$this->input->post('amount',true); 
			// $data['payer']=''; 
			// $data['payee']=''; 
			// $data['p_method']=$this->input->post('p-method',true); 
			// $data['ref']=$this->input->post('reference',true); 
			// $data['note']=$this->input->post('note',true);  
			// $data['dr']=$this->input->post('amount',true); 
			// $data['cr']=0;
			// $data['bal']=$this->Adminmodel->getBalance($data['member_id'],$data['amount'],"sub");
			// $data['user_id']=$this->session->userdata('user_id');		
			//          $data['member_id'] = 0;
			//-----Validation-----//   

			$this->form_validation->set_rules('from-account', 'From Account', 'trim|required');
			$this->form_validation->set_rules('to-account', 'To Account', 'trim|required');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('p-method', 'Payment Method', 'trim|required');
			$this->form_validation->set_rules('reference', 'Reference No', 'trim|required');
			$this->form_validation->set_rules('note', 'Note', 'trim|required|min_length[8]');
			if($data['p_method']=='CHEQUE'){$this->form_validation->set_rules('cheque_no','Cheque','trim|required');}
			if (!$this->form_validation->run() == FALSE)
			{

				$bal = $this->Adminmodel->getBalance('',$data['amount'],'user',$this->input->post('member_id'));
				if($bal){
					if($do=='insert'){ 
						$data['bal']=$this->Adminmodel->getBalance('',$data['amount'],"sub",$data['member_id']);

						if($data['member_id']!= $this->input->post('to-account',true)){  
							$status = $this->Adminmodel->get_account_status($data['member_id']);
							if($status[0]->status){$member_id1 = $this->input->post('to-account',true);
								$status1 = $this->Adminmodel->get_account_status($member_id1);
								if($status1[0]->status){
									$this->db->trans_begin();  
									$this->db->insert('transaction',$data);
									$data['member_id']=$this->input->post('to-account',true);
									$data['dr']=0;
									$data['cr']=$this->input->post('amount',true); 
									$data['bal']=$this->Adminmodel->getBalance('',$data['amount'],"add",$data['member_id']);
									$this->db->insert('transaction',$data);

									if ($this->db->trans_status() === FALSE)
									{
										$this->db->trans_rollback();
									}else{
										echo "true";    
										$this->db->trans_commit();    
									}
								}

								else{
									echo "To Account ".$member_id1." Deactivated";
								}
							}else{
								echo "From Account ".$this->input->post('from-account',true)." Deactivated";
							}

						}else{
							echo "Sorry, Cannot Transfer Between Same Account !";   
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


			}else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');
			}
			//----End validation----//         
		}
		else if($action=='remove'){    
			$this->db->delete('transaction', array('trans_id' => $param1));        
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
		$this->db->select('member_name');
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
	public function payLoan($action=''){
		$data1['payers']=$this->Adminmodel->getPayeryAndPayeeByType('Payer');
		$data1['p_method']=$this->Adminmodel->getAllPaymentmethod();
		if($action=='asyn'){  
			$this->load->view('theme/pay_loan',$data1);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/pay_loan',$data1);
			$this->load->view('theme/include/footer');
		}
		if($action=='insert'){
			$do=$this->input->post('action');
			$data['member_id'] = $this->input->post('member_id');
			$data['amount'] = $this->input->post('amount');
			$data['payment_method']=$this->input->post('p-method');
			$data['reference_no'] = $this->input->post('reference');
			$data['note'] = $this->input->post('note');
			$data['date'] = Date('Y-m-d');
			$account_balance = $this->input->post('account_balance');
			$data['loan_id'] = $this->input->post('loan_id');
			$data['cheque_no'] = $this->input->post('cheque_no');                        
			$this->form_validation->set_rules('member_id','Member Id','required');
			$this->form_validation->set_rules('loan_id','Loan Id','required');
			$this->form_validation->set_rules('amount','Amount','required');
			$this->form_validation->set_rules('p-method','p-method','required');
			$this->form_validation->set_rules('member_name','Member Account Name Doen No exist','required');
			if($data['payment_method']=='CHEQUE'){$this->form_validation->set_rules('cheque_no','Cheque','trim|required');}
			if (!$this->form_validation->run() == FALSE)
			{	
				$status = $this->Adminmodel->get_account_status($data['member_id']);
				if($status[0]->status){
					$this->Adminmodel->get_late_fees1($data['member_id']);
					if($account_balance>$data['amount']){

						$emis_amount = $this->Adminmodel->get_emi($data['member_id'],$data['loan_id'],$data['amount']);
						if($emis_amount){
							$response = $this->Adminmodel->getBalance($data['member_id'],$data['amount'],"loan", $this->input->post('member_id'),$data['loan_id']);

							if($response){
								$this->Adminmodel->getBalance('',$data['amount'],"sub", $this->input->post('member_id')); 
								$this->db->insert('loan_transaction',$data);
								$data2['type']='LoanEmi'; 
								$data2['trans_date']=Date('Y-m-d');
								$data2['amount']= $data['amount']; 
								$data2['p_method']=$data['payment_method']; 
								$data2['ref']=$data['reference_no']; 
								$data2['note']=$data['note'];  
								$data2['dr']=$data['amount'];  
								$data2['cr']=0;
								$data2['cheque_no'] = $data['cheque_no'];
								$data2['user_id']=$this->session->userdata('user_id');
								$data2['member_id']=$this->input->post('member_id');
								$bal = $this->Adminmodel->get_balance($data['member_id']);
								$data2['bal']=$bal->account_balance + $data['amount'];
								$this->db->insert('transaction',$data2);
								//insert Transaction Data

								echo "true";   
							}
							else{
								//echo "All Field Must Required With Valid Length !";
								echo "All Emis Paid";
							}

						}else{
							//echo "All Field Must Required With Valid Length !";
							echo 'Please Pay Under Total Emi Amount';

						}



					}else{ echo "You Dont Have Saficiant Balance ";}
				}else{ echo "Account Deactivated";}
			}
			else{
				//echo "All Field Must Required With Valid Length !";
				echo validation_errors('<span class="ion-android-alert failedAlert2"> ','</span>');

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
	public function customerServices($action='',$param1=''){
		$data['services'] = $this->Adminmodel->get_services();
		if($action=='asyn'){  
			$this->load->view('theme/customer_services',$data);
		}else if($action==''){
			$this->load->view('theme/include/header');
			$this->load->view('theme/customer_services',$data);
			$this->load->view('theme/include/footer');
		}

		if($action=='insert'){
			$data = array();
			$data['service_name'] = strtoupper($this->input->post('service_name'));
			$data['service_amount'] = $this->input->post('service_amount');

			$this->form_validation->set_rules('service_name','Service Name','required');
			$this->form_validation->set_rules('service_amount','Service Amount','required');
			if(!value_exists3('customer_services','service_name',$data['service_name'])){
				if (!$this->form_validation->run() == FALSE)
				{
					$do=$this->input->post('action',true);     
					if($do=='insert'){ 
						//Check Duplicate Entry     
						if($this->db->insert('customer_services',$data)){
							$last_id=$this->db->insert_id();    
							echo "true";
						}

					}else if($do=='update'){
						$id=$this->input->post('trace_id',true);  
						//Check Duplicate Entry  
						$this->db->where('tbl_id', $id);
						$this->db->update('customer_services', $data);
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
			$this->db->delete('customer_services', array('tbl_id' => $param1));        
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

}
