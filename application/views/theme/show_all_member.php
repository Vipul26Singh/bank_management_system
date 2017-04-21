
<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('member_detail') ?></h4></div>


<!--Alert-->
<div class="system-alert-box">

<div class="panel-heading"><?php get_phrase('panel_manage_member') ?> <div class="add-button">
    <a class="mybtn btn-default asyn-link" href="<?php echo site_url('Admin/addMember') ?>">Add Member</a>
    </div><br><br>

<form id="search" action="<?php echo base_url()?>BankData/show_all_member/search" method="get">
  <input type="search" name="search_mobile" id="search_mobile" placeholder="Search by Mobile">
  <input type="search" name="search_name" id="search_name" placeholder="Search by Name">
    <button type="submit" >Search</button>
  </form><br>
<table class="table table-striped table-bordered table-hover" cellspacing="0" rules="all" border="1" id="ContentPlaceHolder1_GridView1" style="background-color:White;width:100%;">
        <tbody><tr>
            <th>MemberID</th><th>MemberName</th><th>ResAddress</th><th>MobileNo</th><th>City</th><th>PanCardNo</th><th>Opening Date</th><th class="action"><?php get_phrase('action') ?></th>
        </tr><?php foreach($data as $details){?><tr>
            <td><?php echo $details->member_id?></td>
            <td><?php echo $details->member_name?></td>
            <td><?php echo (strlen($details->residential_address)>15)?substr($details->residential_address,0,15)."...":$details->residential_address;?></td>
            <td><?php echo $details->mobile_no?></td>
            <td><?php echo $details->city?></td>
              <td><?php echo (strlen($details->pancard_number)>15)?substr($details->pancard_number,0,15)."...":$details->pancard_number;?></td>
                <td><?php echo $details->opening_date?></td>
	<td><a class="mybtn btn-info btn-xs account-edit-btn" href="<?php echo site_url('BankData/editMember/'.$details->member_id) ?>"><i class="fa fa-search"></i> <?php get_phrase('view') ?></a>
	<a class="mybtn btn-danger btn-xs account-remove-btn" href="<?php echo site_url('Admin/deactivateMember/'.$details->member_id) ?>"><i class="fa fa-trash-o"></i> <?php get_phrase('deactivate') ?></a>

	</td>
        </tr><?php }?>
    </tbody></table>
</div>
</div></div></div>
<!--End Main-content DIV-->
</section><!--End Main-content Section-->


<script type="text/javascript">
$(document).ready(function() {
$('.account-remove-btn').on('click',function(){ 
var main=$(this);
swal({title: "Are you sure ?",
text: "All pending activities of this customer may lost!",
type: "warning",   showCancelButton: true,confirmButtonColor: "#DD6B55",   
confirmButtonText: "Yes!",closeOnConfirm: false,
showLoaderOnConfirm: true }, function(){ 
///////////////    
var link=$(main).attr("href");    
$.ajax({
url : link,
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){
    if(data==1){
$(main).closest("tr").remove();    
//sucessAlert("Remove Sucessfully");
$(".system-alert-box").empty();
swal("Deactivated!", "Deactivated Sucessfully", "success");  
window.setTimeout(function(){location.reload()},1000) 
$(".block-ui").css('display','none');
}
else{swal("Activated!", "Activated Sucessfully", "success");  
   window.setTimeout(function(){location.reload()},1000) 
$(".block-ui").css('display','none');}
}    
});
}); 
return false;       
});

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
function loadImage() {
    alert("Image is loaded");
}
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
$(".block-ui").css('display','none');
appendRow();
$('#add-expense')[0].reset(); 
}else{
failedAlert2(data);
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


