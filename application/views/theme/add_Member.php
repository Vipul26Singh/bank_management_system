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

 <?php if(!isset($edit_account)){ ?>  
    <form id="add-accounts">
  <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="chart_id" id="accounts_id" value=""/> 
<div class="col-md-6">
<!--Start Panel-->
<div class="alert alert-info"><p>Create Account After Creating Member</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('add_member') ?></div>
    <div class="panel-body add-client">
      
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?><span style="color:red">  *</span></label>
   <input type="text" class="form-control text-readonly" min="0" placeholder="Member Name" name="member_name" id="member_name">
  </div>
 <!--  <div class="form-group">
    <label for="balance"><?php get_phrase('account_balance') ?></label>
    <input type="text" class="form-control" name="opening_balance" id="balance">
  </div>
   <div class="form-group">
    <label for="note"><?php get_phrase('note') ?></label>
    <input type="text" class="form-control" name="note" id="note">
  </div> -->   
 <div class="form-group" style="vertical-align:middle">
     <label for="balance" ><?php get_phrase('Select Gender') ?><span style="color:red">  *</span></label><br>
     <input TYPE="Radio" Name="Gender" style="vertical-align:middle" Value="M"><span>Male</span>
     <input TYPE="Radio" Name="Gender" style="vertical-align:middle" Value="F"><span>Female </span>
     <input TYPE="Radio" Name="Gender" style="vertical-align:middle" Value="O"><span>other</span> 

</div>
        <div class="form-group">
    <label for="balance"><?php get_phrase('residential_address') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" name="residential_address" placeholder="Residential Address" id="residential_address">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('office_address') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" name="office_address" placeholder="Office Address" id="office_address">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('city') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" placeholder="City" name="city" id="city">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('pincode') ?><span style="color:red">  *</span></label>
    <input type="number" class="form-control" name="pincode" placeholder="Pincode" id="pincode" min="0">
  </div>
 <div id="pincode_len"><span style="color:red">Please Enter Valid 6 Pincode.</span></div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('mobile_no') ?><span style="color:red">  *</span></label>
    <input type="number" class="form-control" name="mobile_no" placeholder="Mobile Number" id="mobile_no" min="0">
  </div>
 <div id="mobile_no_div"><span style="color:red">Please Enter Valid 10 Digit Mobile NO.</span></div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('state') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" name="state" placeholder="State" id="state">
  </div>
   </div></div>
  </div>
  <div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-body add-client">
  <div class="form-group">
    <label for="balance"><?php get_phrase('email_id') ?><span style="color:red">  *</span></label>
    <input type="email" class="form-control" name="email_id" placeholder="Email Address" id="email_id">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('photoidentity_type') ?><span style="color:red">  *</span></label>
    <select class="form-control" name="photoidentity_type" id="photoidentity_type">
    <option value="">Select</option>
      <?php foreach($photo_identity as $identity){?>
      <option value="<?php echo $identity->tbl_id?>"><?php echo $identity->name?></option><?php }?></select>
    </select>
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('photoidentity_number') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" name="photoidentity_number" placeholder="PhotoIdentity Number" id="photoidentity_number">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('birth_date') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" name="birth_date" id="birth_date" placeholder="<?php echo Date('Y-m-d')?>">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('age') ?></label>
    <input type="text" class="form-control" name="age" id="age" min="0" readonly="true">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('pancard_number') ?><span style="color:red">  *</span></label>
    <input type="text" class="form-control" name="pancard_number" placeholder="Pancard Number" id="pancard_number">
  </div>
    <div class="form-group">
    <label for="balance"><?php get_phrase('active_by') ?><span style="color:red">  *</span></label>
    <select name="active_by" class="form-control" id="active_by">
      <option value="<?php echo $this->session->userdata('user_id')?>"><?php echo $this->session->userdata('username')?></option>
    </select>
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('date') ?></label>
    <input type="text" class="form-control" name="date" id="date" readonly="true">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('id_card_image') ?><span style="color:red"></span></label><br>
    <input type="file" name="id_card_image" id="id_card_image">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('member_image') ?><span style="color:red"></span></label><br>
    <input type="file"  name="member_image" id="member_image">
  </div>
<br>
  <button  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
</div></div></form>
 <?php }else{ ?>

   <form id="edit-accounts1" enctype="multipart/form-data">
  <input type="hidden" name="action" id="action" value="update"/> 
<div class="col-md-6">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('add_member') ?></div>
    <div class="panel-body add-client">
     
	<div class="form-group">
    <label for="mem_id"><?php get_phrase('member_id') ?>  </label>
    <input type="text" class="form-control" name="member_id" id="member_id" value="<?php echo $edit_account->member_id ?>" readonly="true">
  </div>
 
  <div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="text" class="form-control" name="member_name" id="member_name" value="<?php echo $edit_account->member_name ?>">
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
    <label for="balance"><?php get_phrase('residential_address') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="text" class="form-control" name="residential_address" id="residential_address" value="<?php echo $edit_account->residential_address ?>">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('office_address') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="text" class="form-control" name="office_address" id="office_address" value="<?php echo $edit_account->office_address ?>">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('city') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="text" class="form-control" name="city" id="city" value="<?php echo $edit_account->city ?>">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('pincode') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="number" class="form-control" name="pincode" id="pincode" min="0" value="<?php echo $edit_account->pincode ?>">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('mobile_no') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="number" class="form-control" name="mobile_no" id="mobile_no" min="0" value="<?php echo $edit_account->mobile_no ?>">
  </div>
 <div id="mobile_no_div" ><span style="color:red">Please Enter Valid 10 Digit Mobile NO.</span></div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('state') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="text" class="form-control" name="state" id="state" value="<?php echo $edit_account->state ?>">
  </div>
   </div></div>
  </div>
  <div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-body add-client">
  <div class="form-group">
    <label for="balance"><?php get_phrase('email_id') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="email" class="form-control" name="email_id" id="email_id" value="<?php echo $edit_account->email_id ?>">
  </div>
   <input type="text" name="identity" id="identity" hidden value='<?php echo $edit_account->photoIdentity_type?>'>
  <div class="form-group">
    <label for="balance"><?php get_phrase('photoidentity_type') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <select class="form-control" name="photoidentity_type" id="photoidentity_type" >
    <option value="">Select</option>
      <?php foreach($photo_identity as $identity){?>
      <option value="<?php echo $identity->tbl_id?>"><?php echo $identity->name?></option><?php }?></select>
    </select>
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('photoidentity_number') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="text" class="form-control" name="photoidentity_number" id="photoidentity_number" value="<?php echo $edit_account->photoIdentity_number ?>">
  </div>
  <div class="form-group">
    <label for="balance"><?php get_phrase('birth_date') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="text" class="form-control" name="birth_date" id="birth_date" placeholder="<?php echo Date('Y-m-d')?>" value="<?php echo $edit_account->birth_date ?>">
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('age') ?></label>
    <input type="text" class="form-control" name="age" id="age" min="0" readonly="true" >
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('pancard_number') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <input type="text" class="form-control" name="pancard_number" id="pancard_number" value="<?php echo $edit_account->pancard_number ?>">
  </div>
    <div class="form-group">
    <label for="balance"><?php get_phrase('active_by') ?>     <span class="glyphicon glyphicon-pencil" style="color:red"></span></label>
    <select name="active_by" class="form-control" id="active_by" >
      <option value="">Select</option>
      <option value="<?php echo $this->session->userdata('user_id')?>"><?php echo $this->session->userdata('username')?></option>
    </select>
     <input type="text" hidden="true" name="active_by1" id="active_by1" value="<?php echo $edit_account->active_by?>"  />
  </div>
   <div class="form-group">
    <label for="balance"><?php get_phrase('date') ?></label>
    <input type="text" class="form-control" name="date" id="date" readonly="true" value="<?php echo $edit_account->opening_date ?>">
  </div>

	<div class="form-group">
    <label for="member_image"><?php get_phrase('member_photo') ?></label>
	<img src="<?php echo base_url($edit_account->member_photo); ?> " width="90" height="40" onerror="this.src='<?php echo base_url('uploads/default.png'); ?>'"/>
	<div>

	<div class="form-group">
    <label for="id_image"><?php get_phrase('id_image') ?></label>
        <img src="<?php echo base_url($edit_account->id_card_image); ?> " width="90" height="40" onerror="this.src='<?php echo base_url('uploads/default.png'); ?>'"/>
	<div>
<br>
  <button  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
</div></div></form>

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
$("#birth_date").datepicker(); 
if($(".sidebar").width()=="0"){
$(".main-content").css("padding-left","0px");
} 

$('#active_by').val($('#active_by1').val());  
var identity = $('#identity').val();
$('#photoidentity_type').val(identity);
  $('#balance').keypress(function(event) { 
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && 
    (event.which < 48 || event.which > 57)) { event.preventDefault(); 
  } 
  });
   $('#mobile_no_div').hide();
  $('#mobile_no').on('input',function(){  
       var mobile = $('#mobile_no').val().length;
       if(mobile>10){$('#mobile_no_div').show();}else{  $('#mobile_no_div').hide();}
      });
      $('#pincode_len').hide();
  $('#pincode').on('input',function(){  
       var mobile = $('#pincode').val().length;
       if(mobile>6){$('#pincode_len').show();}else{  $('#pincode_len').hide();}
      });
