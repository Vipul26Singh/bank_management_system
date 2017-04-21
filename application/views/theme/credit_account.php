<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('transaction') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-danger ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-md-8 col-lg-8 col-sm-8">
<!--Start Panel-->
<div class="alert alert-info"><p>  Transfer fund to the account</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('credit_account') ?></div>
    <div class="panel-body add-client">
 <form id="add-credit">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trans_id" id="trans_id" value=""/>     

 <div class="form-group">
        <label for=""><?php get_phrase('credit_account_type') ?><span style="color:red">  *</span></label>
                <select class="form-control" id='credit_account_type' name='credit_account_type'>
                    <option value=''>Select</option>

			<?php
                                foreach($credit_account_type as $account){


                        ?>
                        <option value='<?php echo json_encode(array("short_code"=>$account["value"], "id"=>$account["external_id"])) ?>'><?php echo $account["name"]?></option>
			<?php
				}
			?>
            </select>
 </div>

 <div class="form-group">
    <label for="account_number"><?php get_phrase('account_number') ?><span style='color:red'>  *</span></label>
   <input type="string" class="form-control"  placeholder="Account Number" name="account_number" id="account_number">
  </div>

  <div class="form-group" hidden>
    <label for="account_number"><?php get_phrase('account_id') ?><span style='color:red'>  *</span></label>
    <input type="text" class="form-control"  name="account_id" id="account_id" readonly="true">
  </div>
 
  <div class="form-group">
    <label for="reference"><?php get_phrase('member_id') ?></label>
    <input type="text" class="form-control" name="member_id" id="member_id" readonly="true">
  </div>
 
  <div class="form-group">
    <label for="reference"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="member_name" id="member_name" readonly="true">
  </div>

  <div class="form-group">
    <label for="reference"><?php get_phrase('member_age') ?></label>
    <input type="text" class="form-control" name="member_age" id="member_age" readonly="true">
  </div>

  <div class="form-group">
    <label for="account_balance"><?php get_phrase('account_balance') ?></label>
    <input type="text" class="form-control" name="account_balance" id="account_balance" readonly="true">
  </div>

 


  <div class="form-group">
        <label for="payment_mode"><?php get_phrase('payment_mode') ?><span style="color:red">  *</span></label>
                <select class="form-control" id='credit_payment_mode' name='credit_payment_mode'>
                    <option value=''>Select</option>

                        <?php
                                foreach($available_payment_mode as $payment_mode){


                        ?>
                        <option value='<?php echo json_encode(array("extra_detail"=>$payment_mode["extra_detail"], "value"=>$payment_mode["value"])) ?>'><?php echo $payment_mode['name']?></option>
                        <?php
                                }
                        ?>
            </select>
 </div>

 <div id="extra_detail_div" hidden>
	<div class="form-group">
		<label for="cheque_no"><?php get_phrase('payment_mode_number') ?><span style='color:red'>  *</span></label></label>
		<input type="text" class="form-control" name="credit_payment_number" id="credit_payment_number" placeholder="Cheque/DD/etc no">
	</div>

	<div class="form-group">
                <label for="bank_ifsc"><?php get_phrase('bank_ifsc') ?><span style='color:red'>  *</span></label></label>
                <input type="text" class="form-control" name="credit_payment_bank_ifsc" id="credit_payment_bank_ifsc" placeholder="Bank ifsc code">
        </div>

	<div class="form-group">
                <label for="bank_name"><?php get_phrase('bank_name') ?></label>
                <input type="text" class="form-control" name="credit_payment_bank_name" id="credit_payment_bank_name" placeholder="Name of the bank">
        </div>

	<div class="form-group">
                <label for="bank_branch"><?php get_phrase('bank_branch') ?></label>
                <input type="text" class="form-control" name="credit_payment_bank_branch" id="credit_payment_bank_branch" placeholder="Branch of the bank">
        </div>	
 </div>

 <div class="form-group">
    <label for="account_balance"><?php get_phrase('credit_amount') ?><span style='color:red'>  *</span></label>
    <input type="number" class="form-control" name="credit_amount" id="credit_amount" placeholder=<?php get_phrase('credit_amount') ?>>
  </div>
 

  <div class="form-group">
    <label for="note"><?php get_phrase('transaction_remarks') ?><span style='color:red'>  *</span></label>
    <input type="text" class="form-control" name="transaction_remarks" id="transaction_remarks" placeholder="Remarks">
  </div>

   <div class="form-group">
      <label for="active_by"><?php get_phrase('user') ?></label>
    <select name="active_by" class="form-control" id="active_by">
      <option value="<?php echo $this->session->userdata('user_id')?>" selected="selected"><?php echo $this->session->userdata('username')?></option>
    </select>
  </div>
       
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('submit') ?></button>
</form>
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel-->       
</div>
      
    

