
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
<form id="search" action="<?php echo base_url()?>Admin/manageAccount/search" method="get">
<input type="search" name="search" id="search" placeholder="Search by Account No.">
<input type="search" name="search_name" id="search_name" placeholder="Search by Name">
<button type="submit" >Search</button>
</form>
</div>

<div class="panel-body panel-primary">
<table class="table table-striped table-bordered table-condensed">
<th><?php get_phrase('account_number') ?></th>
<th><?php get_phrase('member_name') ?></th>
<th><?php get_phrase('member_id') ?></th>
<th><?php get_phrase('account_type') ?></th>
<th><?php get_phrase('joint') ?></th>
<th><?php get_phrase('opening_date') ?></th>



<th class="action"><?php get_phrase('action') ?></th>

<?php if(isset($accounts)){foreach ($accounts as $account) { ?>
	<tr>
		<td><?php echo $account['bank_account_number'] ?></td>
		<td><?php echo $account['member_name'] ?></td>
		<td><?php echo $account['member_id'] ?></td>
		<td><?php echo $account['account_name'] ?></td>
		<td><?php if($account['joint'] == '1') echo 'YES'; else echo 'NO'; ?></td>  
		<td><?php echo $account['opening_date'] ?></td>
		<td><a class="mybtn btn-info btn-xs account-edit-btn" href="<?php echo site_url('Admin/manageAccount/view/'.$account['bank_account_number']) ?>"><i class="fa fa-search"></i> <?php get_phrase('view') ?></a>
		<a class="mybtn btn-danger btn-xs account-remove-btn" href="<?php echo site_url('Admin/manageAccount/deactivate/'.$account['bank_account_number']) ?>"><i class="fa fa-trash-o"></i> <?php get_phrase('deactivate') ?></a>

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
if(data==1){
$(main).closest("tr").remove();    
//sucessAlert("Remove Sucessfully");
$(".system-alert-box").empty();
swal("Deactivated!", "Deactivated Sucessfully", "success");  
window.setTimeout(function(){location.reload()},1000) 
$(".block-ui").css('display','none');
}
else{swal("Error!", "Unable to deactivate", "error");  
window.setTimeout(function(){location.reload()},1000) 
$(".block-ui").css('display','none');}
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
