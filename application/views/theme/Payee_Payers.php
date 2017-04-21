<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_payee_and_payer') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
</div>
<!--End Alert-->


<div class="col-md-5 col-lg-5 col-sm-5">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_payee_payer') ?></div>
    <div class="panel-body add-client">
    <form id="add-payers-payee">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trace_id" id="trace_id" value=""/>  
 <div class="form-group"> 
    <label for="account"><?php get_phrase('payee_payer_name') ?></label>
    <input type="text" class="form-control" maxlength="30" name="p-name" id="p-name"/>   
  </div> 
        
  <div class="form-group"> 
    <label for="p-type"><?php get_phrase('type') ?></label>
    <select name="p-type" class="form-control" id="p-type"> 
    <option value="Payee"><?php get_phrase('payee') ?></option>
    <option value="Payer"><?php get_phrase('payer') ?></option> 
    </select>      
  </div>         
                         
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('save') ?></button>
</form>
</div>
<!--End Panel Body-->
</div>
<!--End Panel-->       
</div>
    
     
<div class="col-md-7 col-lg-7 col-sm-7">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_payee_payer_list') ?></div>
    <div class="panel-body">
       <table class="scroll-table-head table table-striped table-bordered table-condensed">
        <th class="sc-col-4"><?php get_phrase('payee_payer_name') ?></th>
		<th class="sc-col-3"><?php get_phrase('type') ?></th>
		<th class="sc-col-3"><?php get_phrase('action') ?></th>
       </table> 

       <div class="scroll-div">
       <table id="P-Table" class="table table-striped table-bordered table-condensed">
       <?php  if(empty($p_list)){
        echo "<tr><td class='sc-col-4 t_name'></td><td class='sc-col-3 t_type'></td>";
        echo "<td class='sc-col-3'></td></tr>";
       }?>
       <?php foreach($p_list as $list){ ?>
        
        <tr>
        <td class="sc-col-4 t_name"><?php echo $list->payee_payers ?></td>
        <td class="sc-col-3 t_type"><?php echo $list->type ?></td>  
        <td class="sc-col-3"><a class="mybtn btn-info btn-xs payee-edit-btn" href="<?php echo $list->trace_id ?>"><?php get_phrase('edit') ?></a>
        <a class="mybtn btn-danger btn-xs payee-remove-btn"  href="<?php echo  site_url('Admin/payeeAndPayers/remove/'.$list->trace_id) ?>"><?php get_phrase('remove') ?></a></td>   
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
$("#p-type").select2(); 
$("#p-type").select2("val","");

$(".scroll-div").niceScroll({
cursorwidth: "8px",cursorcolor:"#7f8c8d",cursorborderradius:"0px"
});  

$('#add-payers-payee').on('submit',function(event){  

$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/payeeAndPayers/insert') ?>",
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
$(".block-ui").css('display','none');        
$('#add-payers-payee')[0].reset();
$("#p-type").select2("val","");      
}else{
failedAlert(json['message']);
$(".block-ui").css('display','none');
}   
}
}); 
event.preventDefault();
});  
    
$(document).on('click','.payee-remove-btn',function(){  
var main=$(this);
swal({title: "Are you sure Want To Delete?",
text: "You will not be able to recover this Data!",
type: "warning",   showCancelButton: true,confirmButtonColor: "#DD6B55",   
confirmButtonText: "Yes, delete it!",closeOnConfirm: false,
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
swal("Deleted!", "Remove Sucessfully", "success"); 
$(".block-ui").css('display','none');
}    
});
});
return false;       
}); 
    
$(document).on('click','.payee-edit-btn',function(){
var main=$(this);    
$("#action").val("update");
$("#trace_id").val($(main).attr("href"));
$("#p-name").val($(main).closest("tr").find(".t_name").html()); 
$("#p-type").select2("val",$(main).closest("tr").find(".t_type").html());  
//get table index
var tr = $(main).closest('tr');
myRow = tr.index();

return false;    
});   


function appendRow(id){
var base='<?php echo base_url() ?>'+'Admin/payeeAndPayers/remove/'+id;    
var edit_link="<a class='mybtn btn-info btn-xs payee-edit-btn'  href='"+id+"'><?php get_phrase('edit') ?></a>";
var remove_link="<a class='mybtn btn-danger btn-xs payee-remove-btn' href='"+base+"'><?php get_phrase('remove') ?></a>";

/*
$("#P-Table tr:first").after("<tr><td class='t_name'>"+$("#p-name").val()+"</td>"+
"<td class='t_type'>"+$("#p-type").val()+"</td><td>"+edit_link+" "+remove_link+"</td></tr>"); 
*/

$("<tr><td class='t_name'>"+$("#p-name").val()+"</td>"+
"<td class='t_type'>"+$("#p-type").val()+"</td><td>"+edit_link+" "+remove_link+"</td></tr>").insertBefore("#P-Table tr:first");

}

function updateRow(){
var an=$("#p-name").val();
var at=$("#p-type").val();

var x = document.getElementById("P-Table").rows[myRow].cells;
x[0].innerHTML = an;
x[1].innerHTML = at;
$("#action").val("insert");
} 
    
    

});

</script>

