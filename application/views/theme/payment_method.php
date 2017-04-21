<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_payment_method') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
<?php if(isset($_SESSION['message'])){?><div class="alert alert-warning"><?php echo $_SESSION['message']; ?></div><?php }?>
</div>
<!--End Alert-->


<div class="col-md-5 col-lg-5 col-sm-5">
<!--Start Panel-->
<div class="alert alert-info"><p>Add Payment Method Here</p><p>Example:- Cash, Cheque</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_add_payment_method') ?></div>
    <div class="panel-body add-client">
    <form id="add-payment-method">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="p_method_id" id="p_method_id" value=""/> 
 <div class="form-group"> 
    <label for="account"><?php get_phrase('name') ?></label>
    <input type="text" class="form-control" maxlength="20" name="p-method" id="p-method"/>   
  </div> 
            
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
</form>
         <?php if(isset($_SESSION['message'])){
      ?><button  class="btn btn-success" id="next" name="next" >Next>>></button><?php }?>
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel-->       
</div>
    
   
    
<div class="col-md-7 col-lg-7 col-sm-7">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_payment_method_list') ?></div>
    <div class="panel-body">
       <table id="method-table" class="table table-striped table-bordered table-condensed">
        <th><?php get_phrase('payment_method') ?></th><th width="110"><?php get_phrase('action') ?></th>
       <?php foreach($p_list as $list){ ?>
        <tr>
        <td class="t_name"><?php echo $list->p_method_name ?></td>
        <td><a class="mybtn btn-info btn-xs method-edit-btn"  href="<?php echo $list->p_method_id ?>"><?php get_phrase('edit') ?></a>
        <a class="mybtn btn-danger btn-xs method-remove-btn" href="<?php echo  site_url('Admin/paymentMethod/remove/'.$list->p_method_id) ?>"><?php get_phrase('remove') ?></a></td>  
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
 
$('#add-payment-method').on('submit',function(){    
$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/paymentMethod/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
var json = JSON.parse(data); 

if(json['result']=="true" ){  
if(json['action']=="insert"){
appendRow(json['last_id']);
}else if(json['action']=="update"){
updateRow();
}      
sucessAlert("Saved Sucessfully"); 
window.setTimeout(function(){location.reload()},1000)  
$(".block-ui").css('display','none');      
$('#add-payment-method')[0].reset();     

}else{
failedAlert(json['message']);
$(".block-ui").css('display','none');
}   
}
});    
return false;
});  
   $('#next').click(function(){
  window.location.href="late_fees_charges";   
});   
$('body').on('click','.method-remove-btn',function(){  
var main=$(this);
swal({title: "Are you sure Want To Delete?",
text: "You will not be able to recover this Data!",
type: "warning",   showCancelButton: true,confirmButtonColor: "#DD6B55",   
confirmButtonText: "Yes, delete it!",closeOnConfirm: false,
showLoaderOnConfirm: true}, function(){ 
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
swal("Deleted!", "Remove Sucessfully", "success"); 
$(".block-ui").css('display','none');
}   
});
});
return false;       
}); 
    
$(document).on('click','.method-edit-btn',function(){
var main=$(this);    
$("#action").val("update");
$("#p_method_id").val($(main).attr("href"));
$("#p-method").val($(main).closest("tr").find(".t_name").html()); 
//get table index
var tr = $(main).closest('tr');
myRow = tr.index();    
return false;    
});    

function appendRow(id){
var base='<?php echo base_url() ?>'+'Admin/paymentMethod/remove/'+id;    
var edit_link="<a class='mybtn btn-info btn-xs method-edit-btn'  href='"+id+"'><?php get_phrase('edit') ?></a>";
var remove_link="<a class='mybtn btn-danger btn-xs method-remove-btn' href='"+base+"'><?php get_phrase('remove') ?></a>";

$("#method-table tr:first").after("<tr><td class='t_name'>"+$("#p-method").val()+"</td>"+
"><td>"+edit_link+" "+remove_link+"</td></tr>"); 

}

function updateRow(){
var an=$("#p-method").val();
var x = document.getElementById("method-table").rows[myRow].cells;
x[0].innerHTML = an;
$("#action").val("insert");
}     
        

});

</script>

