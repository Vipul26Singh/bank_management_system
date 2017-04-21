
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

    <div class="panel-heading"><?php get_phrase('panel_manage_accounts') ?> <div class="add-button">
    <a class="mybtn btn-default asyn-link" href="<?php echo site_url('Admin/addAccount') ?>">Add Account</a>
    </div><br><br>
<form id="search" action="<?php echo base_url()?>Admin/withdraw_from_single_user/search" method="get">
  <input type="search" name="search" id="search" placeholder="Search by Account No.">
  <input type="search" name="search_name" id="search_name" placeholder="Search by Name">
    <button type="submit" >Search</button>
  </form>
    </div>

    <div class="panel-body manage-client">
        <table class="table table-striped table-bordered table-condensed">
		<th><?php get_phrase('member_id') ?></th>
         <th><?php get_phrase('account_number') ?></th>
          <th><?php get_phrase('member_name') ?></th>
		   <th><?php get_phrase('balance') ?></th>
		    <th><?php get_phrase('account_type') ?></th>
         <th><?php get_phrase('opening_date') ?></th>
         <th><?php get_phrase('service')?></th>
         <th><?php get_phrase('Action')?></th>
	
		
        
        <?php if(isset($accounts)){foreach ($accounts as $account) { ?>
        <tr>
            <td><?php echo $account->member_id ?></td><input type="text" id="member_id" name="member_id" value="<?php echo $account->member_id;?>" hidden="true">
	  <td><?php echo $account->bank_account_number ?></td>
	    <td><?php echo $account->member_name ?></td>
         <td><?php echo $account->account_balance ?></td>
          <td><?php if($account->bank_account_type=='1'){echo 'Current';}else{echo 'Savings';}?></td>
           <td><?php echo $account->opening_date ?></td>
           

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
    $('#withdraw').click(function(){ var id =$('#member_id').val();
        var service =$('#service').val();
   $.ajax({
  method : "POST",
  url : "<?php echo site_url('Admin/withdraw_from_single_user/withdraw')?>",
  data : {'id': id,'service':service},success : function (data) {
   if(data=="true"){  
sucessAlert("Saved Sucessfully"); 
$(".block-ui").css('display','none'); 
   
}
else{
failedAlert2(data);
$(".block-ui").css('display','none');
}   

  }
});});
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
