<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">  
  
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_accounts') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->


<div class="col-md-8">
<!--Start Panel-->
<div class="alert alert-info"><p>Create Member Before Creating Account</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <?php if(!isset($edit_account)){ ?>  
	    <div class="panel-heading"><?php get_phrase('add_account') ?></div>
		    <div class="panel-body add-client">
		    <form id="add-accounts">
		    <input type="hidden" name="action" id="action" value="insert"/>  
		    <input type="hidden" name="chart_id" id="accounts_id" value=""/> 
	
		<div id="account_number_div" hidden>
		    <div class="form-group">
                    <label for="account_number"><?php get_phrase('account_number') ?></label>
                    <input type="text" class="form-control" name="account_number" id="account_number" style="background-color: #eeeeee" readonly="true"/>
                    </div>
		</div>

			<div class="form-group">
    <label for="balance"><?php get_phrase('active_by') ?><span style="color:red">  *</span></label>
    <select name="active_by" class="form-control" id="active_by">
      <option value="<?php echo $this->session->userdata('user_id')?>" selected="selected"><?php echo $this->session->userdata('username')?></option>
    </select>
  </div>



		    <div class="form-group">
		    <label for="acc_name"><?php get_phrase('bank_account_type') ?><span style="color:red">  *</span></label>
		    <select class="form-control" id='bank_account_type' name='bank_account_type'>
		    <option value=''>Select</option>
		    <?php foreach($account_type as $accounts){
			if($accounts->status == 1){
			?>
				
			    <option value='<?php echo $accounts->tbl_id?>'><?php echo $accounts->account_name?></option>
				    <?php 
		      }
		}?>
	    </select>
		    </div>

		    <?php foreach($account_type as $accounts){ 
			if($accounts->status == 1){
			?>

			<?php if($accounts->joint_account==1){?>
			<div class="form-group">
                    		<input type="checkbox" name="<?php echo $accounts->html_id?>_joint" id="<?php echo $accounts->html_id?>_joint" value="<?php echo $accounts->html_id?>_joint" hidden><span name="<?php echo $accounts->html_id?>_joint_text" id="<?php echo $accounts->html_id?>_joint_text" hidden>&nbsp;Joint Account</span>
			</div>
			<?php }?>

			<div id="<?php echo $accounts->tbl_id?>" class="<?php echo $accounts->tbl_id?>" hidden>
				<?php
                                        require_once("account_type/{$accounts->code_file}");
                                ?>
                        </div>
		    <?php
			    }
			}?>

		
			<div class="form-group">
                    <label for="balance"><?php get_phrase('opening_date') ?></label>
                    <input type="text" class="form-control" name="date" id="date" readonly="true" />
                    </div>

		    <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
		    </form>
		    <?php 
    }else{ ?>




	    <div class="panel-heading"><?php get_phrase('account_detail') ?></div>
		    <div class="panel-body add-client">

		    <form id="edit-accounts1">
		    <input type="hidden" name="action" id="action" value="update"/>  
		    <div class="form-group">
		    <label for="acc_name"><?php get_phrase('member_id') ?></label>
		    <input type="text" class="form-control" name="member_id" id="member_id" value="<?php echo $edit_account->member_id ?>" readonly="true"/>
		    </div>
		    <div class="form-group">
		    <label for="acc_name"><?php get_phrase('member_name') ?></label>
		    <input type="text" class="form-control" name="member_name" id="member_name" value="<?php echo $edit_account->member_name ?>" readonly="true">
		    </div>
		    <input type="text" name="b_account_type" id="b_account_type" hidden value='<?php echo $edit_account->bank_account_type?>'>
		    <div class="form-group">
		    <label for="acc_name" ><?php get_phrase('bank_account_type1') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
		    <select class="form-control" id='bank_account_type' name='bank_account_type'>
		    <option value=''>Select</option>
		    <?php foreach($account_type as $accounts){?>
			    <option value='<?php echo $accounts->html_id?>'><?php echo $accounts->account_name?></option>
				    <?php 
		    }?>
	    </select>
		    <input type="text" hidden="true" name="account_type" id="account_type" value="<?php echo $edit_account->bank_account_type?>"  />
		    </div>
		    <div class="form-group">
		    <label for="acc_name"><?php get_phrase('bank_account_number') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
		    <input type="number" class="form-control text-readonly" min="0" name="bank_account_number" id="bank_account_number" value="<?php echo $edit_account->bank_account_number ?>" >
		    </div>
		    <div class="form-group">
		    <label for="balance"><?php get_phrase('account_balance') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
		    <input type="number" class="form-control" step="0.01" name="account_balance" id="account_balance" placeholder="Enter Amount" value="<?php echo $edit_account->account_balance ?>" min="0"/>
		    </div>
		    <div class="form-group">
		    <label for="balance"><?php get_phrase('opening_date') ?></label>
		    <input type="text" class="form-control" name="opening_date" id="opening_date"  value="<?php echo $edit_account->opening_date?>" readonly/>
		    </div>



		    <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
		    </form>
		    </div>
		    <?php 
    } ?>

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
		$("#bank_account_type").change(function(){
				$(".alert-success").hide();
				$("#account_number_div").hide();
				var account_type = $("#bank_account_type").val();

				var tmp=null;   

				$.ajax({
						'async': false,
						'global': false,
						'type': "POST",
						'dataType': 'html',
						'url': "<?php echo site_url('Helper/fetch_loan_types'); ?>",
						'data': { 'account_type': account_type},
						'success': function (data) {
						tmp = data;
						}
						});

				var obj = jQuery.parseJSON(tmp);        
				$.each(obj, function(key, value) {

						$("#"+value.tbl_id).hide();

						if(value.joint_account==1){
						$("#"+value.html_id+"_joint").hide();
						$("#"+value.html_id+"_joint_text").hide();
						}

						if(value.tbl_id==account_type && value.joint_account==1){
						$("#"+value.html_id+"_joint").show();
						$("#"+value.html_id+"_joint_text").show();
						}
						});

				$("#"+account_type).show();     

		});

		$("#saving_joint").change(function(){
			var is_joint = $("#saving_joint").val();

			if( $(this).is(':checked') ) {
				$("#saving_joint_account").show();
			}
			else{
				$("#saving_joint_account").hide();      
			}
		}); 
})
</script>

