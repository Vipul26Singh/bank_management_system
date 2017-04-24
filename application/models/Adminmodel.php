<?php

class AdminModel extends CI_Model{

	//get all Chart Of Accounts  
	public function getAllChartOfAccounts(){
		$this->db->select('*');
		$this->db->from('chart_of_accounts');  
		$this->db->order_by("chart_id", "desc"); 
		//$this->db->where("user_id",$this->session->userdata('user_id'));    
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;

	} 

	//get Chart Of Accounts by type 
	public function getChartOfAccountByType($type){
		$this->db->select('*');
		$this->db->from('chart_of_accounts');  
		$this->db->where('accounts_type',$type); 
		//$this->db->where("user_id",$this->session->userdata('user_id'));  
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;

	}
	//get all payer and payee    
	public function getAllPayeryAndPayee(){
		$this->db->select('*');
		$this->db->from('payee_payers'); 
		//$this->db->where("user_id",$this->session->userdata('user_id'));  
		$this->db->order_by("trace_id", "desc");    
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;

	} 

	//get payer and payee by type   
	public function getPayeryAndPayeeByType($type){
		$this->db->select('*');
		$this->db->from('payee_payers');  
		$this->db->where("type", $type); 
		//$this->db->where("user_id",$this->session->userdata('user_id'));    
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;

	} 


	//get all payment method   
	public function getAllPaymentmethod(){
		$this->db->select('*');
		$this->db->from('payment_method'); 
		//$this->db->where("user_id",$this->session->userdata('user_id'));  
		$this->db->order_by("p_method_id", "desc");    
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;

	}   

	//get all user     
	public function getAllUsers(){
		$this->db->select('*');
		$this->db->from('user');  
		$this->db->order_by("user_id", "desc");    
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;

	}    

	

	//get all settings  
	public function getAllSettings(){
		$this->db->select('*');
		$this->db->from('settings');    
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;

	}  


