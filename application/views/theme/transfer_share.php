<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('share_management') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-danger ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-md-8 col-lg-8 col-sm-8">
<!--Start Panel-->
<div class="alert alert-info"><p>  Transfer share from one member to another</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('transfer_share') ?></div>
    <div class="panel-body add-client">
 <form id="tranfer-share">
 
  <div class="form-group">
    <label for="from_member_id"><?php get_phrase('member_id') ?><span style='color:red'>  *</span></label>
    <input type="text" class="form-control" name="from_member_id" id="from_member_id" placeholder="<?php get_phrase('member_id')?>">
  </div>
 
  <div class="form-group">
    <label for="from_member_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="from_member_name" id="from_member_name" readonly="true">
  </div>

  <div class="form-group">
    <label for="from_member_share"><?php get_phrase('member_share') ?></label>
    <input type="text" class="form-control" name="from_member_share" id="from_member_share" readonly="true">
  </div>


  <div class="form-group">
    <label for="to_member_id"><?php get_phrase('member_id') ?><span style='color:red'>  *</span></label>
    <input type="text" class="form-control" name="to_member_id" id="to_member_id" placeholder="<?php get_phrase('member_id')?>">
  </div>

  <div class="form-group">
    <label for="to_member_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="to_member_name" id="to_member_name" readonly="true">
  </div>

  <div class="form-group">
    <label for="to_member_share"><?php get_phrase('member_share') ?></label>
    <input type="text" class="form-control" name="to_member_share" id="to_member_share" readonly="true">
  </div>



 <div class="form-group">
    <label for="account_balance"><?php get_phrase('transfer_share') ?><span style='color:red'>  *</span></label>
    <input type="number" class="form-control" name="transfer_share" id="transfer_share" placeholder=<?php get_phrase('transfer_share') ?>>
  </div>
 

  <div class="form-group">
    <label for="note"><?php get_phrase('transaction_remarks') ?><span style='color:red'>  *</span></label>
    <input type="text" class="form-control" name="transaction_remarks" id="transaction_remarks" placeholder="Remarks">
  </div>

   <div class="form-group">
      <label for="active_by"><?php get_phrase('user') ?></label>
    <select name="active_by" class="form-control" id="active_by">
      <option value="<?php echo $this->session->userdata('user_id')?>" selected="selected"><?php echo $this->session->userdata('username')?></option>
    </select>
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
	$('#from_member_id').change('input',function(e){
			var member_id  = $("#from_member_id").val();
                        $('#from_member_name').val('');
			$('#from_member_share').val('');

			if(!member_id){
				return false;
			}

			$.ajax({
				method : "POST",
  				url : "<?php echo site_url('Admin/get_user')?>",
  				data : {'id': member_id},success : function (data) {
    				var name = JSON.parse(data);
    				if(name==null){
                        		$('#from_member_name').val('');
					$('#from_member_share').val('');
					swal({
                                                          title: "Invalid Member Id",
                                                          text: "Check member id first",
                                                          type: "error",
                                         });
        			}
    				$('#from_member_name').val(name['member_name']);
				$('#from_member_share').val(name['share']);
  				}
			});

	});

	$('#to_member_id').change('input',function(e){
                        var member_id  = $("#to_member_id").val();
                        $('#to_member_name').val('');
                        $('#to_member_share').val('');

                        if(!member_id){
				$('#to_member_name').val('');
                                $('#to_member_share').val('');
                                return false;
                        }

                        $.ajax({
                                method : "POST",
                                url : "<?php echo site_url('Admin/get_user')?>",
                                data : {'id': member_id},success : function (data) {
                                var name = JSON.parse(data);
                                if(name==null){
                                        $('#to_member_name').val('');
                                        $('#to_member_share').val('');
                                        swal({
                                                          title: "Invalid Member Id",
                                                          text: "Check member id first",
                                                          type: "error",
                                         });
                                }
                                $('#to_member_name').val(name['member_name']);
                                $('#to_member_share').val(name['share']);
                                }
                        });

        });

})
</script>

<script type="text/javascript">

$(document).ready(function(){
	$('#tranfer-share').on('submit',function(){
		$.ajax({
			method : "POST",
			url : "<?php echo site_url('Admin/transferShare/transfer') ?>",
			data : $(this).serialize(),
			beforeSend : function(){
				$(".block-ui").css('display','block'); 
			},success : function(data){ 
					if(!data){
						swal({
                                                   title: "Internal error",
                                                   text: "Contact technical team",
                                                   type: "error",
                                        	});
					}else{
						if(data!="success"){
						failedAlert2(data);
						window.scrollTo(0,1);
						$(".block-ui").css('display','none');
						}else{
							swal({
                                                  		title: "Success",
                                                   		text: "Transaction Successful",
                                                   		type: "success"
                                                	});
							window.scrollTo(0,1);
                                                $(".block-ui").css('display','none');
						}
					}
    				}
		});    
		return false;
	});
})

</script>