<script type="text/javascript">
$(document).ready(function(){

                $("#current_joint").change(function(){
                        var is_joint = $("#current_joint").val();

                        if( $(this).is(':checked') ) {
                                $("#current_joint_account").show();
                        }
                        else{
                                $("#current_joint_account").hide();      
                        }
                }); 
})
</script>

<script type="text/javascript">

$(document).ready(function(){

	$("#loan_joint").change(function(){
                        var is_joint = $("#loan_joint").val();

                        if( $(this).is(':checked') ) {
                                $("#loan_joint_account").show();
                        }
                        else{
                                $("#loan_joint_account").hide();      
                        }
         });

	$("#loan_auto_deduct").change(function(){
                        var is_joint = $("#loan_auto_deduct").val();

                        if( $(this).is(':checked') ) {
                                $("#loan_linked_div").show();
                        }
                        else{
                                $("#loan_linked_div").hide();      
                        }
                });

	$('#loan_member_id').change('input',function(e){
                                var id = $("#loan_member_id").val();

                                $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Admin/get_user')?>",
                                        data : {'id': id},success : function (data) {
                                                var name = JSON.parse(data);
                                                if(name==null){
                                                        $('#loan_member_name').val('');       
                                                        swal({title:'Member Not Found',text:'Memeber Id not found'});
                                                }
                                                $('#loan_member_name').val(name['member_name']);
                                                var dateOfBirth = new Date(name['birth_date']);
                                                var today = new Date(moment().format('YYYY-MM-D'));

                                                var diff = today - dateOfBirth;
                                                days = diff/ 1000 / 60 / 60 / 24;
                                                var i=parseInt(days/365);
                                                if(i>=0){
                                                        $('#loan_member_age').val(i);
                                                }
                                                else{
                                                        $('#loan_member_age').val('please enter valid DOB');
                                                }

                                        }
                                });

          });

	$('#loan_member_id_2').change('input',function(e){
                                var id = $("#loan_member_id_2").val();

                                $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Admin/get_user')?>",
                                        data : {'id': id},success : function (data) {
                                                var name = JSON.parse(data);
                                                if(name==null){
                                                        $('#loan_member_name_2').val('');       
                                                        swal({title:'Member Not Found',text:'Memeber Id not found'});
                                                }
                                                $('#loan_member_name_2').val(name['member_name']);
                                                var dateOfBirth = new Date(name['birth_date']);
                                                var today = new Date(moment().format('YYYY-MM-D'));

                                                var diff = today - dateOfBirth;
                                                days = diff/ 1000 / 60 / 60 / 24;
                                                var i=parseInt(days/365);
                                                if(i>=0){
                                                        $('#loan_member_age_2').val(i);
                                                }
                                                else{
                                                        $('#loan_member_age_2').val('please enter valid DOB');
                                                }

                                        }
                                });
          });

	$('#loan_introducer_id').change('input',function(e){
                                var id = $("#loan_introducer_id").val();

                                $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Admin/get_user')?>",
                                        data : {'id': id},success : function (data) {
                                                var name = JSON.parse(data);
                                                if(name==null){
                                                        $('#loan_introducer_name').val('');       
							$('#loan_introducer_share').val('');
                                                        swal({title:'Member Not Found',text:'Memeber Id not found'});
                                                }
                                                $('#loan_introducer_name').val(name['member_name']);
						$('#loan_introducer_share').val(name['share']);

                                        }
                                });
          });

	$('#loan_introducer_id_2').change('input',function(e){
                                var id = $("#loan_introducer_id_2").val();

                                $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Admin/get_user')?>",
                                        data : {'id': id},success : function (data) {
                                                var name = JSON.parse(data);
                                                if(name==null){
                                                        $('#loan_introducer_name_2').val('');       
                                                        $('#loan_introducer_share_2').val('');
                                                        swal({title:'Member Not Found',text:'Memeber Id not found'});
                                                }
                                                $('#loan_introducer_name_2').val(name['member_name']);
                                                $('#loan_introducer_share_2').val(name['share']);

                                        }
                                });
          });

        $('#loan_interest').change('input',function(e){
                var interest_temp = $("#loan_interest").val();
                var duration = $("#loan_tenure").val();
                var principal = $("#loan_amount").val();

		var int_tmp = JSON.parse(interest_temp);
		var interest = int_tmp['interest'];

                if(interest && duration && principal){
                        $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Helper/get_loan_interest')?>",
                                        data : {'interest': interest, 'duration': duration, 'principal': principal},success : function (data) {
                                                var result = JSON.parse(data);

                                                if(result==null){
                                                        $('#loan_emi').val('');   
                                                        $('#loan_total_interest').val('');    
							$('#loan_amount_payable').val('');
                                                        swal({title:'Internal error',text:'Internal error. Please try again'});
                                                }

						$('#loan_emi').val(result['emi']);   
                                                $('#loan_total_interest').val(result['interest']);    
                                                $('#loan_amount_payable').val(result['amount']);

                                        }
                                });
                }else{
			$('#loan_emi').val('');   
                        $('#loan_total_interest').val('');    
                        $('#loan_amount_payable').val('');
                }
        });

	$('#loan_tenure').change('input',function(e){
		var interest_temp = $("#loan_interest").val();
                var duration = $("#loan_tenure").val();
                var principal = $("#loan_amount").val();

                var int_tmp = JSON.parse(interest_temp);
                var interest = int_tmp['interest'];

                if(interest && duration && principal){
                        $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Helper/get_loan_interest')?>",
                                        data : {'interest': interest, 'duration': duration, 'principal': principal},success : function (data) {
                                                var result = JSON.parse(data);

                                                if(result==null){
                                                        $('#loan_emi').val('');   
                                                        $('#loan_total_interest').val('');    
                                                        $('#loan_amount_payable').val('');
                                                        swal({title:'Internal error',text:'Internal error. Please try again'});
                                                }

                                                $('#loan_emi').val(result['emi']);   
                                                $('#loan_total_interest').val(result['interest']);    
                                                $('#loan_amount_payable').val(result['amount']);

                                        }
                                });
                }else{
                        $('#loan_emi').val('');   
                        $('#loan_total_interest').val('');    
                        $('#loan_amount_payable').val('');
                }
        });

	$('#loan_amount').change('input',function(e){
		var interest_temp = $("#loan_interest").val();
                var duration = $("#loan_tenure").val();
                var principal = $("#loan_amount").val();

                var int_tmp = JSON.parse(interest_temp);
                var interest = int_tmp['interest'];

                if(interest && duration && principal){
                        $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Helper/get_loan_interest')?>",
                                        data : {'interest': interest, 'duration': duration, 'principal': principal},success : function (data) {
                                                var result = JSON.parse(data);

                                                if(result==null){
                                                        $('#loan_emi').val('');   
                                                        $('#loan_total_interest').val('');    
                                                        $('#loan_amount_payable').val('');
                                                        swal({title:'Internal error',text:'Internal error. Please try again'});
                                                }

                                                $('#loan_emi').val(result['emi']);   
                                                $('#loan_total_interest').val(result['interest']);    
                                                $('#loan_amount_payable').val(result['amount']);

                                        }
                                });
                }else{
                        $('#loan_emi').val('');   
                        $('#loan_total_interest').val('');    
                        $('#loan_amount_payable').val('');
                }
        });


})

