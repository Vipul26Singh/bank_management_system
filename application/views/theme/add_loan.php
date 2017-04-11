<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('take_loan') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->

 <?php if(!isset($edit_account)){ ?>  
    <form id="add-accounts">
  <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="chart_id" id="accounts_id" value=""/>    
<div class="col-md-6">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('take_loan') ?></div>
    <div class="panel-body add-client">
   
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_id') ?><span style="color:red">*</span></label>
   <input type="number" class="form-control text-readonly" min="0" placeholder="Member Id" name="member_id" id="member_id">
  </div>
 <!--  <div class="form-group">
    <label for="balance"><?php get_phrase('account_balance') ?></label>
    <input type="text" class="form-control" name="opening_balance" id="balance">
  </div>
   <div class="form-group">
    <label for="note"><?php get_phrase('note') ?></label>
    <input type="text" class="form-control" name="note" id="note">
  </div> -->    
        <div class="form-group">
    <label for="balance"><?php get_phrase('enter_introducer_1_id') ?><span style="color:red">*</span></label>
    <input type="text" class="form-control" name="enter_introducer_1_id" placeholder="Introducer 1 Id" id="enter_introducer_1_id">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('Introducer 1 Name') ?></label>
    <input type="text" class="form-control" name="introducer_1_name" id="introducer_1_name" readonly="true" style="background-color:#eeeeee;">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('introducer_1_bankAccount_balance') ?></label>
    <input type="text" class="form-control" name="introducer_1_bankAccount_balance" id="introducer_1_bankAccount_balance" readonly="true" style="background-color:#eeeeee;">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('introducer_1_share') ?></label>
    <input type="number" class="form-control" name="introducer_1_share" id="introducer_1_share" readonly="true" style="background-color:#eeeeee;">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('loan_amount') ?><span style="color:red">*</span></label>
    <input type="number" class="form-control" name="loan_amount" placeholder="Loan Amount" id="loan_amount" min="0">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('year') ?><span style="color:red">*</span></label>
    <input type="numb" class="form-control" placeholder="Duration" min='0' name="year" id="year">
  </div>
  <!-- <div class="form-group">
    <label for="balance"><?php get_phrase('loan_duration') ?><span style="color:red">*</span></label>
    <input type="number" class="form-control" name="loan_duration" id="loan_duration">
  </div> -->
  <div class="form-group">
    <label for="balance"><?php get_phrase('remark_if_any') ?></label>
    <input type="text" class="form-control" name="remark" placeholder="Remark" id="remark">
  </div>
  </div></div>
  </div>
  <div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-body add-client">  
  <div class="form-group">
    <label for="balance"><?php get_phrase('member_name') ?></label>
    <input type="email" class="form-control" name="member_name" id="member_name" readonly="true" style="background-color:#eeeeee;">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('enter_introducer_2_id') ?><span style="color:red">*</span></label>
    <input type="text" class="form-control" name="enter_introducer_2_id" placeholder="Introducer 2 Id" id="enter_introducer_2_id">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('introducer_2_name') ?></label>
    <input type="text" class="form-control" name="introducer_2_name" id="introducer_2_name" readonly="true" style="background-color:#eeeeee;">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('introducer_2_bankAccount_balance') ?></label>
    <input type="text" class="form-control" name="introducer_2_bankAccount_balance" id="introducer_2_bankAccount_balance" readonly="true" style="background-color:#eeeeee;">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('introducer_2_share') ?></label>
    <input type="number" class="form-control" name="introducer_2_share" id="introducer_2_share" readonly="true" style="background-color:#eeeeee;">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('select_loan_type') ?><span style="color:red">*</span></label>
    <select class="form-control" name="select_loan_type" id="select_loan_type">
    <option value="">Select</option>
    <?php foreach($data as $value){?>
      
       <option value="<?php echo $value['value']?>"><?php echo get_phrase($value['name'])?></option>
      <?php }?>
    </select>
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('Monthly_Emi') ?></label>
    <input type="number" class="form-control" name="emi" id="emi" readonly="true" style="background-color:#eeeeee;">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('total_amount_with_interest') ?></label>
    <input type="number" class="form-control" name="total_loan_amount" id="total_loan_amount" readonly="true" style="background-color:#eeeeee;">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('interest') ?></label>
    <input type="number" class="form-control" name="interest" id="interest" readonly="true" style="background-color:#eeeeee;">
  </div>
    <div class="form-group">
    <label for="balance"><?php get_phrase('active_by') ?><span style="color:red">*</span></label>
    <select name="active_by" class="form-control" id="active_by">
      <option value="">Select</option>
       <option value="<?php echo $this->session->userdata('user_id')?>"><?php echo $this->session->userdata('username')?></option>
    </select>
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('date') ?></label>
    <input type="text" class="form-control" name="date" id="date" style="background-color:#eeeeee;" readonly="true">
  </div>
   
<br>
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button></div></div>
</form>
 <?php }else{ ?>

    <form id="add-accounts">
  <input type="hidden" name="action" id="action" value="update"/>  
 <input type="hidden" name="accounts_id" id="accounts_id" value="<?php echo $edit_account->accounts_id ?>"/>    
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('account_name') ?></label>
    <input type="text" class="form-control" name="accounts_name" value="<?php echo $edit_account->accounts_name ?>" id="accounts_name">
  </div>

   <div class="form-group">
    <label for="note"><?php get_phrase('note') ?></label>
    <input type="text" class="form-control" value="<?php echo $edit_account->note ?>" name="note" id="note">
  </div>    
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('submit') ?></button>
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
if($(".sidebar").width()=="0"){
$(".main-content").css("padding-left","0px");
} 
  $('#balance').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
  });
  $('#date').val(moment().format('YYYY-MM-DD'));
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
});
});
  $('#enter_introducer_1_id').change('input',function(e){
  var id = $("#enter_introducer_1_id").val();
  $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_introducer')?>",
  data : {'id': id},success : function (data) {
    if(data=='null'){
    $('#introducer_1_name').val('');
    $('#introducer_1_bankAccount_balance').val('');
    $('#introducer_1_share').val('');}
    else{var data = JSON.parse(data);
    $('#introducer_1_name').val(data['member_name']);
    $('#introducer_1_bankAccount_balance').val(data['account_balance']);
    $('#introducer_1_share').val(data['share_amount']);
  }}
});
});
   $('#enter_introducer_2_id').change('input',function(e){
  var id = $("#enter_introducer_2_id").val();
  $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_introducer')?>",
  data : {'id': id},success : function (data) {
     if(data=='null'){
    $('#introducer_2_name').val('');
    $('#introducer_2_bankAccount_balance').val('');
    $('#introducer_2_share').val('');}
    
    else{var data = JSON.parse(data);
    $('#introducer_2_name').val(data['member_name']);
    $('#introducer_2_bankAccount_balance').val(data['account_balance']);
    $('#introducer_2_share').val(data['share_amount']);
  }}
});
});
 $('#duration_in_days').on('input',function(){
  var duration = $("#loan_duration").val();
});
$('#loan_amount').on('input',function(e){
 var loan_amount = $("#loan_amount").val();
  var select_loan_type = $("#select_loan_type").val();
  var interest = $("#select_loan_type").val();
  $('#interest').val(interest);
  var rate = interest/100;
  var loan_amount = $("#loan_amount").val();
  var year = $("#year").val();
  var rate = select_loan_type/1200;
  var N = year*12;
    emi = rate*loan_amount / (1-Math.pow((1 + rate),-N));
       $('#emi').val(emi);
       $('#total_loan_amount').val(emi*N);
});
$('#year').on('input',function(e){
 var loan_amount = $("#loan_amount").val();
  var select_loan_type = $("#select_loan_type").val();
  var interest = $("#select_loan_type").val();
  $('#interest').val(interest);
  var rate = interest/100;
  var loan_amount = $("#loan_amount").val();
  var year = $("#year").val();
  var rate = select_loan_type/1200;
  var N = year*12;
    emi = rate*loan_amount / (1-Math.pow((1 + rate),-N));
       $('#emi').val(emi);
       $('#total_loan_amount').val(emi*N);
});
 $('#select_loan_type').on('input',function(e){
  var loan_amount = $("#loan_amount").val();
  var select_loan_type = $("#select_loan_type").val();
  var interest = $("#select_loan_type").val();
  $('#interest').val(interest);
  var rate = interest/100;
  var loan_amount = $("#loan_amount").val();
  var year = $("#year").val();
  var rate = select_loan_type/1200;
  var N = year*12;
    emi = rate*loan_amount / (1-Math.pow((1 + rate),-N));
       $('#emi').val(emi);
       $('#total_loan_amount').val(emi*N);
});
$('#add-accounts').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/add_bank_loan/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){  
 window.scrollTo(0,1);
sucessAlert("Saved Sucessfully"); 
$(".block-ui").css('display','none'); 
if($("#action").val()!='update'){ 
   $('#introducer_1_name').val('');
    $('#introducer_1_bankAccount_balance').val('');
     $('#introducer_1_share').val('');       
      $('#introducer_2_name').val('');
       $('#introducer_2_bankAccount_balance').val('');
        $('#introducer_2_share').val(''); 
        window.setTimeout(function(){location.reload()},1000)
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