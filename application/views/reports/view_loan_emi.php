<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_accounts') ?></h4></div>
<div class="col-md-12 col-lg-12 col-sm-12">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->

   

    <div class="panel-body manage-client" style="overflow-y:scroll">
        <table class="table table-striped table-bordered table-condensed" style="overflow-y:scroll">
    <th><?php get_phrase('member_id') ?></th>
         <th><?php get_phrase('emi_amount') ?></th>
          <th><?php get_phrase('date') ?></th>
       <th><?php get_phrase('paid') ?></th>
         <th><?php get_phrase('paid_date') ?></th>
       
  
    
        
        <?php if(isset($reportData)){foreach ($reportData as $account) { ?>
        <tr>
           
    <td><?php echo $account->member_id ?></td>
      <td><?php echo $account->emi_amount ?></td>
         <td><?php echo $account->date ?></td>
         <td><?php if($account->paid){echo 'Paid';}else{echo 'Pending';} ?></td>
        <td><?php echo $account->paid_date ?></td>
        </tr>
        <?php }} ?>    

        </table>
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
//     $('#withdraw').click(function(){ var id =$('#member_id').val();
//         var service =$('#service').val();
//         swal({title:"Edit User Service",text:"Select User Services"});
//    $.ajax({
//   method : "POST",
//   url : "<?php echo site_url('Admin/withdraw_from_single_user/withdraw')?>",
//   data : {'id': id,'service':service},success : function (data) {
//    if(data=="true"){  
// sucessAlert("Saved Sucessfully"); 
// $(".block-ui").css('display','none'); 
   
// }
// else{
// failedAlert2(data);
// $(".block-ui").css('display','none');
// }   

//   }
// });});
$('.account-remove-btn').on('click',function(){ 
var main=$(this);
swal({title: "Are you sure Want To Delete?",
text: "You will not be able to recover this Account Data!",
type: "warning",   showCancelButton: true,confirmButtonColor: "#DD6B55",   
confirmButtonText: "Yes, delete it!",closeOnConfirm: false,
showLoaderOnConfirm: true }, function(){ 
///////////////    
//var link=$(main).attr("href");    
//$.ajax({
//url : link,
//beforeSend : function(){
//$(".block-ui").css('display','block'); 
//},success : function(data){
//$(main).closest("tr").remove();    
////sucessAlert("Remove Sucessfully");
//$(".system-alert-box").empty();
//swal("Deleted!", "Remove Sucessfully", "success");  
//$(".block-ui").css('display','none');
//}    
//});
//}); 
//return false;       
//});
//
//$('.account-edit-btn').on('click',function(){
//var link=$(this).attr("href"); 
//$.ajax({
//method : "POST",
//url : link,
//beforeSend : function(){
//$(".block-ui").css('display','block'); 
//},success : function(data){ 
////var link = location.pathname.replace(/^.*[\\\/]/, ''); //get filename only  
//history.pushState(null, null,link);  
//$('.asyn-div').load(link+'/asyn',function() {
//$(".block-ui").css('display','none');     
//});     
//   
//}
//});

return false;
}); 
});
});
</script>