</script>


<script type="text/javascript">

$(document).ready(function(){

	$("#fd_joint").change(function(){
                        var is_joint = $("#fd_joint").val();

                        if( $(this).is(':checked') ) {
                                $("#fd_joint_account").show();
                        }
                        else{
                                $("#fd_joint_account").hide();      
                        }
         });

	$('#fd_interest').change('input',function(e){
		var interest_temp = $("#fd_interest").val();
		var duration = $("#fd_duration").val();
		var principal = $("#fd_account_balance").val();

                var int_tmp = JSON.parse(interest_temp);
                var interest = int_tmp['interest'];

		if(interest && duration && principal){
			$.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Helper/get_fd_maturity')?>",
                                        data : {'interest': interest, 'duration': duration, 'principal': principal},success : function (data) {
                                                var result = JSON.parse(data);

                                                if(result==null){
                                                        $('#fd_maturity_date').val('');   
							$('#fd_maturity_amount').val('');    
                                                        swal({title:'Internal error',text:'Internal error. Please try again'});
                                                }
						$('#fd_maturity_date').val(result['maturity_date']);   
                                                $('#fd_maturity_amount').val(result['maturity_amount']);
                                        }
                                });
		}else{
			$('#fd_maturity_date').val('');   
                        $('#fd_maturity_amount').val('');
		}
	});

	$('#fd_account_balance').change('input',function(e){
		var interest_temp = $("#fd_interest").val();
                var duration = $("#fd_duration").val();
                var principal = $("#fd_account_balance").val();

                var int_tmp = JSON.parse(interest_temp);
                var interest = int_tmp['interest'];

                if(interest && duration && principal){
			$.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Helper/get_fd_maturity')?>",
                                        data : {'interest': interest, 'duration': duration, 'principal': principal},success : function (data) {
                                                var result = JSON.parse(data);

                                                if(result==null){
                                                        $('#fd_maturity_date').val('');   
                                                        $('#fd_maturity_amount').val('');    
                                                        swal({title:'Internal error',text:'Internal error. Please try again'});
                                                }
                                                $('#fd_maturity_date').val(result['maturity_date']);   
                                                $('#fd_maturity_amount').val(result['maturity_amount']);
                                        }
                                });
                }else{
			$('#fd_maturity_date').val('');   
                        $('#fd_maturity_amount').val('');
		}
        });

	$('#fd_duration').change('input',function(e){
		var interest_temp = $("#fd_interest").val();
                var duration = $("#fd_duration").val();
                var principal = $("#fd_account_balance").val();

                var int_tmp = JSON.parse(interest_temp);
                var interest = int_tmp['interest'];

                if(interest && duration && principal){
			$.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Helper/get_fd_maturity')?>",
                                        data : {'interest': interest, 'duration': duration, 'principal': principal},success : function (data) {
                                                var result = JSON.parse(data);

                                                if(result==null){
                                                        $('#fd_maturity_date').val('');   
                                                        $('#fd_maturity_amount').val('');    
                                                        swal({title:'Internal error',text:'Internal error. Please try again'});
                                                }
                                                $('#fd_maturity_date').val(result['maturity_date']);   
                                                $('#fd_maturity_amount').val(result['maturity_amount']);
                                        }
                                });
                }else{
			$('#fd_maturity_date').val('');   
                        $('#fd_maturity_amount').val('');
		}
        });


})