var dateOfBirth = new Date( $('#birth_date').val());
  var today = new Date(moment().format('YYYY-MM-D'));
  
  var diff = today - dateOfBirth;
  days = diff/ 1000 / 60 / 60 / 24;
  var i=parseInt(days/365);
  $('#age').val(i);
  $('#birth_date').change(function(){
  var dateOfBirth = new Date( $('#birth_date').val());
  var today = new Date(moment().format('YYYY-MM-D'));
  
  var diff = today - dateOfBirth;
  days = diff/ 1000 / 60 / 60 / 24;
  var i=parseInt(days/365);
  if(i>=0){
  $('#age').val(i);
  }
else{
  $('#age').val('please enter valid DOB');
  }

  var age = parseInt(days/365);
  
  
  });
var today = moment().format('YYYY-MM-D');
$('#date').val(today);
$('#add-accounts').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/addMember/insert')?>",
data: new FormData(this), 
contentType: false,       
cache: false,             
processData:false,
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
var values = data.split("&");
if(values[0]=="true"){  
sucessAlert("Saved Sucessfully"); 
window.scrollTo(0,1);
swal("Success","Member Added Succefully", "info");
$(".block-ui").css('display','none'); 
if($("#action").val()!='update'){        
$('#acc_name').val("");
$("#balance").val("");
$('#note').val("");     
}
swal({title: "Success",text: "Member Added Succefully.Member Id = "+values[1],type: "success", confirmButtonColor: "#DD6B55",
  confirmButtonText: "OK"},function(){ window.location.href = 'addMember';});
  window.setTimeout(function(){location.reload()},2000)       
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
url : "<?php echo site_url('Admin/addMember/update') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){ 
window.scrollTo(0,1);  
sucessAlert("Saved Sucessfully"); 
$(".block-ui").css('display','none');  
window.setTimeout(function(){location.reload()},2000)    
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
