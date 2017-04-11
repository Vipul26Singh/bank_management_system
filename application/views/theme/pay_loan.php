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
<div class="alert alert-info"><p>  Take Loan Before Paying Emi's</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_add_income') ?></div>
    <div class="panel-body add-client">
 <form id="add-income">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trans_id" id="trans_id" value=""/>     
<div class="form-group">
    <label for="reference"><?php get_phrase('member_id') ?><span style="color:red">  *</span></label>
   <input type="number" class="form-control text-readonly" min="0" placeholder="Member Id" name="member_id" id="member_id">
  </div>
  <div class="form-group">
    <label for="reference"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="member_name" placeholder="Member Name" id="member_name" readonly="true">
  </div>
 <div class="form-group">
    <label for="reference"><?php get_phrase('loan_id') ?></label>
    <input type="text" class="form-control" name="loan_id" id="loan_id" readonly="true">
  </div>
  <div class="form-group">
    <label for="reference"><?php get_phrase('last_installment_pay') ?></label>
    <input type="text" class="form-control" name="last_installment_pay" id="last_installment_pay" placeholder="Last Installment Paid" readonly="true">
  </div>
  <div class="form-group">
    <label for="reference"><?php get_phrase('last_installment_pay_date') ?></label>
    <input type="text" class="form-control" name="last_installment_pay_date" id="last_installment_pay_date" placeholder="Last Installment Date" readonly="true">
  </div>       
                 
  <div class="form-group">
    <label for="amount"><?php get_phrase('amount') ?><span style="color:red">  *</span></label>
      <div class='input-group date'>
        <div class="input-group-addon"><?php echo get_current_setting('currency_code') ?></div>  
        <input type='number' name="amount" step="0.01" id="amount" placeholder="Amount" class="form-control" />
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
    <input type="text" class="form-control" name="cheque_no" placeholder="Cheque Number" id="cheque_no">
  </div> 
    <div class="form-group">
    <label for="reference"><?php get_phrase('reference_no') ?></label>
    <input type="text" class="form-control" name="reference" id="reference" readonly="true">
  </div>  
    <div class="form-group">
    <label for="reference"><?php get_phrase('account_balance') ?></label>
    <input type="text" class="form-control" name="account_balance" id="account_balance"  placeholder="Account Balance" readonly="true">
  </div>
 <!--  <div class="form-group">
    <label for="reference"><?php get_phrase('total_loan_amount') ?></label>
    <input type="text" class="form-control" name="loan_amount_left" id="loan_amount_left" readonly="true">
  </div> -->
    <div class="form-group">
    <label for="note"><?php get_phrase('note') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" name="note" id="note">
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


       <div class="col-md-7 col-lg-7 col-sm-7">
<!--Start Panel-->
<div class="panel panel-default" id="records_table">
    </div>   
    </div>
       <div class="col-md-7 col-lg-7 col-sm-7">
<!--Start Panel-->
<div class="panel panel-default" id="records_table1">
    </div>   
    </div>
 <div class="col-md-7 col-lg-7 col-sm-7">
<!--Start Panel-->
<div class="panel panel-default" id="records_table3">
    </div>   
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
  $('#today_date').val(moment().format('YYYY-MM-D'));
  $('#reference').val(Math.floor((Math.random() * 10000) ));

$("#account").select2();
$("#income-type").select2();
$("#payer").select2(); 
$("#p-method").select2();     
$("#date").datepicker();  

  $('#today_date').val(moment().format('YYYY-MM-D'));

