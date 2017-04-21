
<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_repeating_income') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-md-10 col-lg-10 col-sm-10">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_add_repeating_income') ?></div>
    <div class="panel-body add-client">
    <form id="add-repeat-income" method="post" action="<?php echo site_url('Admin/repeatIncome/insert') ?>">
  <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trans_id" id="trans_id" value=""/>    
 <div class="col-md-6 col-lg-6 col-sm-6">    
 <div class="form-group"> 
    <label for="account"><?php get_phrase('account_name') ?></label>
    <select name="account" class="form-control" id="account"> 
      <?php foreach ($accounts as $account) {?>
      <option value="<?php echo $account->member_name ?>"><?php echo $account->member_name?></option>
      <?php } ?> 
    </select>      
  </div> 
  </div>
   <div class="col-md-6 col-lg-6 col-sm-6"> 
 <div class="form-group">
     <label for="account"><?php get_phrase('date') ?></label>
    <div class='input-group date' id='date'>
        <input type='text' name="income-date" id="income-date" class="form-control" />
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
 </div>
</div> 
 
  <div class="col-md-6 col-lg-6 col-sm-6"> 
    <div class="form-group">
    <label for="rotation"><?php get_phrase('rotation') ?></label>
    <select name="rotation" class="form-control" id="rotation">  
	<option value="30"><?php get_phrase('monthly') ?></option>
	<option value="7"><?php get_phrase('weekly') ?></option>
	<option value="14"><?php get_phrase('bi_weekly') ?></option>
	<option value="1"><?php get_phrase('everyday') ?></option>
	<option value="30"><?php get_phrase('every_30_days') ?></option>
	<option value="60"><?php get_phrase('every_2_month') ?></option>
	<option value="120"><?php get_phrase('quarterly') ?></option>
	<option value="180"><?php get_phrase('every_6_month') ?></option>
	<option value="365"><?php get_phrase('yearly') ?></option>
    </select>  
  </div>  
</div>
 
<div class="col-md-6 col-lg-6 col-sm-6"> 
  <div class="form-group">
    <label for="rotation-income"><?php get_phrase('number_of_rotation') ?> (<?php get_phrase('income') ?>)</label>
    <input type="text" class="form-control" name="rotation-income" id="rotation-income">
  </div>  
</div>
  
   <div class="col-md-6 col-lg-6 col-sm-6">                   
  <div class="form-group"> 
    <label for="income-type"><?php get_phrase('income_type') ?></label>
    <select name="income-type" class="form-control" id="income-type">  
       <?php foreach ($category as $cat) {?>
      <option value="<?php echo $cat->accounts_name ?>"><?php echo $cat->accounts_name ?></option>
      <?php } ?>   
    </select>      
  </div>         
  </div>
  
 <div class="col-md-6 col-lg-6 col-sm-6">                                     
  <div class="form-group">
    <label for="amount"><?php get_phrase('amount') ?></label>
      <div class='input-group date'>
        <div class="input-group-addon"><?php echo get_current_setting('currency_code') ?></div>  
        <input type='text' name="amount" id="amount" class="form-control" />
    </div>
  </div>
</div>    

    <div class="col-md-6 col-lg-6 col-sm-6"> 
    <div class="form-group"> 
    <label for="payer"><?php get_phrase('payer') ?></label>
    <select name="payer" class="form-control" id="payer">  
    <?php foreach ($payers as $p) {?>
    <option value="<?php echo $p->payee_payers ?>"><?php echo $p->payee_payers ?></option>
    <?php } ?>   
    </select>      
    </div>  
   </div>
    
     <div class="col-md-6 col-lg-6 col-sm-6"> 
    <div class="form-group"> 
    <label for="p-method"><?php get_phrase('payment_method') ?></label>
    <select name="p-method" class="form-control" id="p-method">
     <?php foreach ($p_method as $method) {?>
      <option value="<?php echo $method->p_method_name ?>"><?php echo $method->p_method_name ?></option>
    <?php } ?>   
    </select>      
     </div>
    </div> 
       
 <div class="col-md-6 col-lg-6 col-sm-6"> 
    <div class="form-group">
    <label for="reference"><?php get_phrase('reference_no') ?></label>
    <input type="text" class="form-control" name="reference" id="reference">
  </div>  
</div>
   
  <div class="col-md-6 col-lg-6 col-sm-6"> 
    <div class="form-group">
    <label for="note"><?php get_phrase('note') ?></label>
    <input type="text" class="form-control" name="note" id="note">
  </div>     
</div>
    
<div class="col-md-6 col-lg-6 col-sm-6">      
<button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('submit') ?></button>
</div>

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
$(document).ready(function() {
$(".asyn-repeat-income").addClass("active-menu"); 

$("#rotation-income").keypress(function (e) {
if (e.which != 8 && e.which != 0 &&  (e.which < 48 || e.which > 57)) {
return false;
}
}); 

$('#amount').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
}); 
 
$("#account").select2();
$("#income-type").select2();
$("#payer").select2(); 
$("#p-method").select2();     
$("#date").datepicker();  

$('#add-repeat-income').on('submit',function(event){ 
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/repeatIncome/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){  
if(data=="true"){   
sucessAlert("Saved Sucessfully"); 
$(".block-ui").css('display','none');
$('#add-repeat-income')[0].reset(); 
}else{
failedAlert2(data);
$(".block-ui").css('display','none');
}   
}
});    
return false;
});
   

});

</script>