	//get all Personal/Bank Account 
	public function getAllAccounts(){
		$this->db->select('b.member_id,(SELECT bank_account_types.account_name from bank_account_types where tbl_id = a.bank_account_type) as bank_account_type,
			a.bank_account_number,
			a.account_balance,a.opening_date,b.member_name,a.status');
			$this->db->from('bank_accounts a,member_details b'); 
			$this->db->where('a.member_id = b.member_id');
			$this->db->where('a.status = 1');
		$query = $this->db->get();
		$result = $query->result();
		return $result;

	}  


	//get account by id  
	public function getAccount($accounts_id='',$account_name='',$member_id=''){
		if(!empty($accounts_id)){

		// 	$query=$this->db->query("SELECT b.member_id,a.bank_account_type,a.bank_account_number,a.account_balance,a.date,b.member_name,a.share_id FROM bank_accounts a,member_details b WHERE a.member_id='".$accounts_id."' AND b.member_id=".$accounts_id); 
		 //$this->db->select('member_details.member_id,(SELECT bank_account_types.account_name from bank_account_types where bank_account_types.tbl_id = bank_accounts.bank_account_type) as bank_account_type,bank_accounts.bank_account_number, bank_accounts.account_balance, bank_accounts.opening_date, member_details.member_name, bank_accounts.share_id,');
		$this->db->select('member_details.member_id,bank_accounts.status,bank_accounts.bank_account_type,bank_accounts.bank_account_number, bank_accounts.account_balance, bank_accounts.opening_date, member_details.member_name');
                $this->db->from('bank_accounts');
		$this->db->join('member_details','bank_accounts.member_id=member_details.member_id','inner');
        // $this->db->join('service_management','service_management.member_id=member_details.member_id','inner');      
		$this->db->where('bank_accounts.bank_account_number',$accounts_id);
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;}
		else if(!empty($account_name)){
		
		// $query=$this->db->query("SELECT member_details.member_name,member_details.member_id,bank_accounts.bank_account_type,bank_accounts.bank_account_number,bank_accounts.account_balance,bank_accounts.date FROM bank_accounts INNER JOIN member_details ON bank_accounts.member_id = member_details.member_id WHERE member_details.member_name LIKE '%".$account_name."%'");
			$this->db->select('member_details.member_name,
				member_details.member_id,bank_accounts.bank_account_type,
				bank_accounts.bank_account_number,
				bank_accounts.account_balance,bank_accounts.opening_date,bank_accounts.status');
			$this->db->from('bank_accounts');
			$this->db->join('member_details','bank_accounts.member_id = member_details.member_id','inner');
                       
			$this->db->where("(member_details.member_name LIKE '%".$account_name."%')");
			$query = $this->db->get();
			$result = $query->result();
			return $result;
			}
			
                    else if($member_id!=''){       	
		// $query=$this->db->query("SELECT member_details.member_name,member_details.member_id,bank_accounts.bank_account_type,bank_accounts.bank_account_number,bank_accounts.account_balance,bank_accounts.date FROM bank_accounts INNER JOIN member_details ON bank_accounts.member_id = member_details.member_id WHERE member_details.member_name LIKE '%".$account_name."%'");
                        $this->db->select('member_details.member_id,bank_accounts.bank_account_type,bank_accounts.bank_account_number, bank_accounts.account_balance, bank_accounts.opening_date, member_details.member_name');
			$this->db->from('bank_accounts');
			$this->db->join('member_details','bank_accounts.member_id = member_details.member_id','inner');
                       
			$this->db->where("member_details.member_id=".$member_id);
			$query = $this->db->get();
			$result = $query->result();
			return $result;
			}
                        else if($accounts_id==''||$account_name==''){       	
		// $query=$this->db->query("SELECT member_details.member_name,member_details.member_id,bank_accounts.bank_account_type,bank_accounts.bank_account_number,bank_accounts.account_balance,bank_accounts.date FROM bank_accounts INNER JOIN member_details ON bank_accounts.member_id = member_details.member_id WHERE member_details.member_name LIKE '%".$account_name."%'");
                $this->db->select('member_details.member_name,
				member_details.member_id,bank_accounts.bank_account_type,
				bank_accounts.bank_account_number,
				bank_accounts.account_balance,bank_accounts.opening_date');
			$this->db->from('bank_accounts');
			$this->db->join('member_details','bank_accounts.member_id = member_details.member_id','inner');
                       
			$this->db->where("(member_details.member_name LIKE '%".$account_name."%')");
			$query = $this->db->get();
			$result = $query->result();
			return $result;
			}
	} 


	//method for calculating balance
	public function getBalance($account,$amount='',$action,$member_id='',$loan_id='')
	{
		if($action=='add'){
			//get last balance
			$this->db->select('account_balance');
			$this->db->from('bank_accounts');
			$array = array('member_id'=>$member_id,'user_id'=>$this->session->userdata('user_id'));
			$this->db->where($array);
			$query = $this->db->get();
			$result=$query->row();
			$data['account_balance'] = $result->account_balance+$amount;
                       
			$this->db->where('member_id',$member_id);
			$this->db->update('bank_accounts', $data);
			return $data['account_balance'];
		}else if($action=='sub'){
			//get last balance
			$this->db->select('account_balance');
			$this->db->from('bank_accounts');
			$array = array('member_id'=>$member_id,'user_id'=>$this->session->userdata('user_id'));
			$this->db->where($array);
			$this->db->order_by('account_balance','desc');
			$this->db->limit(1);
			$query = $this->db->get();
			$result=$query->row();
			$data['account_balance'] = $result->account_balance-$amount;
			$this->db->where('member_id',$member_id);
			$this->db->update('bank_accounts', $data);
			return $data['account_balance'];
		}
		else if($action=='user'){
			//get last balance
			$this->db->select('account_balance');
			$this->db->from('bank_accounts');
			$array = array('member_id'=>$member_id,'user_id'=>$this->session->userdata('user_id'));
			$query = $this->db->get();
			$result=$query->row();
			if($result->account_balance > $amount){
				return $result->account_balance;
			}else{
				return 0;
			}
		}
		else if($action=='other'){
			$query=$this->db->query("SELECT total_loan_amount_with_interest FROM bank_loan
					WHERE member_id='".$member_id."' AND user_id=".$this->session->userdata('user_id'));
			$result=$query->row();
			$data['total_loan_amount_with_interest'] = $result->total_loan_amount_with_interest-$amount;
			$this->db->where('loan_id',$loan_id);
			$this->db->update('bank_loan', $data);
			$data=array();
			$query=$this->db->query("SELECT account_balance FROM bank_accounts
					WHERE member_id=".$member_id);
			$result=$query->row();
			$data['account_balance'] = $result->account_balance-$amount;
			$this->db->where('member_id',$member_id);
			$this->db->update('bank_accounts', $data);
			


			$array = ['member_id'=>$account,'loan_id'=>$loan_id,'paid'=>1];
			$array2 = ['member_id'=>$account,'loan_id'=>$loan_id];
			$array3 = ['member_id'=>$account,'loan_id'=>$loan_id,'paid'=>0];
			$this->db->select("bank_emi.extra_amount");
			$this->db->from('bank_emi');
			$this->db->where($array);
			$this->db->order_by('date','desc');
			$this->db->limit(1);
			$query = $this->db->get();
			$result=$query->row();
			$this->db->select('total_loan_amount_with_interest');
                	$this->db->from('bank_loan');
                	$this->db->where($array2);
                	$query = $this->db->get();
					$total_balance = $query->row();
					
					if($total_balance->total_loan_amount_with_interest <= '0'){
						
						$data5['paid']= 1;
						$data5['date'] = Date('Y-m-d');
						$this->db->where($array3);
						$this->db->update('bank_emi',$data5);
						$result =1;
                       
                    }
		}
                else if($action=='service'){
                        $today_date = Date('Y-m-d');
                        $this->db->select('member_id');
                        $this->db->from('service_management');
                         $array = ['service_id'=>$account,'end_date <'=>$today_date];
                        $this->db->where($array);
                        $query = $this->db->get();
						$result=$query->result();
			            foreach ($result as $member) {
			            	$this->db->select('account_balance,member_id');
			            	$this->db->from('bank_accounts');
			            	$array =['member_id'=>$member->member_id,'account_balance >'=>$amount];
			            	$this->db->where($array);
			            $query = $this->db->get();
			            $result=$query->result();			       
                        $data1 = ['service'=>$account,'amount'=>$amount,'date'=>Date('Y-m-d')]; 
                        $this->db->insert('service_transactions',$data1);
                        foreach ($result as $accounts){  

                            $data['account_balance'] = $accounts->account_balance - $amount ;
                           
                           $this->db->where('member_id',$accounts->member_id);
                           $this->db->update('bank_accounts',$data);
                           
                          $data2['end_date'] = Date('Y-m-d',strtotime('+1year',strtotime(Date('Y-m-d'))));
                          $array2 = ['member_id'=>$accounts->member_id,'service_id'=>$account];
                           $this->db->where($array2);
                           $this->db->update('service_management',$data2);
                        }
			            }
                        return true;
                }
                else if($action=='service_user'){
                   
                        $this->db->select('account_balance');
                        $this->db->from('bank_accounts');
                        $array =['member_id'=>$member->member_id,'account_balance >'=>$amount];
                        $this->db->where($array);
                        $query = $this->db->get();
			            $result=$query->row();
                         $this->db->select('service_amount');
                        $this->db->from('customer_services');
                        $this->db->where('tbl_id',$account);
                         $query = $this->db->get();
			$result1=$query->row();
                        $amount = $result->account_balance - $result1->service_amount;
                        $data1 = ['service'=>$account,'amount'=>$amount,'date'=>Date('Y-m-d')]; 
                        $this->db->insert('service_transactions',$data1);
                        $data['account_balance'] = $amount; 
                        $this->db->where('member_id',$member_id);
                        $this->db->update('bank_accounts',$data);
                        return true;
                }
                else if($action=='loan'){
			//get last balance
               	$this->db->select('total_loan_amount_with_interest');
                 	$this->db->from('bank_loan');
               	$array2 = ['member_id'=>$account,'loan_id'=>$loan_id];
                	$this->db->where($array2);
                 	$query = $this->db->get();
			$total_loan_amount_with_interest = $query->row();
			$this->db->select('COUNT(paid) as paid');
                	$this->db->from('bank_emi');
                 	$array2 = ['member_id'=>$account,'loan_id'=>$loan_id,'paid'=>0];
                 	$this->db->where($array2);
                 	$query = $this->db->get();
                 	$emis = $query->row();
                	if($emis->paid != 0){
                        $array = ['member_id'=>$account,'loan_id'=>$loan_id,'paid'=>0];
			$this->db->select("bank_emi.emi_amount");
			$this->db->from('bank_emi');
			$this->db->where($array);
			$this->db->order_by('date','asc');
			$this->db->limit(1);
			$query = $this->db->get();
			$result=$query->row();
			
			if($total_loan_amount_with_interest->total_loan_amount_with_interest == $amount){				
		        	$data1['paid_emi']= $amount;
				$data1['paid']= 1;
				$data1['paid_date'] = Date('Y-m-d');
				$this->db->where($array);
				$this->db->update('bank_emi',$data1);
				$update['total_loan_amount_with_interest']  = $total_loan_amount_with_interest->total_loan_amount_with_interest - $amount;
                 	        $array5 = ['member_id'=>$account,'loan_id'=>$loan_id];
                 	        $this->db->where($array5);
                 	       $this->db->update('bank_loan',$update);
                 	       
				return 1;
			}
			else if($amount > $result->emi_amount){
				$remain_amount['remain_amount'] = $amount - $result->emi_amount;
				$sub = $remain_amount['remain_amount']/$emis->paid;
				$data1['paid_emi']= $amount;
                 		//echo "<script>
				$data1['paid']= 1;
					$data1['paid_date'] = Date('Y-m-d');
				$this->db->where($array);
					$this->db->order_by('date','asc');
				$this->db->limit(1);
				$response = $this->db->update('bank_emi',$data1);
				$this->db->select('bank_emi.emi_amount,bank_emi.tbl_id');
                		$this->db->from('bank_emi');
                 		$array2 = ['member_id'=>$account,'loan_id'=>$loan_id,'paid'=>0];
                	 	$this->db->where($array2);
                	 	$query = $this->db->get();
                	 	$emis1 = $query->result();
                 	        $update['total_loan_amount_with_interest']  = $total_loan_amount_with_interest->total_loan_amount_with_interest - $amount;
                 	        $array5 = ['member_id'=>$account,'loan_id'=>$loan_id];
                 	        $this->db->where($array5);
                 	       $this->db->update('bank_loan',$update);
                 		foreach($emis1 as $emi){
                 			$data3['emi_amount'] = $emi->emi_amount-$sub;
                 			
                 			$this->db->where('tbl_id',$emi->tbl_id);
                 			$this->db->update('bank_emi',$data3);
                 		}
                 	
				return 1;
			}else if($amount < $result->emi_amount){
		$data1['paid_emi']= $amount;
			$data1['paid']= 1;
			$data1['paid_date'] = Date('Y-m-d');
			$this->db->where($array);
			$this->db->order_by('date','asc');
			$this->db->limit(1);
			$this->db->update('bank_emi',$data1);
			$remain_amount = $result->emi_amount - $amount;
			$this->db->select('bank_emi.emi_amount');
                	$this->db->from('bank_emi');
                 	$array2 = ['member_id'=>$account,'loan_id'=>$loan_id,'paid'=>0];
                 	$this->db->where($array2);
                 	$query = $this->db->get();
                 	$result1 = $query->row();
                 	$update['total_loan_amount_with_interest']  = $total_loan_amount_with_interest->total_loan_amount_with_interest - $amount;
                 	        $array5 = ['member_id'=>$account,'loan_id'=>$loan_id];
                 	        $this->db->where($array5);
                 	       $this->db->update('bank_loan',$update);
			$extra_charge['emi_amount'] = $remain_amount+$result1->emi_amount;
			$this->db->where($array);
			$this->db->order_by('date','asc');
			$this->db->limit(1);
			$this->db->update('bank_emi',$extra_charge);
			return 1;
		}
		else{
		$data1['paid_emi']= $amount;
			$data1['paid']= 1;
			$data1['paid_date'] = Date('Y-m-d');
			$this->db->where($array);
			$this->db->order_by('date','asc');
			$this->db->limit(1);
			$this->db->update('bank_emi',$data1);
			$update['total_loan_amount_with_interest']  = $total_loan_amount_with_interest->total_loan_amount_with_interest - $amount;
                 	        $array5 = ['member_id'=>$account,'loan_id'=>$loan_id];
                 	        $this->db->where($array5);
                 	        $this->db->update('bank_loan',$update);
                 	        return 1;
		}
			// if(!empty($result)){
			// $sub = $result->extra_amount + $amount;
			// $data['extra_amount'] =$sub - $result->emi_amount; 
			// $array1 = ['member_id'=>$account,'loan_id'=>$loan_id,'paid'=>0];
			// $this->db->where($array1);
			// $this->db->order_by('date','asc');
			// $this->db->limit(1);
			// $this->db->update('bank_emi',$data);
             return 1;
		}
                else{
                    return 0;
                    
                }
		}
	}


	//get transaction information 
	public function getTransaction($limit='',$type='')
	{

		$this->db->select('transaction.*,member_details.member_name');
		$this->db->from('transaction');
		$this->db->join('member_details','member_details.member_id=transaction.member_id','inner');

		if($type!=''){
			$this->db->where('type',$type);	
		}
		$this->db->order_by("trans_id", "desc");
		if($limit!='all'){ 
			$this->db->limit($limit);
		}    

		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;

	} 


	//get single transaction
	public function getSingleTransaction($trans_id){
		$this->db->select('transaction.*,member_details.member_name');
		$this->db->from('transaction');
		$this->db->where('trans_id',$trans_id);
		$this->db->join('member_details','transaction.member_id=member_details.member_id','inner');
		$query_result=$this->db->get();
		$result=$query_result->row();
		return $result;

	}


	//get repeat transaction 
	public function getRepeatTransaction($type,$status,$status2='')
	{

		$this->db->select('*');
		$this->db->from('repeat_transaction');
		$this->db->where('type',$type);
		$this->db->where("user_id",$this->session->userdata('user_id')); 
		if($status2!=''){
			$this->db->where_in('status',array($status,$status2));	
		}else{
			$this->db->where('status',$status);
		}
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;

	} 

	//get single repeat transaction
	public function getSingleRepeatTransaction($trans_id){
		$this->db->select('*');
		$this->db->from('repeat_transaction');
		$this->db->where('trans_id',$trans_id);
		$query_result=$this->db->get();
		$result=$query_result->row();
		return $result;

	}

	//Process Repeating Transaction
	public function processRepeatTransaction($trans_id,$status)
	{

		$data['status']=$status;	
		$data['pdate']=date("Y-m-d");

		$this->db->trans_begin();
		$this->db->where('trans_id',$trans_id);
		$this->db->update('repeat_transaction',$data);

		$trans=$this->getSingleRepeatTransaction($trans_id);
		if($trans->type=="Income"){
			//insert Income
			$this->insertIncome($trans->account,$trans->category,$trans->amount,$trans->payer,$trans->p_method,$trans->ref,$trans->description);

		}else if($trans->type=="Expense"){
			//insert Expense
			$this->insertExpense($trans->account,$trans->category,$trans->amount,$trans->payee,$trans->p_method,$trans->ref,$trans->description);
		}

		//end transaction
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}


	}


	public function insertIncome($account,$cat,$amount,$payer,$p_method,$ref,$note)
	{
		$data=array();	
		$data['accounts_name']=$account; 
		$data['trans_date']=date("Y-m-d");; 
		$data['type']='Income'; 
		$data['category']=$cat; 
		$data['amount']=$amount; 
		$data['payer']=$payer; 
		$data['payee']=''; 
		$data['p_method']=$p_method; 
		$data['ref']=$ref; 
		$data['note']=$note;  
		$data['dr']=0;  
		$data['cr']=$amount;
		$data['bal']=$this->getBalance($account,$amount,"add");
		$data['user_id']=$this->session->userdata('user_id');  
		$this->db->insert('transaction',$data);	
	}

	public function insertExpense($account,$cat,$amount,$payee,$p_method,$ref,$note)
	{
		$data=array();	
		$data['accounts_name']=$account; 
		$data['trans_date']=date("Y-m-d");; 
		$data['type']='Expense'; 
		$data['category']=$cat; 
		$data['amount']=$amount; 
		$data['payer']=''; 
		$data['payee']=$payee; 
		$data['p_method']=$p_method; 
		$data['ref']=$ref; 
		$data['note']=$note;  
		$data['dr']=$amount;  
		$data['cr']=0;
		$data['bal']=$this->getBalance($account,$amount,"sub");  
		$data['user_id']=$this->session->userdata('user_id');
		$this->db->insert('transaction',$data);	
	}


	public function get_balance($member_id)
	{
		$this->db->select('a.account_balance,b.member_name');
		$this->db->from('bank_accounts a,member_details b');
		$array = array('a.member_id'=>$member_id,'b.member_id'=>$member_id);
		$this->db->where($array);
		$query = $this->db->get();
		$result=$query->row();
		return $result;
	}

	public function get_loan($member_id,$user_id){
		$query = $this->db->query("SELECT amount,date,(SELECT DISTINCT(loan_id) from bank_emi where paid=0 AND member_id=".$member_id.")as loan_id from loan_transaction where loan_id IN (SELECT loan_id FROM bank_loan WHERE member_id = ".$member_id.") ORDER by transaction_id DESC limit 1");
		$result=$query->row();
		$query = $this->db->query("SELECT loan_id,total_loan_amount_with_interest from bank_loan where member_id = ".$member_id ." ORDER by loan_id DESC limit 1");
		if($result==NULL){
			$result=$query->row();}

		return $result;
	}
	public function get_fd(){
		$this->db->select('*');
		$this->db->from('fixed_deposit');
		$query_result=$this->db->get();
		$result=$query_result->row();
		return $result;
	}
	public function getMember($member_id){
		$this->db->select('*');
		$this->db->from('member_details');
		$this->db->where('member_id',$member_id);
		$query_result=$this->db->get();
		$result=$query_result->row();
		return $result;
	}
	public function get_duration(){
		$this->db->select('*');
		$this->db->from('fixed_deposit');   
		$query_result=$this->db->get();
		$result=$query_result->result_array();
		return $result;
	} 
	public function get_loan_interest(){
		$this->db->select('*');
		$this->db->from('loan_setup');   
		$query_result=$this->db->get();
		$result=$query_result->result_array();
		return $result;
	} 
	public function get_fixed_d(){
		$this->db->select('*');
		$this->db->from('fixed_deposit');   
		$query_result=$this->db->get();
		$result=$query_result->result_array();
		return $result;
	} 

	public function get_general_detail($module_id = '', $name = ''){
		$this->db->select('*');
		$this->db->from('general_detail');

		if(!empty($module_id)){
			$this->db->where('module_id', $module_id);
		}

		if(!empty($name)){
			$this->db->where('name', $name);
		}

		$query = $this->db->get();
		$val = $query->result_array();

		// If name is not empty then send single value
		if(!empty($name)){
			$val = $val[0]['value'];
		}

		return $val;
	}

	public function get_sequence($sequence_id){
		$this->db->select('*');
		$this->db->from('sequence');
		$this->db->where('sequence_id', $sequence_id);

		$query = $this->db->get();
		$val = $query->result_array();
		$val = $val[0]['value'];


		$this->db->set('value', 'value+1', FALSE);
		$this->db->where('sequence_id', $sequence_id);
		$this->db->update('sequence');
		
		return $val;
	}


	public function get_interest_detail($mod_id=null, $identifier=null){
                $this->db->select('interest_management.id as id, interest_management.name as name, interest_management.interest as interest, interest_management.description as description, bank_account_types.account_name as account_name, bank_account_types.status as status, bank_account_types.html_id as html_id');
                $this->db->from('interest_management');
		$this->db->join('bank_account_types', 'bank_account_types.tbl_id=interest_management.account_type_id');
		
		if(!empty($mod_id)){
			$this->db->where('account_type_id', $mod_id);
		}

		if(!empty($identifier)){
                        $this->db->where('identifier_note', $identifier);
                }
		
                $query_result=$this->db->get();
                $result=$query_result->result_array();
                return $result;
        }

	public function get_loan_setup(){
		$this->db->select('*');
		$this->db->from('loan_setup');   
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	} 
	public function getAllAccountDetails($mobile='', $name='', $status=1){
		$this->db->select('*');
		$this->db->from('member_details');  

		if(!empty($name)){
                        $this->db->like('member_name', $name);
                }

                if(!empty($mobile)){
                        $this->db->like('mobile_no', $mobile);
                }

		$this->db->where('status', $status);	

		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	}

	public function get_introducer($member_id){
		$this->db->select('member_details.member_name,bank_share.share_amount,bank_accounts.account_balance');
		$this->db->from('bank_share');
		$this->db->where('member_details.member_id',$member_id);
		$this->db->join('member_details','bank_share.member_id = member_details.member_id','join');
		$this->db->join('bank_accounts',' bank_share.member_id = bank_accounts.member_id','join');
		$this->db->order_by('member_details.member_id','desc');
		$this->db->limit('1');
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	} 

	public function getAllAccountCurrentSaving(){
		$this->db->select('*');
		$this->db->from('bank_accounts');
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	} 
	public function getFd($fd_id){
		$this->db->select('*');
		$this->db->from('fixed_deposit');  
		$this->db->where('fd_id',$fd_id);
		$query_result=$this->db->get();
		$result=$query_result->row();
		return $result;
	} 

	public function get_share($member_id,$amount='',$action=''){
		if($action==''){
		$this->db->select('member_details.member_name,bank_share.*');
		$this->db->from('bank_share');
		$this->db->join('member_details','bank_share.member_id = member_details.member_id','inner');
		$this->db->where('bank_share.member_id',$member_id);
		$this->db->order_by('bank_share.share_amount','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		$result=$query->row();
		return $result;
			}
		if($action=='add'){
				$query = $this->db->query("SELECT bank_share.share_amount from bank_share where  bank_share.member_id = ".$member_id." ORDER by bank_share.share_amount DESC limit 1") ;
				$this->db->select('bank_share.share_amount');
				$this->db->from('bank_share');
				$this->db->where('bank_share.member_id',$member_id);
				$this->db->order_by('bank_share.share_amount','desc');
				$this->db->limit(1);
				$query = $this->db->get();
				$result = $query->row();
				$data['share_amount'] = $result->share_amount+$amount;
				$this->db->where('member_id',$member_id);
				$this->db->update('bank_share', $data);
			 	return $data['share_amount'];
		}
			else{

			}

	} 
	public function get_account_types(){
		$this->db->select('*');
		$this->db->from('bank_account_types');  
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	} 
	public function get_identity(){
		$this->db->select('*');
		$this->db->from('photo_identity_types');
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	}

	public function get_customer_services($customer_id){

		$this->db->select('*');
		$this->db->from('service_management');
		$this->db->where('	member_id', $customer_id);
		$this->db->order_by('tbl_id','desc');
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	}

	public function get_service_by_id($id){
		$this->db->select('*');
		$this->db->from('customer_services');
		$this->db->where('tbl_id',$id);
		$query_result=$this->db->get();
		$result=$query_result->row();
		return $result;
	}
	public function get_item(){
		$this->db->select('*,0 as checked');
		$this->db->from('bank_items');
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	}
	public function get_customer_items($customer_id){

		$this->db->select('*');
		$this->db->from('item_management');
		$this->db->where('member_id', $customer_id);
		$this->db->order_by('tbl_id','desc');
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	}
	public function get_user_fd($member_id)
	{
		$this->db->select('bank_fixed_deposit.*,member_details.member_name');
		$this->db->from('bank_fixed_deposit');
		$this->db->join('member_details','bank_fixed_deposit.member_id=member_details.member_id','inner');
		$array = ['taken'=>0,'bank_fixed_deposit.member_id'=>$member_id];
                $this->db->where($array);
		$query_result=$this->db->get();
		$result=$query_result->row();
		return $result;
	}
	public function get_late_fees()
	{
		$this->db->select('*');
		$this->db->from('late_fees');
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	}
	public function get_late_fees1($member_id){
	$today = Date('Y-m-d');
	$data = array();
	$this->db->select('*');
$this->db->from('late_fees');
$query = $this->db->get();
$result2 = $query->row();	
$today = Date('Y-m-d');
$result = $this->db->query("SELECT member_details.member_name,member_details.member_id,bank_emi.date from member_details INNER JOIN bank_emi on member_details.member_id = bank_emi.member_id where bank_emi.date IN (SELECT date from bank_emi where date < '".$today."') AND bank_emi.member_id =".$member_id." AND paid =0")->row();
if($result){
$diff = date_diff(date_create($result->date),date_create(Date('Y-m-d')));
$amount = $diff->format("%a")*10;
     		$this->db->select('account_balance');
     		$this->db->from('bank_accounts');
     		$this->db->where('member_id',$member_id);
     		$query1 = $this->db->get();
			$result1 = $query1->row();
			$data['account_balance'] = $result1->account_balance - $amount;
			$this->db->where('member_id',$member_id);
			$response = $this->db->update('bank_accounts',$data);
			
				return $result;
			}
    



}
public function get_user_late_fee($customer_id){
		$today = Date('Y-m-d');
		$result = $this->db->query("SELECT member_details.member_name,member_details.member_id,bank_emi.date,bank_emi.emi_amount,(SELECT amount from late_fees) as late_fees from member_details INNER JOIN bank_emi on member_details.member_id = bank_emi.member_id where bank_emi.date IN (SELECT date from bank_emi where date < '".$today."') AND bank_emi.member_id =".$customer_id." AND bank_emi.paid = 0")->result();
		return $result;
	}
	public function loan_reminder(){
		$tommorow = strtotime('+1 days',strtotime(Date('Y-m-d')));
		 $tommorow = Date('Y-m-d',$tommorow);
		$result = $this->db->query("SELECT a.member_name from member_details a where a.member_id IN (SELECT b.member_id FROM `bank_emi` `b` WHERE `b`.`date` = '".$tommorow."')")->result();
		return $result;
	}
        public function get_user_last_emi($customer_id){
            $today = Date('Y-m-d');
	$result = $this->db->query("SELECT (SElECT COUNT(bank_emi.tbl_id)as emi_left from bank_emi where paid=0) as emi_left,(SELECT bank_emi.emi_amount FROM bank_emi WHERE bank_emi.member_id = '".$customer_id."' AND bank_emi.paid =0 ORDER BY date ASC LIMIT 1) as emi_amount,(SELECT total_loan_amount_with_interest from bank_loan where member_id=".$customer_id." And total_loan_amount_with_interest >0) as total_loan_amount_with_interest,(SELECT bank_emi.date FROM bank_emi WHERE bank_emi.member_id = '".$customer_id."' AND bank_emi.paid =0 ORDER BY date ASC LIMIT 1) as date")->result();
        return $result;
	}
	public function getBalance_remain($member_id='',$amount='',$loan_id=''){
		if($loan_id!=''){
			$this->db->select('a.total_loan_amount_with_interest,b.account_balance');
		$this->db->from('bank_loan a,bank_accounts b');
		$array = ['a.member_id'=>$member_id,'a.loan_id'=>$loan_id];
		$this->db->where($array);
		$query_result=$this->db->get();
		$result=$query_result->row();
		if($result->total_loan_amount_with_interest+1 <= $amount || $result->account_balance <$amount){
			return false;
		}
		else{
			return true;
		}

	}
	else{
		$this->db->select('account_balance');
		$this->db->from('bank_accounts');
		$this->db->where('member_id',$member_id);
		$query_result=$this->db->get();
		$result=$query_result->row();
		if($result->account_balance <$amount){
			return false;
		}
		else{
			return true;
		}

	}
}
public function get_current_emi($customer_id,$loan_id=''){
		$result = $this->db->query("SELECT bank_emi.date, bank_emi.emi_amount FROM bank_emi WHERE bank_emi.member_id = '".$customer_id."' AND bank_emi.paid =0 ORDER BY date ASC LIMIT 1")->result();
		
		return $result;
	}
	public function get_emi($customer_id,$loan_id='',$amount){
		$result = $this->db->query("SELECT SUM(bank_emi.emi_amount)as emi_amount from bank_emi where member_id=".$customer_id." AND loan_id=".$loan_id." AND paid = 0")->row();
		if($result->emi_amount >=$amount ){
                    
			return true;
		}
		else{
			return false;
		}
	}
        public function get_account_status($member_id){
	$this->db->select('status');
        $this->db->from('bank_accounts');
        $this->db->where('member_id',$member_id);
        $query_result=$this->db->get();
		$result=$query_result->result();
                return $result;
	}
	public function select_fixed_deposit($member_id,$fd_id){
	$this->db->select('COUNT(date)as N');
        $this->db->from('user_fixed_deposits');
        $array = ['member_id',$member_id,'date >'=>Date('Y-m-d'),'fd_id'=>$fd_id];
        $this->db->where($array);
        $query_result=$this->db->get();
		$result=$query_result->result();
                return $result;
	}

	public function get_account_count($member_id, $account_type){
		$this->db->select('count(*) as count_val');
                $this->db->from('bank_accounts');
                $this->db->where(array('member_id'=>$member_id, 'bank_account_type'=>$account_type));

                $query_result=$this->db->get();
		$result=$query_result->row();
		return $result->count_val;
	}


	public function fetch_account_detail($account_number=null, $account_type_id=null, $status=null){
		$this->db->select('*');
                $this->db->from('bank_accounts');

		if(!empty($account_number)){
			$this->db->where('bank_account_number', $account_number);
		}

		if(!empty($account_type_id)){
			$this->db->where('bank_account_id', $account_type_id);
		}

		if(!empty($status)){
                        $this->db->where('status', $status);
                }
	

                $query_result=$this->db->get();
                $result=$query_result->result_array();

		if(!empty($result))
                	return $result[0];
		return null;
	}

	public function fetch_account_view_detail($account_number=null, $account_type_id=null, $status=null, $member_id=null, $account_number_like=null, $member_name_like=null){
                $this->db->select('*');
                $this->db->from('bank_accounts');

                if(!empty($account_number)){
                        $this->db->where('bank_accounts.bank_account_number', $account_number);
                }

                if(!empty($account_type_id)){
                        $this->db->where('bank_accounts.bank_account_id', $account_type_id);
                }

                if(!empty($status) || $status == '0'){
                        $this->db->where('bank_accounts.status', $status);
                }

		if(!empty($account_number_like) || $account_number_like==='0'){
                        $this->db->like('bank_accounts.bank_account_number', $account_number_like);
                }

		if(!empty($member_name_like) || $member_name_like==='0'){
                        $this->db->like('member_details.member_name', $member_name_like);
                }

		$this->db->join('bank_account_types', 'bank_account_types.tbl_id = bank_accounts.bank_account_id');
		$this->db->join('bank_member_account', 'bank_member_account.account_id = bank_accounts.id');
		$this->db->join('member_details', 'bank_member_account.member_id = member_details.member_id');
		$this->db->order_by("bank_accounts.bank_account_number", "asc");

		if($member_id !=null){
                        $this->db->where('member_details.member_id', $member_id);
                }


                $query_result=$this->db->get();
                $result=$query_result->result_array();

                if(!empty($result))
                        return $result;
                return null;
        }

	public function fetch_member_detail($member_id = null, $status=null){
                $this->db->select('*');
                $this->db->from('member_details');

		if(!empty($member_id)){
                	$this->db->where('member_id', $member_id);
		}

                if(!empty($status)){
                        $this->db->where('status', $status);
                }


                $query_result=$this->db->get();
                $result=$query_result->result_array();

                if(!empty($result))
                        return $result;
                return null;
        }

	public function fetch_account_type_id($account_type){
                $this->db->select('tbl_id');
                $this->db->from('bank_account_types');
                $this->db->where('html_id', $account_type);

                $query_result=$this->db->get();
                $result=$query_result->row();
		if(empty($result)){
			return null;
		}
                return $result->tbl_id;
        }

	public function fetch_account_type_detail($account_id=null, $account_type=null){
                $this->db->select('*');
                $this->db->from('bank_account_types');
		
		if(!empty($account_type)){
                	$this->db->where('html_id', $account_type);
		}

		if(!empty($account_id)){
			$this->db->where('tbl_id', $account_id);
		}

                $query_result=$this->db->get();
                $result=$query_result->result_array();
                if(empty($result)){
                        return null;
                }
                return $result;
        }

	

	public function is_linked_account($member_id, $account_number, $account_type=null){
		$account_type_id = null;

		if(!empty($account_type)){
			$account_type_id = $this->fetch_account_type_id($account_type);
			if(empty($account_type_id)){
                        	return false;
                	}
		}


		$account_detail = $this->fetch_account_detail($account_number, $account_type_id);
		
		if(!empty($account_detail)){
			$this->db->select('count(*) as count_val');
			$this->db->from('bank_member_account');
			$this->db->where('member_id', $member_id);
			$this->db->where('account_id', $account_detail['id']);

			$query_result=$this->db->get();
			$result=$query_result->row();

			if($result->count_val>0){
				return true;
			}	
		}

		return false;
        }

	public function get_account_member_detail($accnt_no = null, $status = null, $account_type_id = null, $account_type_short_code = null){
		$this->db->select('*');
		$this->db->from('bank_accounts');
		$this->db->join('bank_member_account', 'bank_accounts.id = bank_member_account.account_id');
		$this->db->join('member_details', 'member_details.member_id = bank_member_account.member_id');

		if($accnt_no != null){
			$this->db->where('bank_account_number', $accnt_no);
		}

		if($status != null){
			$this->db->where('bank_accounts.status', $status);
		}

		if($account_type_id != null){
			$this->db->where('bank_account_id', $account_type_id);
                }


		if(!empty($account_type_short_code)){
			switch($account_type_short_code){
				case "saving":
					$this->db->join('bank_account_saving', 'bank_account_saving.account_id = bank_accounts.id');
					break;
				case "current":
					$this->db->join('bank_account_current', 'bank_account_current.account_id = bank_accounts.id');
					break;
				case "loan":
					$this->db->join('bank_account_loan', 'bank_account_loan.account_id = bank_accounts.id');
					break;
				case "fd":
					$this->db->join('bank_account_fd', 'bank_account_fd.account_id = bank_accounts.id');	
                                        break;
				case "rd":
					$this->db->join('bank_account_rd', 'bank_account_rd.account_id = bank_accounts.id');
                                        break;
				default:

			}
		}


		$query_result=$this->db->get();
                $result=$query_result->result_array();
		return $result;
	}

	public function revoke_share($member_id){
		$allowed_balance = $this->get_general_detail('share_management', 'minimum_balance'); 	
		
		$this->db->select('count(*) as count_val');
		$this->db->from('bank_account_saving');
		$this->db->join('bank_member_account', 'bank_member_account.account_id=bank_account_saving.account_id');
		$this->db->where('balance >= '.$allowed_balance);	
		$this->db->where('member_id', $member_id);
		
		
		$valid_account_count = $this->db->get()->row()->count_val;

		
		if($valid_account_count < 1){
			$member_detail = $this->fetch_member_detail($member_id)[0];
			$member_share = $member_detail['share'];
			$this->db->trans_begin();
				$this->db->set('share', 0, FALSE);
				$this->db->where('member_id', $member_id);
				$this->db->update('member_details');
				$this->increase_bank_share($member_share);
			$this->db->trans_complete();
		}
	}	

	public function increase_bank_share($share){
		$this->db->set('value', 'value+'.$share, FALSE);
                $this->db->where('module_id', 'share_management');
		$this->db->where('name', 'total_share');
                $this->db->update('general_detail');
	}

	public function decrease_bank_share($share = 1){
		$current_share = $this->get_general_detail('share_management', 'minimum_balance');
		
		if($current_share-$share < 0){
			return get_phrase("not_enough_share");
		}
                $this->db->set('value', 'value-'.$share, FALSE);
                $this->db->where('module_id', 'share_management');
                $this->db->where('name', 'total_share');
                $this->db->update('general_detail');
		return "success";
        }

	public function change_member_share($member_id, $new_share){
		$this->db->set('share', $new_share, FALSE);
                $this->db->where('member_id', $member_id);
                $this->db->update('member_details');
	}	

	public function change_account_balance($account_id, $new_amount, $table_name){
                $this->db->set('balance', $new_amount, FALSE);
                $this->db->where('account_id', $account_id);
                $this->db->update($table_name);
        }

	public function updateMemberShare($member_id, $old_share, $new_share){

		if($old_share ==  $new_share){
			return get_phrase("new_share_is_same_as_old");
		}	
		if($new_share < 0){
			return get_phrase("invalid_new_share");
		}
		$current_share = $this->get_general_detail('share_management', 'total_share');	

		if($current_share+$old_share-$new_share < 0){
			return "Insufficient share";
		}

		$this->db->trans_begin();
		$this->change_member_share($member_id, $new_share);
		$this->increase_bank_share($old_share-$new_share);
	
		if ($this->db->trans_status() === FALSE)
                {
                        $this->db->trans_rollback();
			return get_phrase('database_error', true);
                }
                else
                {
                        $this->db->trans_commit();
                }	

		$add_remove = null;

		if($old_share>$new_share){
			$add_remove = REMOVE_SHARE;
		}else{
			$add_remove = ADD_SHARE;
		}
		$this->logShareTransaction(TRANSACTION_MODE_TRANSFER, $add_remove, $member_id, null, abs($old_share-$new_share));
		

		return "success";
	}

	public function logShareTransaction($transaction_remarks, $add_remove, $from_member_id,$to_member_id, $share){
		$user_id = $this->session->userdata('user_id');
		$reference_id = $this->Adminmodel->get_general_detail('accnt_gen', 'credit_reference') . $this->Adminmodel->get_sequence('credit_reference');
		
		$data['user_id'] = $user_id;
		$data['reference_id'] = $reference_id;
		$data['transaction_remarks'] = $transaction_remarks;
		$data['add_remove'] = $add_remove;
		$data['from_member_id'] = $from_member_id;
		$data['to_member_id'] = $to_member_id;
		$data['share'] = $share;
		$data['transaction_time'] = Date('Y-m-d');

		$this->db->insert('share_transaction_detail', $data);

		return $reference_id;

	}

	public function updateFundTrasaction($reference_id, $column_name, $new_value){
		$this->db->set($column_name, $new_value);
		$this->db->where('reference_id', $reference_id);
		$this->db->update('bank_transaction_detail');
		
	}

	public function logFundTrasaction($account_number, $member_id, $account_id, $account_type_short_code, $account_type_id, $credit_debit, $amount, $late_fee, $account_balance_before, $account_balance_after, $transaction_remarks, $linked_reference_id, $payment_mode, $payment_mode_no, $bank_ifsc, $bank_name, $bank_branch){
		$user_id = $this->session->userdata('user_id');

		
                $reference_id = $this->Adminmodel->get_general_detail('accnt_gen', 'transfer_reference') . $this->Adminmodel->get_sequence('transfer_reference');

                $data['user_id'] = $user_id;
                $data['reference_id'] = $reference_id;
                $data['account_number'] = $account_number;
                $data['member_id'] = $member_id;
                $data['account_id'] = $account_id;
		$data['account_type_id'] = $account_type_id;
		$data['credit_debit'] = $credit_debit;
		$data['amount'] = $amount;
		$data['late_fee'] = $late_fee;
		$data['account_balance_before'] = $account_balance_before;
		$data['account_balance_after'] = $account_balance_after;
		$data['transaction_remarks'] = $transaction_remarks;
		$data['linked_reference_id'] = $linked_reference_id;
		$data['account_type_short_code'] = $account_type_short_code;
		
		$data['day'] = date("d");
                $data['month'] = date("m");
                $data['year'] = date("Y");
                $data['transaction_time'] = Date('Y-m-d H:i:s');

		$payment_data['payment_mode'] = $payment_mode;
		$payment_data['reference_id'] = $reference_id;
		$payment_data['payment_mode_no'] = $payment_mode_no;
                $payment_data['bank_ifsc'] = $bank_ifsc;
                $payment_data['bank_name'] = $bank_name;
                $payment_data['bank_branch'] = $bank_branch;

		/**echo $this->db->set($data)->get_compiled_insert('bank_transaction_detail');
		echo $this->db->set($payment_data)->get_compiled_insert('bank_transaction_payment_mode_detail');
		die();**/

                $this->db->insert('bank_transaction_detail', $data);
		$this->db->insert('bank_transaction_payment_mode_detail', $payment_data);
                return $reference_id;
	}

	public function get_user($id){

                $this->db->select('*');
                $this->db->from('member_details');
                $this->db->where("member_id",$id);
                $query_result=$this->db->get();
                $result=$query_result->row();
                return $result;
        }

	public function transferShare($from_member_id, $to_member_id, $share, $from_member_share=null, $to_member_share=null, $transaction_remarks=null){

                if($share < 0){
                        return get_phrase("invalid_share");
                }

                if($from_member_share < $share){
                        return "Insufficient share";
                }

		if($from_member_share==null){
			$from_member_share = $this->get_user($from_member_id)['share'];	
		}

		if($to_member_share==null){
                        $to_member_share = $this->get_user($to_member_id)['share']; 
                }

                $this->db->trans_begin();
                $this->change_member_share($from_member_id, $from_member_share-$share);
		$this->change_member_share($to_member_id, $to_member_share+$share);

                if ($this->db->trans_status() === FALSE)
                {
                        $this->db->trans_rollback();
                        return get_phrase('database_error', true);
                }
                else
                {
                        $this->db->trans_commit();
                }

		$this->logShareTransaction($transaction_remarks, TRANSFER_SHARE, $from_member_id, $to_member_id, $share);


                return "success";
        }


	public function transferFund($from_account_number, $from_member_id, $to_member_id, $to_account_number, $transfer_amount, $transaction_remarks, $from_account_balance, $to_account_balance, $from_account_id, $to_account_id, $from_account_type_short_code, $to_account_type_short_code, $from_account_type_id, $to_account_type_id){

                if($transfer_amount < 1){
                        return get_phrase("invalid_transfer_amount");
                }

                if($from_account_balance < $transfer_amount){
                        return "Insufficient fund";
                }

		$from_table_name=null;
		$to_table_name=null;

		switch($from_account_type_short_code){
			case SAVING_SHORT_CODE:
				$from_table_name = 'bank_account_saving';
				break;
			case CURRENT_SHORT_CODE:
                                $from_table_name = 'bank_account_current';
                                break;
			default:
				return get_phrase("account_type_not_allowed");

		}

		switch($to_account_type_short_code){
                        case SAVING_SHORT_CODE:
                                $to_table_name = 'bank_account_saving';
                                break;
                        case CURRENT_SHORT_CODE:
                                $to_table_name = 'bank_account_current';
                                break;
                        default:
                                return get_phrase("account_type_not_allowed");

                }

                $this->db->trans_begin();
			$this->change_account_balance($from_account_id, $from_account_balance-$transfer_amount, $from_table_name);
			$this->change_account_balance($to_account_id, $to_account_balance+$transfer_amount, $to_table_name);
		$from_reference_id = $this->logFundTrasaction($from_account_number, $from_member_id, $from_account_id, $from_account_type_short_code, $from_account_type_id, DEBIT, $transfer_amount, null, $from_account_balance, $from_account_balance-$transfer_amount, $transaction_remarks, null, TRANSACTION_MODE_TRANSFER, null, null, null, null);
                $to_reference_id = $this->logFundTrasaction($to_account_number, $to_member_id, $to_account_id, $to_account_type_short_code, $to_account_type_id, CREDIT, $transfer_amount, null, $to_account_balance, $to_account_balance+$transfer_amount, $transaction_remarks, $from_reference_id, TRANSACTION_MODE_TRANSFER, null, null, null, null);

                $this->updateFundTrasaction($from_reference_id, 'linked_reference_id', $to_reference_id);

                if ($this->db->trans_status() === FALSE)
                {
                        $this->db->trans_rollback();
                        return get_phrase('database_error', true);
                }
                else
                {
                        $this->db->trans_commit();
                }


                return "success";
        }

	public function getFdAccountDetail($accnt_no, $status=null){
		$this->db->select('*');
		$this->db->from('bank_accounts');
		$this->db->join('bank_account_types', 'bank_accounts.bank_account_id = bank_account_types.tbl_id');
		$this->db->join('bank_account_fd', 'bank_account_fd.account_id = bank_accounts.id');
		$this->db->join('bank_member_account', 'bank_member_account.account_id = bank_accounts.id');
		$this->db->join('member_details', 'bank_member_account.member_id = member_details.member_id');
		$this->db->where('bank_accounts.bank_account_number', $accnt_no);



		

		$result = $this->db->get();

		$return = $result->result_array();

		if(empty($return)){
			return null;
		}else{
			return $return[0];
		}
	}

	public function get_services($status=null, $get_array = null){

                $this->db->select('*');
                $this->db->from('bank_service_setup');

		if($status!=null){
			$this->db->where('status', $status);
		}		
                $this->db->order_by('id','desc');
		

                $query_result=$this->db->get();
		
		if($get_array!=null){
			$result=$query_result->result_array();
		}else{
                	$result=$query_result->result();
                }
		return $result;
        }

	public function getRemainingServiceCharge($accountId=null){

                $this->db->select('*');
                $this->db->from('bank_account_service_charge_summary');

                if($accountId!=null){
                        $this->db->where('account_id', $accountId);
                }


                $query_result=$this->db->get();
                $result=$query_result->result_array();

		
		if(empty($result))
                	return $result;
		else
			return $result[0];
        }

	public function getAccountService($account_id=null, $service_id=null, $status=null){
		$this->db->select('*');
                $this->db->from('bank_account_service');

		if($account_id!=null)
		$this->db->where('account_id', $account_id);
	
		if($service_id!=null)
		$this->db->where('service_id', $service_id);
		
		if($status!=null)
		$this->db->where('status', $status);


		$query_result=$this->db->get();
                $result=$query_result->result_array();


                return $result;

	}

	public function getAccountDetail($accountId, $table_name, $status=null, $account_number=null){

		 $this->db->select('*');
                $this->db->from('bank_accounts');
                $this->db->join('bank_account_types', 'bank_accounts.bank_account_id = bank_account_types.tbl_id');
                $this->db->join($table_name, $table_name.'.account_id = bank_accounts.id');
                $this->db->join('bank_member_account', 'bank_member_account.account_id = bank_accounts.id');
                $this->db->join('member_details', 'bank_member_account.member_id = member_details.member_id');

		if($accountId!=null){
               	 	$this->db->where('bank_accounts.id', $accountId);
		}

		if($account_number!=null){
			$this->db->where('bank_accounts.bank_account_number', $account_number);
		}
	
		if($status!=null){
			$this->db->where('bank_accounts.status', $status);
		}




                $result = $this->db->get();



                $return = $result->result_array();
                if(empty($return)){
                        return null;
                }else{
                        return $return[0];
                }

        }

	public function deduct_saving_service($account_id, $charge, $modify_service_summary=null){

                $account_detail = $this->getAccountDetail($account_id, 'bank_account_saving');

		if(empty($account_detail)){
                        return get_phrase("invalid_account_number", true);
                }

                if($account_detail['balance']-$charge < 0){
                        return get_phrase("insufficient_balance", true);
                }


               $this->db->set('balance', $account_detail['balance']-$charge)->where('account_id', $account_id)->update('bank_account_saving');

                $this->logFundTrasaction($account_detail['bank_account_number'], $account_detail['member_id'], $account_detail['account_id'], $account_detail['html_id'], $account_detail['bank_account_id'], DEBIT, $charge, null, $account_detail['balance'], $account_detail['balance']-$charge, SERVICE_CHARGE_REMARKS, null, TRANSACTION_MODE_TRANSFER, null, null, null, null);
        
                if(!empty($modify_service_summary)){

                        $this->db->set('remaining_charge', 'remaining_charge-'.$charge , FALSE)->where('account_id', $data['account_id'])->update('bank_account_service_charge_summary');
                }      
                return "true";
        }

	public function deduct_current_service($account_id, $charge, $modify_service_summary=null){

                $account_detail = $this->getAccountDetail($account_id, 'bank_account_current');

                if(empty($account_detail)){
                        return get_phrase("invalid_account_number", true);
                }

		if($account_detail['balance']-$charge < 0){
                        return get_phrase("insufficient_balance", true);
                }

                $this->db->set('balance', $account_detail['balance']-$charge)->where('account_id', $account_id)->update('bank_account_current');

                $this->logFundTrasaction($account_detail['bank_account_number'], $account_detail['member_id'], $account_detail['account_id'], $account_detail['html_id'], $account_detail['bank_account_id'], DEBIT, $charge, null, $account_detail['balance'], $account_detail['balance']-$charge, SERVICE_CHARGE_REMARKS, null, TRANSACTION_MODE_TRANSFER, null, null, null, null);

                if(!empty($modify_service_summary)){

                        $this->db->set('remaining_charge', 'remaining_charge+'.$charge , FALSE)->where('account_id', $data['account_id'])->update('bank_account_service_charge_summary');
                }
                return "true";
        }

	public function deduct_loan_service($account_id, $charge, $modify_service_summary=null){

		$account_detail = $this->getAccountDetail($account_id, 'bank_account_loan');


                if(empty($account_detail)){
                        return get_phrase("invalid_account_number", true);
                }



                $this->logFundTrasaction($account_detail['bank_account_number'], $account_detail['member_id'], $account_detail['account_id'], $account_detail['html_id'], $account_detail['bank_account_id'], DEBIT, $charge, null, $account_detail['payable_amount'], $account_detail['payable_amount']+$charge, SERVICE_CHARGE_REMARKS, null, TRANSACTION_MODE_TRANSFER, null, null, null, null);

                if(!empty($modify_service_summary)){

                        $this->db->set('remaining_charge', 'remaining_charge+'.$charge , FALSE)->where('account_id', $data['account_id'])->update('bank_account_service_charge_summary');
                }
                return "true";
        }

	 public function deduct_fd_service($account_id, $charge, $modify_service_summary=null){

		$account_detail = $this->getAccountDetail($account_id, 'bank_account_fd');


                if(empty($account_detail)){
                        return get_phrase("invalid_account_number", true);
                }



                $this->logFundTrasaction($account_detail['bank_account_number'], $account_detail['member_id'], $account_detail['account_id'], $account_detail['html_id'], $account_detail['bank_account_id'], DEBIT, $charge, null, $account_detail['maturity_amount'], $account_detail['maturity_amount']-$charge, SERVICE_CHARGE_REMARKS, null, TRANSACTION_MODE_TRANSFER, null, null, null, null);



                if(!empty($modify_service_summary)){

                        $this->db->set('remaining_charge', 'remaining_charge+'.$charge , FALSE)->where('account_id', $data['account_id'])->update('bank_account_service_charge_summary');
                }
                return "true";
        }

	public function fetch_service_charge($account_id){
		return $this->db->select('*')->from('bank_account_service_charge_summary')->where('account_id', $account_id)->get()->result_array();
	}

	public function get_account_service_detail($account_id=null, $account_number=null, $service_id =null, $service_status = null, $account_status=null, $service_name_like = null, $account_number_like=null, $member_name_like=null){
		$this->db->select('*');
		$this->db->from('bank_accounts');
		$this->db->join('bank_member_account', 'bank_member_account.account_id=bank_accounts.id');
		$this->db->join('member_details', 'member_details.member_id=bank_member_account.member_id');
		$this->db->join('bank_account_types', 'bank_account_types.tbl_id=bank_accounts.bank_account_id');
		$this->db->join('bank_account_service', 'bank_account_service.account_id=bank_accounts.id');
		$this->db->join('bank_service_setup', 'bank_account_service.service_id=bank_service_setup.id');

		if(!empty($account_id) || $account_id==='0'){
			$this->db->where('bank_accounts.id', $account_id);
		}

		if(!empty($account_number) || $account_number==='0'){
			$this->db->where('bank_accounts.bank_account_number', $account_number);
		}

		if(!empty($account_status) || $account_status==='0'){
                        $this->db->where('bank_accounts.status', $account_status);
                }

		if(!empty($service_status) || $service_status==='0'){
                        $this->db->where('bank_account_service.status', $service_status);
                }

		$this->db->where('bank_service_setup.status', '1');

		if(!empty($service_id) || $service_id==='0'){
                        $this->db->where('bank_service_setup.id', $service_id);
                }

		if(!empty($service_name_like) || $service_name_like==='0'){
                        $this->db->like('bank_service_setup.name', $service_name_like);
                }

		if(!empty($account_number_like) || $account_number_like==='0'){
                        $this->db->like('bank_accounts.bank_account_number', $account_number_like);
                }

		if(!empty($member_name_like) || $member_name_like==='0'){
                        $this->db->like('member_details.member_name', $member_name_like);
                }

		$this->db->order_by("application_date");


		$result = $this->db->get();

		return $result->result_array();
	}

	public function deactivate_service($accnt_id, $service_id=null){
		$data = array();
                        $data['status'] = 0;
                        $this->db->where('account_id', $accnt_id);
			if($service_id!=null)
                        $this->db->where('service_id', $service_id);
                        $this->db->update('bank_account_service', $data);

	}

	public function generate_loan_installments($account_id, $billing_date, $pay_by_days, $emi, $total_installment){
		$data=array();
                $data['account_id'] = $account_id;	
		$data['emi'] = $emi;
		$data['is_payed'] = 0;
		$var = 0;

		for($i =0 ; $i < $total_installment; $i++){
			$var++;
			$data['billing_date'] = date('Y', strtotime("+".$var." month"))."-".date("m", strtotime("+".$var ." month"))."-".$billing_date;
			$data['due_date'] = date('Y-m-d', strtotime("+".$pay_by_days ." day", strtotime($data['billing_date'])));		

			$this->db->insert('loan_installment_detail', $data);
		}	

		return $data['due_date'];
	}

	public function payLoanInstallment($account_id, $amount_payed){
		$per_day_late_fee = $this->Adminmodel->get_general_detail('accnt_gen', 'default_late_fee'); 
		$today = Date('Y-m-d');
                $this->db->select('*');
                $this->db->from('loan_installment_detail');
                $this->db->where('account_id', $account_id);
                $this->db->where('is_payed', '0');
                $this->db->where('billing_date<=', $today);

                $sql_result = $this->db->get()->result_array();

                foreach($sql_result as $result){

			if($amount_payed<=0){
				break;
			}

			$late_fee = null;
			$update_data = null;
                        if($result['due_date'] < $today){
                                $diff_day = floor(strtotime($today)-strtotime($result['due_date']))/86400;
				$late_fee = $per_day_late_fee*$diff_day;
                        }

			if(!empty($late_Fee)){
				if($amount_payed >= $late_fee){
					$update_data['late_fee'] = $late_fee;	
					$amount_payed-=$late_fee;
				}else{
					$update_data['late_fee'] = $amount_payed;
                                        $amount_payed = 0;		
				}
			}

			$installment_amount = null;
			if(empty($result['payed_amount'])){
				$result['payed_amount'] = 0;	
			}

			if($amount_payed >= $result['emi']){
				$update_data['payed_amount'] += $result['emi'];
				$amount_payed-=$result['emi']; 
				$update_data['is_payed'] = '1';
			}else{
				$update_data['payed_amount'] += $amount_payed;
                                $amount_payed = 0;
				$update_data['is_payed'] = '0';
			}

			$update_data['payment_date'] = Date('Y-m-d');

			$this->db->update('loan_installment_detail', $update_data);

                }

		return "success";
	}

	public function fetch_loan_account_summary($account_id){
		$per_day_late_fee = $this->Adminmodel->get_general_detail('accnt_gen', 'default_late_fee'); 
		$today = Date('Y-m-d');
		$return = array();
		$return['total_late_fee'] = 0;
		$return['total_due_amount'] = 0;
		$return['last_payment_date'] = null;
		$this->db->select('*');
		$this->db->from('loan_installment_detail');
		$this->db->where('account_id', $account_id);
		$this->db->where('is_payed', '0');
		$this->db->where('billing_date<=', $today);

		$sql_result = $this->db->get()->result_array();

		foreach($sql_result as $result){
			if($result['due_date'] < $today){
				$diff_day = floor(strtotime($today)-strtotime($result['due_date']))/86400;

				if($diff_day>0){
					$return['total_late_fee'] += $diff_day*$per_day_late_fee;
					$return['total_due_amount'] += ($diff_day*$per_day_late_fee)+$result['emi'];
				}
			}else{
                                $return['total_due_amount'] += $result['emi'];	
			}

			if(!empty($result['payed_amount'])){
				$return['total_due_amount'] -=$result['payed_amount'];
			}
		}


		$this->db->select('max(payment_date) as payment_date');
                $this->db->from('loan_installment_detail');
                $this->db->where('account_id', $account_id);
                $this->db->where('is_payed', '1');

		$payment_result = $this->db->get()->result_array();


		if(!empty($payment_result)){
			$return['last_payment_date'] = $payment_result[0]['payment_date'];
		}
            
		return $return; 
		
	}

}
