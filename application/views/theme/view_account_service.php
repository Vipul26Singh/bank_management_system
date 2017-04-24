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
                        <label for="opening_date"><?php get_phrase('account_opening_date') ?></label>
                        <input type="string" class="form-control"  value="<?php echo $accounts[0]['opening_date']?>" >
                </div>

		<div class="form-group">
                        <label for="opening_date"><?php get_phrase('status') ?></label>
                        <input type="string" class="form-control"  value="<?php if($accounts[0]['status'] == 1) echo 'ACTIVE'; else echo 'INACTIVE'; ?>" >
                </div>

		<div class="form-group">
                        <label for="opening_date"><?php get_phrase('service_name') ?></label>
                        <input type="string" class="form-control"  value="<?php echo $accounts[0]['name']; ?>" >
                </div>

		<div class="form-group">
                        <label for="opening_date"><?php get_phrase('subscription_date') ?></label>
                        <input type="string" class="form-control"  value="<?php echo $accounts[0]['application_date']; ?>" >
                </div>

		<div class="form-group">
                        <label for="opening_date"><?php get_phrase('frequency') ?></label>
                        <input type="string" class="form-control"  value="<?php echo $accounts[0]['frequency']; ?>" >

                </div>

		<div class="form-group">
                        <label for="opening_date"><?php get_phrase('service_charge') ?></label>
                        <input type="string" class="form-control"  value="<?php echo $accounts[0]['charge']; ?>" >
                </div>

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

