<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('customer_service_management') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->


<div class="col-md-5 col-lg-5 col-sm-5">
<!--Start Panel-->
<div class="alert alert-info"><p>Add Customer Service and item Here</p><p>Example:- SMS, MAINTAINENCE</p></div>
<div class="panel panel-default" >
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('add_services_and_item') ?></div>
    <div class="panel-body add-client">

<div id="add_item_div">
<form id="add-item">
 <div class="form-group"> 
    <label for="account"><?php get_phrase('service_name') ?><span style='color:red'>  *</span></label>
    <input type="text" class="form-control" maxlength="30" name="service_name" id="service_name"/>   
  </div> 
        
  <div class="form-group"> 
    <label for="p-type"><?php get_phrase('service_amount') ?><span style='color:red'>  *</span></label>
   <input type="text" class="form-control" maxlength="30" name="service_amount" id="service_amount">
  </div>         

  <div class="form-group"> 
    <label for="p-type"><?php get_phrase('description') ?></label>
   <input type="text" class="form-control" maxlength="30" name="description" id="description">
  </div>

  <div class="form-group">
    <label for="p-type"><?php get_phrase('frequency') ?><span style='color:red'>  *</span></label>
  <select name="frequency" class="form-control" id="frequency">
    <option value=''>Select</option>
    <option value="<?php echo FREQUENCY_ONETIME; ?>">One time</option>
    <option value="<?php echo FREQUENCY_MONTHLY; ?>">Monthly</option>
    <option value="<?php echo FREQUENCY_YEARLY; ?>">Yearly</option>
    </select>
   </div>
                         
  <button type="submit"  id="mybtn_btn_submit" class="mybtn btn-submit" ><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
</form>
</div>


</div>
<!--End Panel Body-->
</div>
<!--End Panel-->       
</div>
    
     
<div class="col-md-7 col-lg-7 col-sm-7">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('service_list') ?></div>
    <div class="panel-body">
       <table class="scroll-table-head table table-striped table-bordered table-condensed">
        <th class="col-md-3"><?php get_phrase('service_name') ?></th>
	<th class="col-md-3"><?php get_phrase('frequecny') ?></th>
    	<th class="col-md-3"><?php get_phrase('service_amount') ?></th>
    	<th class="col-md-3"><?php get_phrase('action') ?></th>
       </table> 

       <div class="scroll-div">
       <table id="S-Table" class="table table-striped table-bordered table-condensed">
       <?php  if(empty($services)){
        echo "<tr><td class='sc-col-3 t_name'></td><td class='sc-col-3 t_type'></td>";
        echo "<td class='sc-col-3'></td></tr>";
       }?>
       <?php foreach($services as $list){ ?>
        
        <tr>
        <td class="col-md-3 t_name"><?php echo $list->name ?></td>
	<td class="col-md-3 t_type"><?php echo $list->frequency ?></td>
	<td class="col-md-3 t_name"><?php echo $list->charge ?></td>
        <td class="col-md-3">
        <a class="mybtn btn-danger btn-xs payee-remove-btn"  href="<?php echo  site_url('Admin/serviceSetup/deactivate/'. $list->id) ?>"><?php get_phrase('deactivate') ?></a></td>   
        </tr>
        
        <?php } ?>

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
$('#add-item').on('submit',function(){ 
	$.ajax({
                        method : "POST",
                        url : "<?php echo site_url('Admin/serviceSetup/insert') ?>",
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
                                                        $("#tranfer-fund")[0].reset();
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


<script type="text/javascript">
$(document).ready(function(){
$(document).on('click','.payee-remove-btn',function(){  
	var main=$(this);
		swal(
			{title: "Are you sure Want To Deactivate?",
				text: "You will not be able to apply this to any other user!",
				type: "warning",   
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",   
				confirmButtonText: "Yes, deactivate it!",
				closeOnConfirm: false,
				showLoaderOnConfirm: true 
			}, function(){ 
				var link=$(main).attr("href");    
				$.ajax({
					url : link,
					beforeSend : function(){
						$(".block-ui").css('display','block'); 
					},success : function(data){
							$(main).closest("tr").remove();    
							sucessAlert("Remove Sucessfully"); 
							$(".system-alert-box").empty();
							swal("Deleted!", "Remove Sucessfully", "success");
						$(".block-ui").css('display','none');
							
					}    
				});
			});
			return false;       
});
})

</script>
