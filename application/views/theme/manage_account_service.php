
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

<div class="panel-heading"><?php get_phrase('manage_account_services') ?> <div class="add-button">
</div><br><br>
<form id="search" action="<?php echo base_url()?>Admin/manageAccountService/search" method="get">
<input type="search" name="search_account_number" id="search_account_number" placeholder="Search by Account No.">
<input type="search" name="search_member_name" id="search_member_name" placeholder="Search by Member Name">
<button type="submit" >Search</button>
</form>
</div>

<div class="panel-body panel-primary">
<table class="table table-striped table-bordered table-condensed">
<th><?php get_phrase('account_number') ?></th>
<th><?php get_phrase('member_name') ?></th>
<th><?php get_phrase('member_id') ?></th>
<th><?php get_phrase('service_name') ?></th>
<th><?php get_phrase('subscription_date') ?></th>



<th class="action"><?php get_phrase('action') ?></th>

<?php if(isset($accounts)){foreach ($accounts as $account) { ?>
	<tr>
		<td><?php echo $account['bank_account_number'] ?></td>
		<td><?php echo $account['member_name'] ?></td>
		<td><?php echo $account['member_id'] ?></td>
		<td><?php echo $account['name'] ?></td>
		<td><?php echo $account['application_date'] ?></td>
		<td><a class="mybtn btn-info btn-xs account-edit-btn" href="<?php echo site_url('Admin/manageAccountService/view/'.$account['account_id'].'/'.$account['service_id']) ?>"><i class="fa fa-search"></i> <?php get_phrase('view') ?></a>
		<a class="mybtn btn-danger btn-xs account-remove-btn" href="<?php echo site_url('Admin/manageAccountService/deactivate/'.$account['account_id'].'/'.$account['service_id']) ?>"><i class="fa fa-trash-o"></i> <?php get_phrase('deactivate') ?></a>

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
				$('.account-remove-btn').on('click',function(){ 
						var main=$(this);
						swal({title: "Are you sure ?",
								text: "You will not be able to recover this Account Data!",
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
$(main).closest("tr").remove();    
//sucessAlert("Remove Sucessfully");
$(".system-alert-box").empty();
swal("Deactivated!", "Deactivated Sucessfully", "success");  
window.setTimeout(function(){location.reload()},1000) 
$(".block-ui").css('display','none');
}    
});
}); 
return false;       
});

$('.account-edit-btn').on('click',function(){
		var link=$(this).attr("href"); 
		$.ajax({
method : "POST",
url : link,
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
//var link = location.pathname.replace(/^.*[\\\/]/, ''); //get filename only  
history.pushState(null, null,link);  
$('.asyn-div').load(link+'/asyn',function() {
		$(".block-ui").css('display','none');     
		});     

}
});

		return false;
		}); 
});

</script>
