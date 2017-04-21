<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_transfer') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-md-5 col-lg-5 col-sm-5">
<!--Start Panel-->
<div class="alert alert-info"><p>>  Transfer Money Between Two Accounts</p>
<p>>  Create Account to transfer money</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_add_transfer') ?></div>
    <div class="panel-body add-client">
    <form id="add-transfer">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trans_id" id="trans_id" value=""/>       
 <div class="form-group"> 
    <label for="from-account"><?php get_phrase('account_from') ?><span style="color:red">  *</span></label>
    <select name="from-account" class="form-control" id="from-account">
    <option value=''>Select</option>
      <?php foreach ($accounts as $account) {?>
      <option value="<?php echo $account->member_id ?>"><?php echo $account->member_name ?></option>
      <?php } ?>  
    </select>      
  </div> 
  
  <div class="form-group"> 
    <label for="to-account"><?php get_phrase('account_to') ?><span style="color:red">  *</span></label>
    <select name="to-account" class="form-control" id="to-account"> 
    <option value=''>Select</option>
      <?php foreach ($accounts as $account) {?>
      <option value="<?php echo $account->member_id ?>"><?php echo $account->member_name ?></option>
      <?php } ?>  
    </select>      
  </div> 
                
  <div class="form-group">
    <label for="amount"><?php get_phrase('amount') ?><span style="color:red">  *</span></label>
      <div class='input-group date'>
        <div class="input-group-addon"><?php echo get_current_setting('currency_code') ?></div>  
        <input type='text' name="amount" id="amount" class="form-control" />
    </div>
  </div>


    <div class="form-group"> 
    <label for="p-method"><?php get_phrase('payment_method') ?><span style="color:red">  *</span></label>
    <select name="p-method" class="form-control" id="p-method">  
    <option value=''>Select</option>
    <?php foreach ($p_method as $method) {?>
      <option value="<?php echo $method->p_method_name ?>"><?php echo $method->p_method_name ?></option>
    <?php } ?>   
    </select>      
  </div> 
<div class="form-group" id="div1" name="div1">
    <label for="reference"><?php get_phrase('cheque_no') ?></label>
    <input type="text" class="form-control" name="cheque_no" id="cheque_no">
  </div> 
    <div class="form-group">
    <label for="reference"><?php get_phrase('reference_no') ?></label>
    <input type="text" class="form-control" name="reference" id="reference">
  </div>  
    
    <div class="form-group">
    <label for="note"><?php get_phrase('note') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" name="note" id="note">
  </div>     
        
   <div class="form-group">
     <label for="account"><?php get_phrase('date') ?></label>
    <div class='input-group date' id='date'>
        <input type='text' name="transfer-date" id="transfer-date" class="form-control" readonly="true" />
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
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
$(document).ready(function() {
 

$("#from-account").select2();
$("#to-account").select2();
$("#income-type").select2();
$("#payer").select2(); 
$("#p-method").select2();      
$('#reference').val(Math.floor((Math.random() * 10000) ));
$('#amount').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
});
$('#div1').hide();
$('#p-method').change(function(){var value = $('#p-method').val();
if(value=="CHEQUE"){$('#div1').show();}else{$('#div1').hide();}});
$('#transfer-date').val(moment().format('YYYY-MM-DD'));
$('#add-transfer').on('submit',function(event){ 
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/transfer/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){  
if(data=="true"){   
sucessAlert("Saved Sucessfully"); 
window.scrollTo(0,1);
$(".block-ui").css('display','none');
$('#add-transfer')[0].reset(); 
window.setTimeout(function(){location.reload()},1000)
}else{
failedAlert2(data);
window.scrollTo(0,1);
window.setTimeout(function(){location.reload()},1000)
$(".block-ui").css('display','none');
}   
}
});    
return false;
});

  

});

</script>

