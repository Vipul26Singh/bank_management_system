<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4>Edit Language Phrase</h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->

<div class="col-sm-12">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Edit Language Phrase</div>
    <div class="panel-body add-client">
	<?php
	$last = $this->uri->total_segments();
    $language = $this->uri->segment($last);
	?>
    <form id="update-language" method="post" action="<?php echo site_url('Language/update_language/'.$language) ?>">
  <?php foreach($phraser as $p){ ?>
  
  <div class="col-sm-3">
	  <div class="form-group"> 
		<label for="language"><?php echo $p->phrase; ?></label>
		<input type="text" class="form-control" value="<?php  echo $p->p_value; ?>" name="<?php echo trim($p->phrase); ?>"/>   
	  </div> 
  </div>
  
  <?php } ?>
      
  <div class="col-sm-12">
  <div class="form-group">	  
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
  </div>
  </div>
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
$(document).ready(function() {

$('#update-language').on('submit',function(event){ 
var link=$(this).attr("action");
$.ajax({
method : "POST",
url : link,
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){  
if(data=="true"){   
sucessAlert("Language Update Sucessfully"); 
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
$(".language-table tr:first").after("<tr><td>"+$("#language").val()+"</td><td><a class='mybtn btn-info btn-xs' id='manage-language' href='"+pharse_link+"'>"+manage+"</a>"+
"<a class='mybtn btn-danger btn-xs' id='remove-language' href=''>"+remove+"</a></td></tr>"); 

}

});

</script>

