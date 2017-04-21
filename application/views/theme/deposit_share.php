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
<div class="panel panel-default">
    <!-- Default panel contents -->
    <?php if(!isset($edit_account)){ ?>  
<div class="panel-heading"><?php get_phrase('add_account') ?></div>
    <div class="panel-body add-client">
    <form id="add-accounts">
  <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="chart_id" id="accounts_id" value=""/>    
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_id') ?>  <span style="color:red">  *</span></label>
   <input type="number" class="form-control text-readonly" min="0"placeholder="Member Id"  name="member_id" id="member_id">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control text-readonly" name="member_name" placeholder="Member Name" id="member_name" readonly="true">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('share_account_no') ?></label>
    <input type="text" class="form-control text-readonly" name="share_account_no" placeholder="Share Account Number" id="share_account_no" readonly="true">
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
  <!-- <div class="form-group">
    <label for="acc_name"><?php get_phrase('share account id') ?></label>
    <input type="number" class="form-control" name="share" id="share">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('share_member_name') ?></label>
    <input type="text" class="form-control" name="share_member_name" id="share_member_name" readonly="true">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('shares_with_member') ?></label>
    <input type="text" class="form-control" name="shares_with_member" id="shares_with_member">
  </div> -->
  <div class="form-group">
    <label for="balance"><?php get_phrase('share_amount') ?><span style="color:red">  *</span></label>
    <input type="number" class="form-control" name="share_amount" min="0" id="share_amount" placeholder="Enter Amount">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('balance_share') ?></label>
    <input type="text" class="form-control" name="balance_share" placeholder="Share Balance" id="balance_share" readonly="true">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('date') ?></label>
    <input type="text" class="form-control" name="date" id="date" readonly="true">
  </div>
     
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
</form>
 <?php }else{ ?>
	<div class="panel-heading"><?php get_phrase('account_detail') ?></div>
    <div class="panel-body add-client">
    <form id="add-accounts1" action="<?php echo base_url();?>Admin/addAccount/update">
  <input type="hidden" name="action" id="action" value="update"/>  
  <div class="form-group">
	<label for="acc_name"><?php get_phrase('member_id') ?></label>
    <input type="text" class="form-control text-readonly" name="member_id" id="member_id" value="<?php echo $edit_account->member_id ?>" readonly="true"/>
  </div>

  <div class="form-group">
    <label for="acc_name"><?php get_phrase('bank_account_number') ?></label>
    <input type="text" class="form-control text-readonly" name="bank_account_number" id="bank_account_number" value="<?php echo $edit_account->bank_account_number ?>" readonly="true">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('share account id') ?></label>
    <input type="number" class="form-control text-readonly" name="share" id="share" value="<?php echo $edit_account->share_id ?>" readonly="true" />
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('share_member_name') ?></label>
    <input type="text" class="form-control" name="share_member_name" id="share_member_name" value="<?php echo $edit_account->share_member_name ?>" />
  </div>
	<div class="form-group">
    <label for="balance"><?php get_phrase('account_balance') ?></label>
    <input type="number" class="form-control" name="account_balance" id="account_balance" placeholder="Enter Amount" value="<?php echo $edit_account->account_balance ?>" />
  </div>

  </div>
  
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
</form>

 <?php } ?>

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
if($(".sidebar").width()=="0"){
$(".main-content").css("padding-left","0px");
} 
$('#member_id').change('input',function(e){
  var member_id = $("#member_id").val();
  $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_share')?>",
  data : {'member_id': member_id},success : function (data) {
    var data = JSON.parse(data);
     if(data==null){swal({title:'Member Not Found',text:'Add Member First'});}
    $('#member_name').val(data['member_name']);
     $('#share_account_no').val(data['share_id']);
      $('#balance_share').val(data['share_amount']);
  }
});});
  
  $('#balance').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
  });


$('#add-accounts').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/depositShare/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){  
sucessAlert("Saved Sucessfully"); 
window.scrollTo(0,1);
$(".block-ui").css('display','none'); 
if($("#action").val()!='update'){   
window.setTimeout(function(){location.reload()},1000)      
appendRow();
$('#add-accounts')[0].reset();      
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
