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
<div class="alert alert-info"><p>Withdraw Charges From all Accounts </p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
  
<div class="panel-heading"><?php get_phrase('withdraw_all') ?></div>
    <div class="panel-body add-client">
    <form id="add-accounts">
  <input type="hidden" name="action" id="action" value="withdraw"/>  
 <input type="hidden" name="chart_id" id="accounts_id" value=""/>    
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('service_name') ?><span style="color:red">  *</span></label>
     <select class="form-control text-readonly" id="service_name" name="service_name">
    <option value=''>Select</option>
    <?php foreach($services as $list){ ?>
      <option value='<?php echo $list->tbl_id?>'><?php echo $list->service_name?></option>
     
      <?php }?>
    </select>
  </div>
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('service_amount') ?></label>
    <input type="text" class="form-control text-readonly" name="service_amount" id="service_amount" readonly="true">
  </div>
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('withdraw') ?></button>
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
$(document).ready(function(){

if($(".sidebar").width()=="0"){
$(".main-content").css("padding-left","0px");
} 
  
  $('#balance').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
  });

$('#service_name').on('change',function(){
  var service_id = $('#service_name').val();
   $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/get_service_by_id')?>",
  data : {'id': service_id},success : function (data) {
    var name = JSON.parse(data);
    $('#service_amount').val(name['service_amount']);
  }
});
});
$('#add-accounts').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/withdrawAll/withdraw') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){  
sucessAlert("Saved Sucessfully"); 
window.setTimeout(function(){location.reload()},1000)
$(".block-ui").css('display','none'); 
if($("#action").val()!='update'){        
$('#acc_name').val("");
$("#balance").val("");
$('#note').val("");     
}
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
