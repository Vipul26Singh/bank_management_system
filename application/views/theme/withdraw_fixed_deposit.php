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
    <div class="panel-heading"><?php get_phrase('withdraw_fd') ?></div>
    <div class="panel-body add-client">
 <form id="withdraw-fd">


 <div class="form-group">
    <label for="account_number"><?php get_phrase('account_number') ?><span style='color:red'>  *</span></label>
   <input type="string" class="form-control"  placeholder="Account Number" name="account_number" id="account_number">
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
    <label for="account_number"><?php get_phrase('maturity_date') ?></label>
    <input type="string" class="form-control"  readonly="true" name="maturity_date" id="maturity_date">
  </div>

  <div class="form-group">
    <label for="account_number"><?php get_phrase('maturity_amount') ?></label>
    <input type="string" class="form-control"  readonly="true" name="maturity_amount" id="maturity_amount">
  </div>

   <div class="form-group">
    <label for="account_number"><?php get_phrase('pay_amount') ?></label>
    <input type="string" class="form-control"  readonly="true" name="pay_amount" id="pay_amount">
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


    <div class="form-group">
                    <label for="balance"><?php get_phrase('withdraw_date') ?></label>
                    <input type="text" class="form-control" name="date" id="date" readonly="true" />
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
		$('#date').val(moment().format('YYYY-MM-DD'));
	$('#account_number').change('input',function(e){
			var accnt_no = $("#account_number").val();
			$('#member_id').val('');       
                        $('#member_name').val('');
			$('#maturity_date').val('');
			$('#maturity_amount').val('');
			$('#pay_amount').val('');

			if(!accnt_no){
				return false;
			}

  				$.ajax({
                               		method : "POST",
                               		url : "<?php echo site_url('Admin/withdrawFixedDeposit/fetch_account_detail')?>",
                                        	data : {'account_number': accnt_no},
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
                        						$('#maturity_date').val(accnt_detail['maturity_date']);
                        						$('#maturity_amount').val(accnt_detail['maturity_amount']);
                        						$('#pay_amount').val(accnt_detail['pay_amount']);
								}
                                        		}
                         		});
	});

})
</script>

<script type="text/javascript">

$(document).ready(function(){
	$('#withdraw-fd').on('submit',function(){
		$.ajax({
			method : "POST",
			url : "<?php echo site_url('Admin/withdrawFixedDeposit/withdraw') ?>",
			data : $(this).serialize(),
			beforeSend : function(){
				$(".block-ui").css('display','block'); 
			},success : function(data){ 
				if(!data){
                                                swal({
                                                   title: "Internal error",
                                                   text: "Contact technical team",
                                                   type: "error",
                                                });
                                        }else{
                                                if(data!="success"){
                                                failedAlert2(data);
                                                window.scrollTo(0,1);
                                                $(".block-ui").css('display','none');
                                                }else{
                                                        swal({
                                                                title: "Success",
                                                                text: "Transaction Successful",
                                                                type: "success"
                                                        });
                                                        $("#withdraw-fd")[0].reset();
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