</script>

<script type="text/javascript">
$(document).ready(function(){
                $('#fd_member_id').change('input',function(e){
                                var id = $("#fd_member_id").val();

                                $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Admin/get_user')?>",
                                        data : {'id': id},success : function (data) {
                                                var name = JSON.parse(data);
                                                if(name==null){
                                                        $('#fd_member_name').val('');       
                                                        swal({title:'Member Not Found',text:'Memeber Id not found'});
                                                }
                                                $('#fd_member_name').val(name['member_name']);
                                                var dateOfBirth = new Date(name['birth_date']);
                                                var today = new Date(moment().format('YYYY-MM-D'));

                                                var diff = today - dateOfBirth;
                                                days = diff/ 1000 / 60 / 60 / 24;
                                                var i=parseInt(days/365);
                                                if(i>=0){
                                                        $('#fd_member_age').val(i);
                                                }
                                                else{
                                                        $('#fd_member_age').val('please enter valid DOB');
                                                }

                                        }
                                });
                });

		$('#fd_member_id_2').change('input',function(e){
                        var id = $("#fd_member_id_2").val();

                        $.ajax({
                                method : "POST",
                                url : "<?php echo site_url('Admin/get_user')?>",
                                data : {'id': id},success : function (data) {
                                        var name = JSON.parse(data);
                                        if(name==null){         
                                                $('#fd_member_name_2').val('');
                                                swal({title:'Member Not Found',text:'Memeber Id not found'});
                                        }
                                        $('#fd_member_name_2').val(name['member_name']);

                                        var dateOfBirth = new Date(name['birth_date']);
                                                var today = new Date(moment().format('YYYY-MM-D'));

                                                var diff = today - dateOfBirth;
                                                days = diff/ 1000 / 60 / 60 / 24;
                                                var i=parseInt(days/365);
                                                if(i>=0){
                                                        $('#fd_member_age_2').val(i);
                                                }
                                                else{
                                                        $('#fd_member_age_2').val('please enter valid DOB');
                                                }
                                }
                        });
                });
})
</script>