$('#amount').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
});
$('#div1').hide();
$('#p-method').change(function(){var value = $('#p-method').val();
if(value=="CHEQUE"){$('#div1').show();}else{$('#div1').hide();}});
$('#member_id').change('input',function(e){
  var id = $("#member_id").val();
    var loan_id = $("#loan_id").val();
   var user_id = "<?php echo $this->session->userdata('user_id');?>";
  $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_balance')?>",
  data : {'member_id': id,'user_id':user_id},success : function (data) {
    var name = JSON.parse(data);
    if(data== 'null'){ $('#account_balance').val('');
    $('#member_name').val('');
    $('#last_installment_pay').val('');
    $('#last_installment_pay_date').val('');
  }
    $('#account_balance').val(name['account_balance']);
    $('#member_name').val(name['member_name']);
     $('#loan_amount_left').val(name['total_loan_amount_with_interest']);
    // $('#loan_id').val('');
    // $('#last_installment_pay').val('');
    // $('#last_installment_pay_date').val('');
  }
}),$.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_loan')?>",
  data : {'member_id': id,'user_id':user_id},success : function (data) {
    var data = JSON.parse(data);
    if(data==null){

    swal({
      title:"Take Loan First ",text:"You will have to Take loan before pay"})
    $('#last_installment_pay').val('');
    $('#last_installment_pay_date').val('');
  }
  if(data['loan_id']==null&&data['date']!=null){swal({
      title:"All Emis Paid ",text:"You will have to Take New loan before pay"})}
  else{
    $('#loan_id').val(data['loan_id']);
    $('#last_installment_pay').val(data['amount']);
    
    $('#last_installment_pay_date').val(data['date']);
    $('#loan_amount_left').val(data['total_loan_amount_with_interest']);}
  }
}),$.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_user_late_fee')?>",
  data : {'member_id': id,'user_id':user_id},success : function (data) {
    var data = JSON.parse(data);$('#records_table').html('')
   if(data==''){$('#records_table').html('');}
     //$('#records_table').html(data);
     else{
      $('#records_table').show();
      for(i=0;i<data.length;i++){
$('<table border style="width:500px">').html(
        "<thead> " +
        "<tr>" +
        "<th> <strong> Member Name </strong>  </th>" +
         "<th> <strong> Due Date </strong>  </th>" +
          "<th> <strong> Amount </strong>  </th>" +
          "<th> <strong> Late Fees Per Day </strong>  </th>" +
        "</tr> </thead>" +
        " <tbody>" +
        " <tr>" +
        "<td>" + data[i]['member_name'] + "</td>" +
        "<td>" + data[i]['date'] + "</td>" +
        "<td>" + data[i]['emi_amount'] + "</td>" +
        "<td>" + data[i]['late_fees'] + "</td>" +
       
        "</tr>" +
        "</tbody>" +
        "</table>"
        ).appendTo('#records_table');

}}
  }
}),$.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_user_last_emi')?>",
  data : {'member_id': id,'user_id':user_id},success : function (data) {
   var data = JSON.parse(data);$('#records_table1').html('');
   if(data==''){$('#records_table1').html('');}
    else{
   $('<table border style="width:500px">').html(
        "<thead> " +
        "<tr>" +
        "<th> <strong> Due Date </strong>  </th>" +
         "<th> <strong> Emi Amount </strong>  </th>" +
          "<th> <strong> Total Loan Amount </strong>  </th>" +
          "<th> <strong> Emi Left </strong>  </th>" +
           
        "</tr> </thead>" +
        " <tbody>" +
        " <tr>" +
        "<td>" + data[0]['date'] + "</td>" +
        "<td>" + data[0]['emi_amount'] + "</td>" +
        "<td>" + data[0]['total_loan_amount_with_interest'] + "</td>" +
        "<td>" + data[0]['emi_left'] + "</td>" +
       
        "</tr>" +
       
        "</tbody>" +
        "</table>"
        ).appendTo('#records_table1');
   }
  }
}),$.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_current_emi')?>",
  data : {'member_id': id,'user_id':user_id},success : function (data) {
    var data = JSON.parse(data);$('#records_table3').html('');
   
  }
});
  
});

        
$('#add-income').on('submit',function(event){ 
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/payLoan/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){  
if(data=="true"){  
document.body.scrollTop=0; 
sucessAlert("Saved Sucessfully"); 
window.scrollTo(0,1);
window.setTimeout(function(){location.reload()},1000)
$(".block-ui").css('display','none');
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

