<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_expense') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-md-5 col-lg-5 col-sm-5">
<!--Start Panel-->
<div class="alert alert-info"><p>  Create Account First Then Perform Action</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('withdraw') ?></div>
    <div class="panel-body add-client">
    <form id="add-expense">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trans_id" id="trans_id" value=""/>       
 <!-- <div class="form-group"> 
    <label for="account"><?php get_phrase('account_name') ?></label>
    <select name="account" class="form-control" id="account">  
    <?php foreach ($accounts as $account) {?>
    <option value="<?php echo $account->member_id ?>"><?php echo $account->member_name ?></option>
    <?php } ?>  
    </select>      
  </div> --> 
  <div class="form-group">
    <label for="reference"><?php get_phrase('member_id') ?><span style="color:red">  *</span></label>
    <input type="number" class="form-control text-readonly" min="0" placeholder="Member Id" name="member_id" id="member_id">
  </div>
  <div class="form-group">
    <label for="reference"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="member_name" placeholder="Member Name" id="member_name">
  </div>

 <!--  <div class="form-group"> 
    <label for="expense-type"><?php get_phrase('expense_type') ?><span style="color:red">  *</span></label>
    <select name="expense-type" class="form-control" id="expense-type"> 
      <?php foreach ($category as $cat) {?>
      <option value="<?php echo $cat->accounts_name ?>"><?php echo $cat->accounts_name ?></option>
      <?php } ?>  
    </select>      
  </div>       -->   
                 
  <div class="form-group">
    <label for="amount"><?php get_phrase('amount') ?><span style="color:red">  *</span></label>
      <div class='input-group date'>
        <div class="input-group-addon"><?php echo get_current_setting('currency_code') ?></div>  
        <input type='text' name="amount" id="amount" placeholder="Amount" class="form-control" />
    </div>
  </div>

   <!--  <div class="form-group"> 
    <label for="payee"><?php get_phrase('payee') ?></label>
    <select name="payee" class="form-control" id="payee">  
    <?php foreach ($payee as $p) {?>
      <option value="<?php echo $p->payee_payers ?>"><?php echo $p->payee_payers ?></option>
    <?php } ?>    
    </select>      
  </div>  --> 

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
    <input type="text" class="form-control" name="cheque_no" placeholder="Cheque Number" id="cheque_no">
  </div> 
<div class="form-group">
    <label for="reference"><?php get_phrase('account_balance') ?></label>
    <input type="text" class="form-control" name="account_balance" placeholder="Account Balance" id="account_balance" readonly="true">
  </div>
    <div class="form-group">
    <label for="reference"><?php get_phrase('reference_no') ?></label>
    <input type="text" class="form-control" name="reference" id="reference">
  </div>  
    
    <div class="form-group">
    <label for="note"><?php get_phrase('note') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" name="note" placeholder="Note" id="note">
  </div>     
    <div class="form-group">
    <label for="note"><?php get_phrase('today_date') ?></label>
    <input type="text" class="form-control" name="today_date" id="today_date" readonly>
  </div>     
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('submit') ?></button>
</form>
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel-->       
</div>
    
<!-- Start Table Section-->    
    
<!-- <div class="col-md-7 col-lg-7 col-sm-7">

<div class="panel panel-default">
 
    <div class="panel-heading"><?php get_phrase('panel_expense') ?></div>
    <div class="panel-body">
       <table class="table table-striped table-bordered table-condensed expense-table">
        <th><?php get_phrase('description') ?></th><th class="text-right"><?php get_phrase('amount') ?></th>
       
        <?php foreach($t_data as $t) {?>
        <tr>
        <td><?php echo $t->note ?></td>
        <td class="text-right"><?php echo get_current_setting('currency_code')." ".$t->amount ?></td>    
        </tr>
        <?php } ?>   

        </table>
    </div>
   
</div>
</div>  -->   
    

</div><!--End Inner container-->
</div><!--End Row-->
</div><!--End Main-content DIV-->
</section><!--End Main-content Section-->


<script type="text/javascript">
$(document).ready(function() {
 $('#today_date').val(moment().format('YYYY-MM-D'));
 $('#reference').val(Math.floor((Math.random() * 10000) ));
$(".asyn-expense").addClass("active-menu"); 
$("#account").select2();
$("#expense-type").select2();
$("#payee").select2(); 
$("#p-method").select2();     
$("#date").datepicker();  

$('#amount').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
});
// $('#account').change(function(){
//   var account = $("#account").val();
//   $.ajax({
// method : "POST",
// url : "<?php echo site_url('Admin/get_description') ?>",
// data : {id:account},success:function(data){
//   data;
// }
// });
// });
$('#div1').hide();
$('#p-method').change(function(){var value = $('#p-method').val();
if(value=="CHEQUE"){$('#div1').show();}else{$('#div1').hide();}});
$('#member_id').change('input',function(e){ 
  $('#today_date').val(moment().format('YYYY-MM-D'));
  $('#reference').val(Math.floor((Math.random() * 10000) ));
  var id = $("#member_id").val();
   var user_id = "<?php echo $this->session->userdata('user_id');?>";
  $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_balance')?>",
  data : {'member_id': id,'user_id':user_id},success : function (data) {
    var name = JSON.parse(data);
     if(name==null){swal({title:'Member Not Found',text:'Add Member First'});}
    $('#member_name').val(name['member_name']);
    $('#account_balance').val(name['account_balance']);
  }
});});
$('#add-expense').on('submit',function(event){ 
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/addExpense/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){  
if(data=="true"){   
sucessAlert("Saved Sucessfully");
window.scrollTo(0,1);
window.setTimeout(function(){location.reload()},1000)
$(".block-ui").css('display','none');
appendRow();
$('#add-expense')[0].reset(); 
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

function appendRow(){
var currency="<?php echo get_current_setting('currency_code') ?>";   
$(".expense-table tr:first").after("<tr><td>"+$("#note").val()+"</td><td class='text-right'>"+currency+" "+$("#amount").val()+"</td></tr>"); 

}   
   

});

</script>