<script type="text/javascript">
$(document).ready(function(){
		$('#saving_member_id').change('input',function(e){
				var id = $("#saving_member_id").val();

				$.ajax({
					method : "POST",
					url : "<?php echo site_url('Admin/get_user')?>",
					data : {'id': id},success : function (data) {
						var name = JSON.parse(data);
						if(name==null){
							$('#saving_member_name').val('');	
							swal({title:'Member Not Found',text:'Memeber Id not found'});
						}
						$('#saving_member_name').val(name['member_name']);
						var dateOfBirth = new Date(name['birth_date']);
						var today = new Date(moment().format('YYYY-MM-D'));

						var diff = today - dateOfBirth;
						days = diff/ 1000 / 60 / 60 / 24;
						var i=parseInt(days/365);
						if(i>=0){
							$('#saving_member_age').val(i);
						}
						else{
							$('#saving_member_age').val('please enter valid DOB');
						}

					}
				});
		});

		$('#saving_member_id_2').change('input',function(e){
			var id = $("#saving_member_id_2").val();

			$.ajax({
				method : "POST",
				url : "<?php echo site_url('Admin/get_user')?>",
				data : {'id': id},success : function (data) {
					var name = JSON.parse(data);
					if(name==null){		
						$('#saving_member_name_2').val('');
						swal({title:'Member Not Found',text:'Memeber Id not found'});
					}
					$('#saving_member_name_2').val(name['member_name']);

					var dateOfBirth = new Date(name['birth_date']);
                                                var today = new Date(moment().format('YYYY-MM-D'));

                                                var diff = today - dateOfBirth;
                                                days = diff/ 1000 / 60 / 60 / 24;
                                                var i=parseInt(days/365);
                                                if(i>=0){
                                                        $('#saving_member_age_2').val(i);
                                                }
                                                else{
                                                        $('#saving_member_age_2').val('please enter valid DOB');
                                                }
				}
			});
		});
})
</script>


