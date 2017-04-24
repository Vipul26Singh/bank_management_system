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
<div class="alert alert-info"><p>  Transfer fund within current and saving account</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('transfer_fund') ?></div>
    <div class="panel-body add-client">
 <form id="tranfer-fund">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trans_id" id="trans_id" value=""/>     


 <div class="form-group">
    <label for="account_number"><?php get_phrase('account_number') ?><span style='color:red'>  *</span></label>
   <input type="string" class="form-control"  placeholder="Account Number" name="account_number" id="account_number">
  </div>

   <div id="account_detail">

  <div class="form-group" hidden>
    <label for="account_number"><?php get_phrase('account_id') ?></label>
    <input type="text" class="form-control"  name="account_id" id="account_id" readonly="true">
  </div>
 
  <div class="form-group">
    <label for="member_id"><?php get_phrase('member_id') ?></label>
    <input type="text" class="form-control" name="member_id" id="member_id" readonly="true">
  </div>
 
  <div class="form-group">
    <label for="member_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="member_name" id="member_name" readonly="true">
  </div>


  <div class="form-group">
    <label for="account_balance"><?php get_phrase('account_balance') ?></label>
    <input type="text" class="form-control" name="account_balance" id="account_balance" readonly="true">
  </div>


 <div class="form-group">
    <label for="account_balance"><?php get_phrase('transfer_amount') ?><span style='color:red'>  *</span></label>
    <input type="number" class="form-control" name="transfer_amount" id="transfer_amount" placeholder=<?php get_phrase('transfer_amount') ?>>
  </div>


	<div class="form-group">
        <label for=""><?php get_phrase('assign_service') ?><span style="color:red">  *</span></label>
                <select class="form-control" id='service_id' name='service_id'>
                    <option value=''>Select</option>

                        <?php
                                foreach($services as $service){


                        ?>
                        <option value='<?php echo json_encode($service) ?>'><?php echo $service["name"]?></option>
                        <?php
                                }
                        ?>
            </select>
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
	$('#account_number').change('input',function(e){
			var accnt_no = $("#account_number").val();
			$('#member_id').val('');       
                        $('#member_name').val('');
			$('#member_age').val('');
			$('#account_balance').val('');
			$('#account_id').val('');

			if(!accnt_no){
				return false;
			}

  				$.ajax({
                               		method : "POST",
                               		url : "<?php echo site_url('Admin/get_account_detail')?>",
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
	});


})
</script>

<script type="text/javascript">

$(document).ready(function(){
        $('#tranfer-fund').on('submit',function(){
                $.ajax({
                        method : "POST",
                        url : "<?php echo site_url('Admin/assignService/insert') ?>",
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
                                                        $("#tranfer-fund")[0].reset();
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
