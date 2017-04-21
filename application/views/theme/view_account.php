<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('accounts') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-danger ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-md-8 col-lg-8 col-sm-8">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('account_information') ?></div>
    <div class="panel-body add-client">


	<?php if(!empty($accounts)){?>
		
	<div class="alert alert-info"><p>  Account detail</p></div>	
		<div class="form-group">
    			<label for="account_number"><?php get_phrase('account_number') ?></label>
   			<input type="string" class="form-control"  value="<?php echo $accounts[0]['bank_account_number']?>" >
  		</div>	

		<div class="form-group">
                        <label for="account_number"><?php get_phrase('account_type') ?></label>
                        <input type="string" class="form-control"  value="<?php echo $accounts[0]['account_name']?>" >
                </div>

		<div class="form-group">
                        <label for="account_number"><?php get_phrase('joint_account') ?></label>
                        <input type="string" class="form-control"  value="<?php if($accounts[0]['joint_account'] == 1) echo "YES"; else echo "NO";?>" >
                </div>

		<div class="form-group">
                        <label for="opening_date"><?php get_phrase('opening_date') ?></label>
                        <input type="string" class="form-control"  value="<?php echo $accounts[0]['opening_date']?>" >
                </div>

		<div class="form-group">
                        <label for="opening_date"><?php get_phrase('status') ?></label>
                        <input type="string" class="form-control"  value="<?php if($accounts[0]['status'] == 1) echo 'ACTIVE'; else echo 'INACTIVE'; ?>" >
                </div>

		<?php foreach($accounts as $account){?>
			<div class="alert alert-info"><p> Member Detail</p></div>
				<div class="form-group">
                        		<label for="member_id"><?php get_phrase('member_id') ?></label>
                        		<input type="string" class="form-control"  value="<?php echo $account['member_id']; ?>" >
                		</div>

				<div class="form-group">
                                        <label for="member_id"><?php get_phrase('member_name') ?></label>
                                        <input type="string" class="form-control"  value="<?php echo $account['member_name']; ?>" >
                                </div>

				<div class="form-group">
                                        <label for="member_id"><?php get_phrase('mobile_number') ?></label>
                                        <input type="string" class="form-control"  value="<?php echo $account['mobile_no']; ?>" >
                                </div>

				<div class="form-group">
                                        <label for="member_id"><?php get_phrase('email_id') ?></label>
                                        <input type="string" class="form-control"  value="<?php echo $account['email_id']; ?>" >
                                </div>

				<div class="form-group">
                                        <label for="member_id"><?php get_phrase('birth_date') ?></label>
                                        <input type="string" class="form-control"  value="<?php echo $account['birth_date']; ?>" >
                                </div>

				<div class="form-group">
                                        <label for="member_id"><?php get_phrase('gender') ?></label>
                                        <input type="string" class="form-control"  value="<?php echo $account['gender']; ?>" >
                                </div>

				<div class="form-group">
                                        <label for="member_id"><?php get_phrase('residential_address') ?></label>
                                        <input type="string" class="form-control"  value="<?php echo $account['residential_address']; ?>" >
                                </div>

				<div class="form-group">
                                        <label for="member_id"><?php get_phrase('office_address') ?></label>
                                        <input type="string" class="form-control"  value="<?php echo $account['office_address']; ?>" >
                                </div>
		<?php }?>

	<?php } else{?>

	<div class="panel-heading"><?php get_phrase('invalid_account') ?></div>
	<?php } ?>	

	
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel-->       
</div>
      
    

</div><!--End Inner container-->
</div><!--End Row-->
</div><!--End Main-content DIV-->
</section>

