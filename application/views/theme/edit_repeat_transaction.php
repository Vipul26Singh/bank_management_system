
<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_edit_repeating_transaction') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-md-5 col-lg-5 col-sm-5">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_edit_transaction') ?></div>
    <div class="panel-body add-client">
    <form id="edit-repeat-transaction">
 <input type="hidden" name="action" id="action" value="update"/>  
 <input type="hidden" name="trans_id" id="trans_id" value="<?php echo $transaction->trans_id ?>"/>       
 <div class="form-group"> 
    <label for="from-account"><?php get_phrase('account') ?></label>
    <select name="account" class="form-control" id="account" disabled>
    <option value="<?php echo $transaction->account ?>"><?php echo $transaction->account ?></option>  
    </select>      
  </div> 
  
  
 <div class="form-group">
     <label for="account"><?php get_phrase('date') ?></label>
    <div class='input-group date' id='date'>
        <input type='text' name="date" id="date" value="<?php echo $transaction->date ?>" class="form-control"/>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
 </div> 
                
                 
  <div class="form-group">
    <label for="amount"><?php get_phrase('amount') ?></label>
      <div class='input-group date'>
        <div class="input-group-addon"><?php echo get_current_setting('currency_code') ?></div>  
        <input type='text' name="amount" id="amount" class="form-control" />
    </div>
  </div>


    <div class="form-group"> 
    <label for="p-method"><?php get_phrase('payment_method') ?></label>
    <select name="p-method" class="form-control" id="payment-method">  
    <?php foreach ($p_method as $method) {?>
      <option value="<?php echo $method->p_method_name ?>"><?php echo $method->p_method_name ?></option>
    <?php } ?>   
    </select>      
  </div> 

    <div class="form-group">
    <label for="reference"><?php get_phrase('reference_no') ?></label>
    <input type="text" class="form-control" value="<?php echo $transaction->ref ?>" name="reference" id="reference">
  </div>  
    
    <div class="form-group">
    <label for="note"><?php get_phrase('note') ?></label>
    <input type="text" class="form-control" value="<?php echo $transaction->description ?>" name="note" id="note">
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

if($(".sidebar").width()=="0"){
$(".main-content").css("padding-left","0px");
}  


$("#account").select2();
$("#income-type").select2();
$("#payer").select2(); 
$("#payment-method").select2();     
$("#date").datepicker();  
$("#payment-method").select2("val","<?php echo $transaction->p_method ?>"); 

$('#amount').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
});

$('#edit-repeat-transaction').on('submit',function(event){ 
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/updateRepeatTransaction') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){  
if(data=="true"){   
sucessAlert("Saved Sucessfully"); 
$(".block-ui").css('display','none');
$('#edit-repeat-transaction')[0].reset(); 
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

