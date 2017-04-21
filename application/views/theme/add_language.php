<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_language_settings') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-md-5 col-lg-5 col-sm-5">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_add_language') ?></div>
    <div class="panel-body add-client">
    <form id="add-language" method="post" action="<?php echo site_url('Language/add_new_language') ?>">
 <div class="form-group"> 
    <label for="language"><?php get_phrase('language') ?></label>
    <input type="text" class="form-control" name="language" id="language"/>   
  </div> 
              
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
</form>
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel-->       
</div>
    
<!-- Start Table Section -->    
    
<div class="col-md-7 col-lg-7 col-sm-7">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_language_list') ?></div>
    <div class="panel-body">
       <table class="table table-striped table-bordered table-condensed language-table">
        <th><?php get_phrase('language') ?></th><th width="130"><?php get_phrase('action') ?></th>
       <?php foreach($language_list as $language){ 
	   if($language=="phrase_id" || $language=="phrase"){
	   continue;
	   }
	   ?>
        <tr>
        <td><?php echo ucwords($language); ?></td>
        <td><a class="mybtn btn-info btn-xs" id="manage-language" 
		href="<?php echo site_url('Language/edit_phrase/'.$language) ?>"><?php get_phrase('manage') ?></a></td>  
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
$(document).ready(function() {

$('#add-language').on('submit',function(event){ 
var link=$(this).attr("action");
$.ajax({
method : "POST",
url : link,
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){  
if(data=="true"){   
sucessAlert("New Language Added Sucessfully"); 
$(".block-ui").css('display','none');
appendRow();
$('#add-language')[0].reset(); 
}else{
failedAlert2(data);
$(".block-ui").css('display','none');
}   
}
});    
return false;
});

function appendRow(){
var manage="<?php get_phrase('manage') ?>";
var remove="<?php get_phrase('remove') ?>";
var pharse_link="<?php echo site_url('Language/edit_phrase')."/"; ?>"+$("#language").val();
$(".language-table tr:first").after("<tr><td>"+$("#language").val()+"</td><td><a class='mybtn btn-info btn-xs' id='manage-language' href='"+pharse_link+"'>"+manage+"</a></td></tr>"); 

}

//Manage Language
/*$(document).on('click','#manage-language',function(){

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
});*/

});

</script>

