<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('customer_service_management') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<div class="alert alert-success ajax-notify"></div>
<?php if(isset($_SESSION['message'])){?><div class="alert alert-warning"><?php echo $_SESSION['message']; ?></div><?php }?>
</div>
<!--End Alert-->


<div class="col-md-5 col-lg-5 col-sm-5">
<!--Start Panel-->
<div class="alert alert-info"><p>Add Customer Items Here</p><p>Example:- ChequeBook, PassBook</p></div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('add_customer_service') ?></div>
    <div class="panel-body add-client">
    <form id="add-payers-payee">
 <input type="hidden" name="action" id="action" value="insert"/>  
 <input type="hidden" name="trace_id" id="trace_id" value=""/>  
 <div class="form-group"> 
    <label for="account"><?php get_phrase('item_name') ?></label>
    <input type="text" class="form-control" maxlength="30" name="item_name" id="item_name"/>   
  </div> 
        
  <div class="form-group"> 
    <label for="p-type"><?php get_phrase('item_amount') ?></label>
   <input type="text" class="form-control" maxlength="30" name="item_amount" id="item_amount">
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
    <div class="panel-heading"><?php get_phrase('service_list') ?></div>
    <div class="panel-body">
       <table class="scroll-table-head table table-striped table-bordered table-condensed">
        <th class="sc-col-4"><?php get_phrase('Item_name') ?></th>
    <th class="sc-col-3"><?php get_phrase('Amount') ?></th>
    <th class="sc-col-3"><?php get_phrase('action') ?></th>
       </table> 

       <div class="scroll-div">
       <table id="S-Table" class="table table-striped table-bordered table-condensed">
       <?php  if(empty($items)){
        echo "<tr><td class='sc-col-4 t_name'></td><td class='sc-col-3 t_type'></td>";
        echo "<td class='sc-col-3'></td></tr>";
       }?>
       <?php foreach($items as $list){ ?>
        
        <tr>
        <td class="sc-col-4 t_name"><?php echo $list->item_name ?></td>
        <td class="sc-col-3 t_type"><?php echo $list->amount ?></td>  
        <td class="sc-col-3"><a class="mybtn btn-info btn-xs payee-edit-btn" href="<?php echo $list->tbl_id?>"><?php get_phrase('edit') ?></a>
        <a class="mybtn btn-danger btn-xs payee-remove-btn"  href="<?php echo  site_url('Admin/add_item/remove/'. $list->tbl_id) ?>"><?php get_phrase('remove') ?></a></td>   
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
$(".scroll-div").niceScroll({
cursorwidth: "8px",cursorcolor:"#7f8c8d",cursorborderradius:"0px"
});  

$('#add-payers-payee').on('submit',function(event){  

$.ajax({
method : "POST",
url : "<?php echo site_url('Admin/add_item/insert') ?>",
data : $(this).serialize(),
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
if(data=="true"){   
sucessAlert("Saved Sucessfully"); 
$(".block-ui").css('display','none');
window.location.reload();
$('#edit-transaction')[0].reset(); 
}else{
failedAlert2(data);
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
$("#item_name").val($(main).closest("tr").find(".t_name").html()); 
$("#item_amount").val($(main).closest("tr").find(".t_type").html());  
//get table index
var tr = $(main).closest('tr');
myRow = tr.index();

return false;    
});   

$('#next').click(function(){
  window.location.href="fdManagement";   
});    

function appendRow(id){
var base='<?php echo base_url() ?>'+'Admin/customerServices/remove/'+id;    
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
var an=$("#item_name").val();
var at=$("#item_amount").val();

var x = document.getElementById("S-Table").rows[myRow].cells;
x[0].innerHTML = an;
x[1].innerHTML = at;
$("#action").val("insert");
} 
    
    

});

</script>

