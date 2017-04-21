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


<div class="col-md-9 col-lg-9 col-sm-9 ">
<!--Start Panel-->
<div class="alert alert-info"><p>Create Account First Then Perform Action</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('add_account') ?></div>
    <div class="panel-body add-client ">
    <?php if(!isset($edit_account)){ ?>  
    <form id="add-accounts">
  <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="chart_id" id="accounts_id" value=""/>    
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_id') ?><span style="color:red">  *</span></label>
    <input type="number" class="form-control text-readonly" min="0" name="member_id" placeholder="Member Id" id="member_id">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" style="background-color: #eeeeee" name="member_name" id="member_name" readonly="true">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('fixed_deposit_amount') ?><span style="color:red">  *</span></label>
    <input type="number" class="form-control" name="fixed_deposit_amount"placeholder="Fixed Deposit Amount" id="fixed_deposit_amount" min="0">
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('duration_in_years') ?><span style="color:red">  *</span></label>
    <select class="form-control" name="duration1" id="duration1">
      <option value=''>Select</option>
     <?php foreach ($duration as $method) {?>
      <option value='<?php echo $method['fd_id'] ?>'><?php echo $method['fd_name'] ?></option>
      
    <?php } ?>

    </select>
  </div>
  <input type="text" hidden="true" name="duration" id="duration">
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('maturity_date') ?></label>
    <input type="text" class="form-control" style="background-color: #eeeeee" name="maturity_date" id="maturity_date" readonly="true">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('maturity_amount') ?></label>
    <input type="number" class="form-control" style="background-color: #eeeeee" name="maturity_amount" id="maturity_amount" readonly="true">
  </div>
   <div class="form-group">
    <label for="acc_name"><?php get_phrase('interest_rate') ?></label>
    <input type="text" class="form-control" name="interest" id="interest" readonly="true">
  </div>
      <div class="form-group">
    <label for="balance"><?php get_phrase('active_by') ?><span style="color:red">  *</span></label>
    <select name="active_by" class="form-control" id="active_by">
      <option value="">Select</option>
       <option value="<?php echo $this->session->userdata('user_id')?>"><?php echo $this->session->userdata('username')?></option>
    </select>
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('date') ?></label>
    <input type="text" class="form-control" style="background-color: #eeeeee" name="date" id="date" readonly="true">
  </div>
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('add_fixed_deposit') ?></button>
</form>
 <?php }else{ ?>

    <form id="add-accounts">
   
 <input type="hidden" name="accounts_id" id="accounts_id" value="<?php echo $edit_account->accounts_id ?>"/>    
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('account_name') ?></label>
    <input type="text" class="form-control" name="accounts_name" value="<?php echo $edit_account->accounts_name ?>" id="accounts_name">
  </div>

   <div class="form-group">
    <label for="note"><?php get_phrase('note') ?></label>
    <input type="text" class="form-control" value="<?php echo $edit_account->note ?>" name="note" id="note">
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
$('#duration1').select2();
if($(".sidebar").width()=="0"){
$(".main-content").css("padding-left","0px");
} 
$('#date').val(moment().format('YYYY-MM-D'));
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
  $('#duration1').change(function(){
    var interest;
var duration;
    var fd_id = $('#duration1').val();
    $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/getFd')?>",
  data : {'fd_id': fd_id},success : function (data) {
var name = JSON.parse(data);
if(data== 'null'){ $('#interest').val('');
    $('#duration').val('');
    $('#maturity_amount').val('');
    $('#maturity_date').val('')
    }
    var interest = name['fd_interest'];
    $('#interest').val(name['fd_interest']);
    $('#duration').val(name['fd_duration']);
    var duration = name['fd_duration'];
   var fixed_deposit_amount = $("#fixed_deposit_amount").val();
     ci = fixed_deposit_amount * Math.pow((1 + (interest/100)/4 ),duration*4);
       $('#maturity_amount').val(ci);
   var date = new Date(Date.now()+duration*24*60*60*1000*365);
$('#maturity_date').val((date.getFullYear()) + '-' + (date.getMonth()+1) + '-' + (date.getDate()));
  }
});
});

  
  $('#balance').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
  });


$('#add-accounts').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/add_fixed_deposit/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){  
sucessAlert("Saved Sucessfully"); 
window.scrollTo(0,1);
$(".block-ui").css('display','none'); 
if($("#action").val()!='update'){     
 $('#member_name').val('');   
$('#maturity_date').val("");
$("#interest").val("");
$('#member_id').val("");     
$('#fixed_deposit_amount').val("");
$("#interest").val("");
$("#maturity_amount").val("");
$('#active_by').val(""); 
$('#duration1').val("");   
window.setTimeout(function(){location.reload()},1000) 
}
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
