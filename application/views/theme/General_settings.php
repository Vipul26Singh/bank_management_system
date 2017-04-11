<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_general_settings') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->


<div class="col-md-8 col-lg-8 col-sm-8">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_general_settings') ?></div>
    <div class="panel-body add-client">
    <form id="add-general-settings">
   <div class="form-group"> 
    <label for="account"><?php get_phrase('company_name') ?></label>
    <input type="text" class="form-control" value="<?php echo $settings[0]->value; ?>" name="company-name" id="company-name"/>   
  </div> 
        
        
    <div class="form-group"> 
    <label for="language"><?php get_phrase('language') ?></label>
    <select name="language" class="form-control" id="language"> 
	<?php foreach($language_list as $language){ 
	   if($language=="phrase_id" || $language=="phrase"){
	   continue;
	   }
	   ?>
    <option value="<?php echo $language; ?>"><?php echo ucwords($language); ?></option>
	<?php } ?>
    </select>      
    </div>   

    <div class="form-group"> 
    <label for="timezone"><?php get_phrase('time_zone') ?></label>
    <select name="timezone" class="form-control" id="timezone"> 
    <?php foreach($timezone as $key => $value){ ?> 
    <option value="<?php echo $value['ZONE'] ?>"><?php echo "(".$value['GMT'].") ".$value['ZONE'] ?></option>
    <?php } ?>
    </select>      
    </div>     

    <div class="form-group"> 
    <label for="user-signup"><?php get_phrase('user_signup') ?></label>
    <select name="user-signup" class="form-control" id="user-signup"> 
     <option value="yes">Yes</option>
	 <option value="no">No</option>
    </select>      
    </div>	
 
     <div class="form-group"> 
    <label for="cur-symbol"><?php get_phrase('currency_symbol') ?></label>
    <input type="text" class="form-control" value="<?php echo $settings[2]->value; ?>" name="cur-symbol" id="cur-symbol"/>   
    </div>
                       
   <div class="form-group"> 
    <label for="email"><?php get_phrase('email_address') ?></label>
    <input type="email" class="form-control" value="<?php echo $settings[3]->value; ?>" name="email" id="email"/>   
  </div>    
   
    <div class="form-group"> 
    <label for="address"><?php get_phrase('address') ?></label>
    <textarea name="address" id="address" class="form-control"><?php echo $settings[4]->value; ?></textarea> 
  </div> 
                
    <div class="form-group"> 
    <label for="phone"><?php get_phrase('phone') ?></label>
    <input type="text" class="form-control" value="<?php echo $settings[5]->value; ?>" name="phone" id="phone"/>   
  </div>     
    
    <div class="form-group"> 
    <label for="website"><?php get_phrase('website') ?></label>
    <input type="text" class="form-control" value="<?php echo $settings[6]->value; ?>" name="website" id="website"/>   
  </div>                                                                                                           
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
   </form>
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel-->       
</div>
   
<div class="col-md-3 col-sm-3 col-lg-3">
<div class="panel panel-default">
<!-- Default panel contents -->
<div class="panel-heading"><?php get_phrase('panel_upload_logo') ?></div>
<div class="panel-body"> 
<?php 
$attributes = array('id' => 'upload-logo');
echo form_open_multipart('Admin/uploadLogo',$attributes);
?>
<div class="form-group"> 
<img src="<?php echo base_url()."/uploads/".$settings[7]->value ?>" class="setting-logo"/>
<input type="file" name="logo" style="visibility:hidden; height:0px" id="logo" />
<input type="button" id="clickme" value="<?php get_phrase('select_image') ?>" /> 
</div>

<button type="submit"  class="mybtn btn-submit btn-sm btn-block" ><i class="fa fa-upload"></i> <?php get_phrase('upload') ?></button>
</form>
</div>   
</div>      
    
</div>   
    
   
        

</div><!--End Inner container-->
</div><!--End Row-->
</div><!--End Main-content DIV-->
</section><!--End Main-content Section-->


<script type="text/javascript">
$(document).ready(function() {

 $("#timezone").select2();
 $("#timezone").select2("val","<?php echo $settings[8]->value; ?>"); 
 $("#user-signup").val("<?php echo $settings[9]->value; ?>"); 
 

 $("#language").select2();
 var lan="<?php echo $settings[1]->value; ?>";
 $("#language").select2("val",lan);  

 $('#clickme').click(function(){
 $('#logo').click();     
 });
    
$('#logo').change(function () {
    readURL(this);
});   
    
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.setting-logo').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}  

//File Upload
$('#upload-logo').on('submit',function(){
  var link=$(this).attr("action");
  $.ajax({
  url: link,
  type: "POST",
  data:  new FormData(this),
  mimeType:"multipart/form-data",
  contentType: false,
  cache: false,
  processData:false,
  beforeSend : function(){
  $(".block-ui").css('display','block'); 
  },success : function(data){ 
  if(data=="true"){ 
  sucessAlert("Logo Uploaded Sucessfully");   
  }else{
  failedAlert2(data); 
  }
  $(".block-ui").css('display','none');  
  }
  });

return false;
});

//Update General Settings
$('#add-general-settings').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/generalSettings/update') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){  
var link = location.pathname.replace(/^.*[\\\/]/, ''); //get filename only    
$('.asyn-div').load(link+'/asyn',function() {
sucessAlert("Saved Sucessfully"); 
$(".block-ui").css('display','none'); 
if($(".sidebar").width()=="0"){
$(".main-content").css("padding-left","0px");
}    
});     
 
}else{
failedAlert2(data);
$(".block-ui").css('display','none');
}   
}
});    
return false;
});  
   

});

</script>

