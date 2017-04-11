<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_income') ?></h4></div>

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
    <div class="panel-heading"><?php get_phrase('panel_add_income') ?></div>
    <div class="panel-body add-client">
 <form id="add-income">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trans_id" id="trans_id" value=""/>     
 <div class="form-group">
    <label for="reference"><?php get_phrase('member_id') ?><span style='color:red'>  *</span></label>
   <input type="number" class="form-control text-readonly" min="0" placeholder="Member Id" name="member_id" id="member_id">
  </div>
  <div class="form-group">
    <label for="reference"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="member_name" placeholder="Member Name" id="member_name" readonly="true">
  </div>
        
  <!-- <div class="form-group"> 
    <label for="income-type"><?php get_phrase('income_type') ?></label>
    <select name="income-type" class="form-control" id="income-type"> 
     <?php foreach ($category as $cat) {?>
      <option value="<?php echo $cat->accounts_name ?>"><?php echo $cat->accounts_name ?></option>
      <?php } ?> 
    </select>      
  </div>        -->  
                 
  <div class="form-group">
    <label for="amount"><?php get_phrase('amount') ?><span style='color:red'>  *</span></label>
      <div class='input-group date'>
        <div class="input-group-addon"><?php echo get_current_setting('currency_code') ?></div>  
        <input type='number' step="0.01" name="amount" id="amount" placeholder="Amount" class="form-control" />
    </div>
  </div>

    <!-- <div class="form-group"> 
    <label for="payer"><?php get_phrase('payer') ?></label>
    <select name="payer" class="form-control" id="payer">  
    <?php foreach ($payers as $p) {?>
      <option value="<?php echo $p->payee_payers ?>"><?php echo $p->payee_payers ?></option>
    <?php } ?>   
    </select>      
  </div>   -->

    <div class="form-group"> 
    <label for="p-method"><?php get_phrase('payment_method') ?><span style='color:red'>  *</span></label>
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
    <label for="reference"><?php get_phrase('reference_no') ?></label>
    <input type="text" class="form-control" name="reference" id="reference">
  </div>  
    <div class="form-group">
    <label for="reference"><?php get_phrase('account_balance') ?><span style='color:red'>  *</span></label>
    <input type="text" class="form-control" name="account_balance" id="account_balance" readonly="true">
  </div>
    <div class="form-group">
    <label for="note"><?php get_phrase('note') ?><span style='color:red'>  *</span></label>
    <input type="text" class="form-control" name="note" placeholder="Note" id="note">
  </div>     
        
    <div class="form-group">
    <label for="note"><?php get_phrase('today_date') ?></label>
    <input type="text" class="form-control" name="today_date" id="today_date" readonly="true">
  </div>
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('submit') ?></button>
</form>
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel-->       
</div>
      
    
<!-- <div class="col-md-7 col-lg-7 col-sm-7">

<div class="panel panel-default">
    
    <div class="panel-heading"><?php get_phrase('panel_income') ?></div>
    <div class="panel-body">
       <table class="table table-striped table-bordered table-condensed income-table">
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
     
</div>   -->  
    

</div><!--End Inner container-->
</div><!--End Row-->
</div><!--End Main-content DIV-->
</section><!--End Main-content Section-->



<script type="text/javascript">
$(document).ready(function() {
$(".asyn-income").addClass("active-menu"); 
$("#account").select2();
$("#income-type").select2();
$("#payer").select2(); 
$("#p-method").select2();     
$("#date").datepicker();  
 $('#today_date').val(moment().format('YYYY-MM-D'));
  $('#reference').val(Math.floor((Math.random() * 10000) ));
$('#amount').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)||event.which ==13) { event.preventDefault(); 
  } 
});
$('#div1').hide();
$('#p-method').change(function(){var value = $('#p-method').val();
if(value=="CHEQUE"){$('#div1').show();}else{$('#div1').hide();}});
$('#member_id').change('input',function(e){
  var id = $("#member_id").val();
   var user_id = "<?php echo $this->session->userdata('user_id');?>";
  $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_balance')?>",
  data : {'member_id': id,'user_id':user_id},success : function (data) {
    if(data=='null'){ 
  $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_user')?>",
  data : {'id': id},success : function (data) {
    var name = JSON.parse(data);
     if(name==null){swal({title:'Member Not Found',text:'Add Member First'});}
    $('#member_name').val(name['member_name']);
     $('#account_balance').val('');
  }
});}
      else{
    var name = JSON.parse(data);
    $('#member_name').val(name['member_name']);
    $('#account_balance').val(name['account_balance']);
  }}
});});

$('#add-income').on('submit',function(event){ 
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/addIncome/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
},success : function(data){  
if(data=="true"){   
sucessAlert("Saved Sucessfully"); 
$(".block-ui").css('display','none');
window.scrollTo(0,1);
window.setTimeout(function(){location.reload()},1000) 
appendRow();
$('#add-income')[0].reset(); 
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
$(".income-table tr:first").after("<tr><td>"+$("#note").val()+"</td><td class='text-right'>"+currency+" "+$("#amount").val()+"</td></tr>"); 

}
   
});

</script>