<script type="text/javascript">
        $(document).ready(function(){
                $('#current_member_id').change('input',function(e){
                                var id = $("#current_member_id").val();

                                $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Admin/get_user')?>",
                                        data : {'id': id},success : function (data) {
                                                var name = JSON.parse(data);
                                                if(name==null){	
							$('#current_member_name').val('');
							swal({title:'Member Not Found',text:'Memeber Id not found'});
						}
                                                $('#current_member_name').val(name['member_name']);

						var dateOfBirth = new Date(name['birth_date']);
                                                var today = new Date(moment().format('YYYY-MM-D'));

                                                var diff = today - dateOfBirth;
                                                days = diff/ 1000 / 60 / 60 / 24;
                                                var i=parseInt(days/365);
                                                if(i>=0){
                                                        $('#current_member_age').val(i);
                                                }
                                                else{
                                                        $('#current_member_age').val('please enter valid DOB');
                                                }
                                        }
                                });
                });

                $('#current_member_id_2').change('input',function(e){
                                var id = $("#current_member_id_2").val();

                                $.ajax({
                                        method : "POST",
                                        url : "<?php echo site_url('Admin/get_user')?>",
                                        data : {'id': id},success : function (data) {
                                                var name = JSON.parse(data);
                                                if(name==null){	
							$('#current_member_name_2').val('');
							swal({title:'Member Not Found',text:'Memeber Id not found'});
						}
                                                $('#current_member_name_2').val(name['member_name']);

						var dateOfBirth = new Date(name['birth_date']);
                                                var today = new Date(moment().format('YYYY-MM-D'));

                                                var diff = today - dateOfBirth;
                                                days = diff/ 1000 / 60 / 60 / 24;
                                                var i=parseInt(days/365);
                                                if(i>=0){
                                                        $('#current_member_age_2').val(i);
                                                }
                                                else{
                                                        $('#current_member_age_2').val('please enter valid DOB');
                                                }
                                        }
                                });
                });
})
</script>

<script type="text/javascript">
$(document).ready(function(){



if($(".sidebar").width()=="0"){
	$(".main-content").css("padding-left","0px");
}
 
$('#member_id').change('input',function(e){
  var id = $("#member_id").val();
 
  $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_user')?>",
  data : {'id': id},success : function (data) {
    var name = JSON.parse(data);
    if(name==null){
			$('#member_name').val('');
			swal({title:'Member Not Found',text:'Add Member First'});
	}
    $('#member_name').val(name['member_name']);
  }
});});
var identity = $('#account_type').val();
$('#bank_account_type').val(identity);
$('#date').val(moment().format('YYYY-MM-DD'));
  $('#duration').change(function(){
  var duration = $("#duration").val();
   var fixed_deposit_amount = $("#fixed_deposit_amount").val();
     ci = fixed_deposit_amount * Math.pow((1 + rate/100 ), duration);
       $('#maturity_amount').val(ci);
});
  $('#share').change('input',function(e){
  var id = $("#share").val();
  $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_user')?>",
  data : {'id': id},success : function (data) {
    var name = JSON.parse(data);
    $('#share_member_name').val(name['member_name']);
  }
});});
  $('#account_balance').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
jQuery.validator.addMethod("#account_balance", function(value, element) {
    return this.optional(element) || /^\d{0,4}(\.\d{0,2})?$/i.test(value);
}, "You must include two decimal places");
  });


$('#add-accounts').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/addAccount/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
try{
var accnt_detail = JSON.parse(data);
if(accnt_detail['error']=="false"){  
sucessAlert("Account number:"+accnt_detail['accnt_no']); 
$("#account_number").val(accnt_detail['accnt_no']);
$("#account_number_div").show();
window.scrollTo(0,1); 
$(".block-ui").css('display','none'); 
if($("#action").val()!='update'){        
$('#acc_name').val("");
$("#balance").val("");
$('#note').val(""); 
}
}else{
failedAlert2(accnt_detail['error_message']);
 window.scrollTo(0,1);
$(".block-ui").css('display','none');
}   
}catch(err){
	failedAlert2(data);
 window.scrollTo(0,1);
$(".block-ui").css('display','none');
}
}
});    
return false;

});
$('#edit-accounts1').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/addAccount/update') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){  
sucessAlert("Saved Sucessfully"); 
window.scrollTo(0,1);
window.setTimeout(function(){location.reload()},1000) 
$(".block-ui").css('display','none'); 
if($("#action").val()!='update'){        
$('#acc_name').val("");
$("#balance").val("");
$('#note').val("");  
}
}else{
failedAlert2(data);
  window.scrollTo(0,1);
$(".block-ui").css('display','none');
}   
}
});    
return false;

});


});
</script>
