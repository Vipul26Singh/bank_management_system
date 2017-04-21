<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_accounts') ?></h4></div>
<div class="col-md-12 col-lg-12 col-sm-12">
<!--Start Panel-->
<div class="alert alert-success ajax-notify"></div>
<div class="panel panel-default" style="width:160vh">
    <!-- Default panel contents -->

    <div class="panel-body manage-client" style="width:150vh">
    <form id='service_form'>
        <table class="table table-striped table-bordered table-condensed">
		<th><?php get_phrase('service_name') ?></th>
        <th><?php get_phrase('start_date') ?></th>
          <th><?php get_phrase('end_date') ?></th> 
          <th><?php get_phrase('select') ?></th>
	
		
        <input type="text" id="member_id" name="member_id" hidden="true" value="<?php echo $this->input->get('id')?>">
        <?php $i=0;if(isset($services)){foreach ($services as $service) { ?>
        <tr>
            
	  <td><?php echo $service->service_name ?></td>
          <input type="text" id="service_id_<?php echo $service->tbl_id?>"name="service_id_<?php echo $service->tbl_id?>" value="<?php echo $service->tbl_id?>" hidden>
	     <td><input type='search' class="start_date" id="start_date<?php echo $service->tbl_id?>" name="start_date_<?php echo $service->tbl_id?>" value="<?php if(!empty($service->start_date)){ echo $service->start_date; }?>"></td>
      <td><input type='search'  class="end_date" id="end_date<?php echo $service->tbl_id?>" name="end_date_<?php echo $service->tbl_id?>" value="<?php if(!empty($service->end_date)){ echo $service->end_date; }?>" ></td> 
      <td><input type="checkbox" name="tag_<?php echo $service->tbl_id?>" id="tag_<?php echo $service->tbl_id?>" value="yes" 
    <?php if($service->checked) echo 'checked="checked" disabled'; ?> /></td>
        </tr>
        <?php }} ?>    

        </table>
       <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
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
$(".start_date").datepicker({
    onSelect: function(selectedDate) {
         $(this).next()
                .datepicker();
    }
})
$(".end_date").datepicker({
    onSelect: function(selectedDate) {
         $(this).next()
                .datepicker();
    }
})
$('#service_form').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/service_management/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){
swal(title="Added Sucessfully");  
window.setTimeout(function(){location.reload()},1000)
sucessAlert("Saved Sucessfully"); 
}else{
failedAlert2(data);
$(".block-ui").css('display','none');
}   
}
});    
return false;

});

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

});
</script>