</div><!--End Inner container-->
</div><!--End Row-->
</div><!--End Main-content DIV-->
</section><!--End Main-content Section-->

<script type="text/javascript">
$(document).ready(function(){

                $("#credit_payment_mode").change(function(){
                        var payment_detail = JSON.parse($("#credit_payment_mode").val());
			$("#extra_detail_div").hide();
			if(payment_detail['extra_detail'] == '1'){
				$("#extra_detail_div").show();
			}
                }); 
})
</script>


<script type="text/javascript">
$(document).ready(function(){
                $("#credit_account_type").change(function(){
			$('#account_number').val('');	
			$('#member_id').val('');       
                        $('#member_name').val('');
                        $('#member_age').val('');
                        $('#account_balance').val('');
                        $('#account_id').val('');
                }); 
})
</script>

<script type="text/javascript">
$(document).ready(function(){
	$('#account_number').change('input',function(e){
			var accnt_no = $("#account_number").val();
			var account_type = $("#credit_account_type").val();
			$('#member_id').val('');       
                        $('#member_name').val('');
			$('#member_age').val('');
			$('#account_balance').val('');
			$('#account_id').val('');

			if(!accnt_no){
				return false;
			}

			if(!account_type){
				$("#account_number").val('');
				swal({
					title: "Select account type",
					text: "First select account type",
					type: "warning",
				});
			}else{
				var account_type_array = JSON.parse(account_type);
				var account_type_id = account_type_array['id'];
				var account_type_short_code = account_type_array['short_code'];
  				$.ajax({
                               		method : "POST",
                               		url : "<?php echo site_url('Admin/get_account_detail')?>",
                                        	data : {'account_number': accnt_no, 'account_type_id': account_type_id, 'account_type_short_code': account_type_short_code},
							success : function (data) {
								if(!data){
									swal({
										title: "Invalid account",
										text: "Account number not found",
										type: "warning",
									});
								}else{
									var accnt_detail = JSON.parse(data);
									$('#member_id').val(accnt_detail['member_id']);       
									$('#member_name').val(accnt_detail['member_name']);
									$('#account_balance').val(accnt_detail['balance']);
									$('#account_id').val(accnt_detail['account_id']);

									var dateOfBirth = new Date(accnt_detail['birth_date']);
									var today = new Date(moment().format('YYYY-MM-D'));

									var diff = today - dateOfBirth;
									days = diff/ 1000 / 60 / 60 / 24;
									var i=parseInt(days/365);
									if(i>=0){
										$('#member_age').val(i);
									}
									else{
										$('#member_age').val('please enter valid DOB');
									}
								}
                                        		}
                         		});
			}
	});

})
</script>

<script type="text/javascript">

$(document).ready(function(){
	$('#add-credit').on('submit',function(){
		$.ajax({
			method : "POST",
			url : "<?php echo site_url('Admin/creditAccount/insert') ?>",
			data : $(this).serialize(),
			beforeSend : function(){
				$(".block-ui").css('display','block'); 
			},success : function(data){ 
				var accnt_detail = null;
				try {
					accnt_detail = JSON.parse(data);
					if(accnt_detail['error']=="false"){  
                                        swal({
                                                   title: "Transaction completed",
                                                   text: "Note transaction number:"+accnt_detail['transaction_number'],
                                                   type: "success",
                                        });
                                        	window.scrollTo(0,1); 
                                        	$(".block-ui").css('display','none'); 
					}
    				} catch(e) {
					accnt_detail = data;	
					if(!accnt_detail){
						swal({
                                                   title: "Internal error",
                                                   text: "Contact technical team",
                                                   type: "error",
                                        	});
					}else{

						failedAlert2(accnt_detail);
						window.scrollTo(0,1);
						$(".block-ui").css('display','none');
					}
    				}
			}
		});    
		return false;
	});
})

</script>
