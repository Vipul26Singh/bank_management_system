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
<div class="alert alert-info"><p>  Withdraw Fixed Deposit</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <?php if(!isset($edit_account)){ ?>  
<div class="panel-heading"><?php get_phrase('add_account') ?></div>
    <div class="panel-body add-client">
    <form id="add-accounts">
  <input type="hidden" name="action" id="action" value="take"/>  
 <input type="hidden" name="chart_id" id="accounts_id" value=""/>    
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_id') ?><span style="color:red">  *</span></label>
    <input type="number" class="form-control text-readonly" min="0" placeholder="Member Id" name="member_id" id="member_id">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control text-readonly" name="member_name" placeholder="Member Name" id="member_name" readonly="true">
  </div>
  <div class="form-group">
   
    <input type="text" hidden="true" name="fd_id"  id="fd_id">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('fixed_deposit_amount') ?></label>
    <input type="text" class="form-control" name="fixed_deposit_amount" id="fixed_deposit_amount"  placeholder="Fixed Deposit Amount " readonly="true">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('maturity_amount') ?></label>
    <input type="text" class="form-control" name="maturity_amount" id="maturity_amount" placeholder="Maturity Amount " readonly="true">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('maturity_date') ?></label>
    <input type="text" class="form-control" name="maturity_date" id="maturity_date" placeholder="Maturity Date" readonly="true">
  </div>
  <input type="text" name="duration" id="duration" hidden="true">
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('interest') ?></label>
    <input type="text" class="form-control" name="interest" id="interest" placeholder="Interest" readonly="true">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('taken_on') ?></label>
    <input type="text" class="form-control" name="taken_on" id="taken_on" placeholder="Taken On" readonly="true">
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
 <!--  <div class="form-group">
    <label for="balance"><?php get_phrase('services') ?></label>
    <select class="form-control" name="services" id="services">
        <option value=''>Select</option>
        <?php foreach($services as $service){?>
        <option value="<?php echo $service->tbl_id;?>"><?php echo $service->service_name;?></option>
        <?php }?>
    </select>
  </div> -->
     
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('take') ?></button>
</form>
 <?php }else{ ?>
	<div class="panel-heading"><?php get_phrase('account_detail') ?></div>
    <div class="panel-body add-client">
    <form id="add-accounts1" method ='POST' action="<?php echo base_url();?>Admin/addAccount/update">
  <input type="hidden" name="action" id="action" value="update"/>  
  <div class="form-group">
	<label for="acc_name"><?php get_phrase('member_id') ?></label>
    <input type="text" class="form-control text-readonly" name="member_id" id="member_id" value="<?php echo $edit_account->member_id ?>" readonly="true"/>
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control text-readonly" name="member_name" id="member_name" value="<?php echo $edit_account->member_name ?>" readonly="true">
  </div>
  <div class="form-group">
    <label for="acc_name" ><?php get_phrase('bank_account_type') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <select class="form-control" id='bank_account_type' name='bank_account_type'>
    <option value=''>Select</option>
    <?php foreach($account_type as $accounts){?>
      <option value='<?php echo $accounts->tbl_id?>'><?php echo $accounts->account_name?></option>
     <?php }?>
    </select>
   <!--  <input type="text" class="form-control text-readonly" name="bank_account_type" id="bank_account_type" value="<?php if($edit_account->bank_account_type == '1') echo 'Current'; else if($edit_account->bank_account_type == '2') echo 'Savings'; else echo 'Yikes contact technical support'; ?>"  /> -->
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('bank_account_number') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="text" class="form-control text-readonly" name="bank_account_number" id="bank_account_number" value="<?php echo $edit_account->bank_account_number ?>">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('share account id') ?></label>
    <input type="number" class="form-control text-readonly" name="share" id="share" value="<?php echo $edit_account->share_id ?>" readonly="true" />
  </div>
	<div class="form-group">
    <label for="balance"><?php get_phrase('account_balance') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="number" class="form-control" name="account_balance" id="account_balance" placeholder="Enter Amount" value="<?php echo $edit_account->account_balance ?>" />
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('opening_date') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="number" class="form-control" name="account_balance" id="account_balance" placeholder="Enter Amount" value="<?php echo $edit_account->opening_date ?>" />
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
  url : "<?php echo site_url('Admin/get_user_fd')?>",
  data : {'id': id},success : function (data) {
    var name = JSON.parse(data);
    if(name==null){swal({title:'Member Not Found',text:'Take Fd First'});}
    $('#member_name').val(name['member_name']);
    $('#fd_id').val(name['fd_id']);
    $('#fixed_deposit_amount').val(name['fixed_deposit_amount']);
     $('#duration').val(name['duration']);
     $('#maturity_amount').val(name['maturity_amount']);
      $('#maturity_date').val(name['maturity_date']);
      $('#interest').val(name['interest']);
      $('#taken_on').val(name['date']);
       $('#fd_id').val(name['fd_id']);
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
url : "<?php echo site_url('Admin/take_fixed_deposit/take') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){  
sucessAlert("Fixed Deposit Taken Succefully"); 
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
