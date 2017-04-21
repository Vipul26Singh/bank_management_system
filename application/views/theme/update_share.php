<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_income') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-danger ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-md-8 col-lg-8 col-sm-8">
<!--Start Panel-->
<div class="alert alert-info"><p> Update share</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('update_member_share') ?></div>
    <div class="panel-body add-client">
 <form id="change_share">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trans_id" id="trans_id" value=""/>     


	<div class="form-group" >
    		<label for="member_id"><?php get_phrase('member_id') ?></label>
    		<input type="text" class="form-control"  name="member_id" id="member_id" readonly="true" value="<?php echo $member_detail['member_id'] ?>">
  	</div>

	<div class="form-group" >
                <label for="member_name"><?php get_phrase('member_name') ?></label>
                <input type="text" class="form-control"  name="member_name" id="member_name" readonly="true" value="<?php echo $member_detail['member_name'] ?>">
        </div>

	<div class="form-group" >
                <label for="mobile_no"><?php get_phrase('mobile_no') ?></label>
                <input type="text" class="form-control"  name="mobile_no" id="mobile_no" readonly="true" value="<?php echo $member_detail['mobile_no'] ?>">
        </div>

	<div class="form-group" >
                <label for="email_id"><?php get_phrase('email_id') ?></label>
                <input type="text" class="form-control"  name="email_id" id="email_id" readonly="true" value="<?php echo $member_detail['email_id'] ?>">
        </div>

	<div class="form-group" >
                <label for="old_share"><?php get_phrase('old_share') ?></label>
                <input type="text" class="form-control"  name="old_share" id="old_share" readonly="true" value="<?php echo $member_detail['share'] ?>">
        </div>

	<div class="form-group">
                <label for="new_share"><?php get_phrase('new_share') ?><span style="color:red">  *</span></label>
                <input type="number" class="form-control"  name="new_share" id="new_share"  placeholder="<?php get_phrase("new_share")?>">
        </div>

	 <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('submit') ?></button>
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
	$('#change_share').on('submit',function(){
		member_id = $('#member_id').val();
		old_share = $('#old_share').val();
		new_share = $('#new_share').val();
		$.ajax({
			method : "POST",
			url : "<?php echo site_url('Admin/updateShare/update')?>",
			data : {'member_id': member_id, 'old_share': old_share, 'new_share': new_share},
			success : function(data){ 
					if(!data){
						swal({
                                                                                title: "Internal error",
                                                                                text: "Contact technical team",
                                                                                type: "error",
                                                                        }, function() {
                                                                                window.location = "<?php echo site_url('Admin/manageShare')?>";
                                                                        });	
					}else if(data!="success"){
						swal({
                                                                                title: "Error",
                                                                                text: data,
                                                                                type: "error",
                                                                        }, function() {
            									window.location = "<?php echo site_url('Admin/manageShare')?>";
        								});
					}else{
						swal({
                                                                                title: "Success",
                                                                                text: "Share changed successfully",
                                                                                type: "success",
                                                                        }, function() {
                                                                                window.location = "<?php echo site_url('Admin/manageShare')?>";
                                                                        });
					}
			}
		});    
		return false;
	});
})

</script>
