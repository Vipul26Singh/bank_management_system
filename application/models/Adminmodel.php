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
			//get last balance
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
                       
               //          $this->db->select('account_balance');
               //          $this->db->from('bank_accounts');
               //          $this->db->where('member_id',$account);
               //          $query = $this->db->get();
			            // $result1=$query->row();
			            // print_r($data['extra_amount']);die;
               //              $data4['account_balance'] = $result1->account_balance + $data['extra_amount']; 
               //              $this->db->where('member_id',$account);
               //              $this->db->update('bank_accounts',$data4);
               //              return true;
                        
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
                    
                }}
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
	public function get_loan_setup(){
		$this->db->select('*');
		$this->db->from('loan_setup');   
		$query_result=$this->db->get();
		$result=$query_result->result();
		return $result;
	} 
	public function getAllAccountDetails($mobile='', $name=''){
		$this->db->select('*');
		$this->db->from('member_details');  
		$this->db->where('status', 1);

		if(!empty($name)){
                        $this->db->like('member_name', $name);
                }

                if(!empty($mobile)){
                        $this->db->like('mobile_no', $mobile);
                }

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

	public function get_services(){

		$this->db->select('tbl_id, service_name, service_amount, 0 as checked');
		$this->db->from('customer_services');
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
		return 1;
	}
}
