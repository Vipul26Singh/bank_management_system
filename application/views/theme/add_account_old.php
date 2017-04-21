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
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_id') ?><span style="color:red">  *</span></label>
    <input type="number" class="form-control text-readonly" min="0" placeholder="Enter Member Id" name="member_id" id="member_id">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control text-readonly" name="member_name" id="member_name" readonly="true">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('bank_account_type') ?><span style="color:red">  *</span></label>
    <select class="form-control" id='bank_account_type' name='bank_account_type'>
    <option value=''>Select</option>
    <?php foreach($account_type as $accounts){?>
      <option value='<?php echo $accounts->tbl_id?>'><?php echo $accounts->account_name?></option>
     <?php }?>
    </select>
  </div>
  <!-- <div class="form-group">
    <label for="acc_name"><?php get_phrase('bank_account_number') ?><span style="color:red">  *</span></label>
    <input type="string" hidden="true" name="bank_account_number" min="0" id="bank_account_number">
  </div> -->
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
    <label for="balance"><?php get_phrase('account_balance') ?><span style="color:red">  *</span></label>
    <input type="string" class="form-control" name="account_balance" min="0" id="account_balance" placeholder="Enter Amount">
  </div>
 <!--  <div class="form-group">
    <label for="balance"><?php get_phrase('services') ?></label>
    <select class="form-control" name="services" id="services">
        <option value=''>Select</option>
        <?php foreach($services as $service){?>
        <option value="<?php echo $service->tbl_id;?>"><?php echo $service->service_name;?></option>
        <?php }?>
    </select>
  </div> -->
  <div class="form-group">
    <label for="balance"><?php get_phrase('opening_date') ?></label>
    <input type="text" class="form-control" name="date" id="date" readonly="true" />
  </div>
     
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
</form>
 <?php }else{ ?>




	<div class="panel-heading"><?php get_phrase('account_detail') ?></div>
    <div class="panel-body add-client">

    <form id="edit-accounts1">
  <input type="hidden" name="action" id="action" value="update"/>  
  <div class="form-group">
	<label for="acc_name"><?php get_phrase('member_id') ?></label>
    <input type="text" class="form-control text-readonly" name="member_id" id="member_id" value="<?php echo $edit_account->member_id ?>" readonly="true"/>
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control text-readonly" name="member_name" id="member_name" value="<?php echo $edit_account->member_name ?>" readonly="true">
  </div>
  <input type="text" name="b_account_type" id="b_account_type" hidden value='<?php echo $edit_account->bank_account_type?>'>
  <div class="form-group">
    <label for="acc_name" ><?php get_phrase('bank_account_type1') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <select class="form-control" id='bank_account_type' name='bank_account_type'>
    <option value=''>Select</option>
    <?php foreach($account_type as $accounts){?>
      <option value='<?php echo $accounts->tbl_id?>'><?php echo $accounts->account_name?></option>
     <?php }?>
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
    if(name==null){swal({title:'Member Not Found',text:'Add Member First'});}
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
if(data=="true"){  
sucessAlert("Saved Sucessfully"); 
window.scrollTo(0,1); 
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
